<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    // Danh sách giảng viên
    public function index()
    {
        $lecturers = Lecturer::with('specialization')
            ->orderBy('id', 'desc')
            ->get();

        return view('lecturers.index', compact('lecturers'));
    }

    // Form thêm giảng viên
    public function create()
    {
        $specializations = Specialization::orderBy('name')->get();

        return view('lecturers.create', compact('specializations'));
    }

    // Xử lý thêm giảng viên
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào (Đã sửa lỗi unique query đúng cột 'code')
        $request->validate([
            'code' => 'required|string|unique:lecturers,code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|min:6', 
            'phone' => 'nullable|string',
            'specialization_id' => 'required|exists:specializations,id',
        ], [
            'code.unique' => 'Mã giảng viên này đã tồn tại!',
            'email.unique' => 'Email này đã được sử dụng cho một tài khoản khác!',
            'password.required' => 'Vui lòng nhập mật khẩu cho giảng viên.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        // 2. Sử dụng Transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::transaction(function () use ($request) {
            
            // BƯỚC A: TẠO TÀI KHOẢN ĐĂNG NHẬP (USER) - Khắc phục lỗi lưu sai role
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'lecturer'; // Ép cứng role là giảng viên
            $user->save(); // Lưu trực tiếp để vượt qua mảng $fillable

            // BƯỚC B: TẠO THÔNG TIN PROFILE (LECTURER)
            Lecturer::create([
                'user_id' => $user->id,
                'code' => $request->code, 
                'name' => $request->name, 
                'email' => $request->email, 
                'specialization_id' => $request->specialization_id,
                'phone' => $request->phone,
            ]);
            
        });

        return redirect()->route('lecturers.index')
                        ->with('success', 'Thêm giảng viên và cấp tài khoản thành công!');
    }

    // Form sửa giảng viên
    public function edit(Lecturer $lecturer)
    {
        $specializations = Specialization::orderBy('name')->get();

        return view('lecturers.edit', compact(
            'lecturer',
            'specializations'
        ));
    }

    // Cập nhật giảng viên
    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lecturers', 'code')->ignore($lecturer->id),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                // Bắt buộc email không trùng trong bảng users (trừ user_id hiện tại của giảng viên)
                Rule::unique('users', 'email')->ignore($lecturer->user_id),
            ],
            'phone' => 'nullable|string|max:20',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        // Sử dụng Transaction để update đồng bộ cả bảng lecturers và bảng users
        DB::transaction(function () use ($validated, $lecturer) {
            
            // 1. Cập nhật thông tin profile
            $lecturer->update($validated);

            // 2. Cập nhật thông tin tài khoản đăng nhập
            if ($lecturer->user_id) {
                User::where('id', $lecturer->user_id)->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);
            }
        });

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Cập nhật giảng viên thành công.');
    }

    // Xóa giảng viên
    public function destroy(Lecturer $lecturer)
    {
        // Dùng transaction để xóa cả profile giảng viên và tài khoản User tương ứng
        DB::transaction(function () use ($lecturer) {
            $userId = $lecturer->user_id;
            
            $lecturer->delete();
            
            if ($userId) {
                User::where('id', $userId)->delete();
            }
        });

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Xóa giảng viên và tài khoản đăng nhập thành công.');
    }
}