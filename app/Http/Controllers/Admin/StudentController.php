<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        // with('user') để eager load, tránh lỗi N+1 query
        $students = Student::with(['user', 'specialization'])->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    // 1. Hàm hiển thị form Thêm mới
    public function create()
    {
        $specializations = Specialization::all();
        return view('admin.students.create', compact('specializations'));
    }

    // 2. Hàm xử lý lưu dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'student_code' => 'required|unique:students,student_code',
            'class_name' => 'required|string|max:50',
            'specialization_id' => 'required|exists:specializations,id'
        ], [
            'email.unique' => 'Email này đã được sử dụng!',
            'student_code.unique' => 'Mã sinh viên này đã tồn tại!',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'specialization_id' => $request->specialization_id,
                'student_code' => $request->student_code,
                'class_name' => $request->class_name,
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Thêm sinh viên thành công!');
    }
    // Hiển thị form sửa sinh viên
    public function edit(Student $student)
    {
        // Lấy danh sách chuyên môn để hiện ra thẻ <select>
        $specializations = \App\Models\Specialization::all(); 
        return view('admin.students.edit', compact('student', 'specializations'));
    }

    // Xử lý lưu dữ liệu cập nhật
    public function update(Request $request, Student $student)
    {
        // 1. Validate dữ liệu cho cả 2 bảng
        $request->validate([
            // Khai báo cho bảng users (cần loại trừ ID của user đang liên kết)
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            
            // Khai báo cho bảng students (cần loại trừ ID của student hiện tại)
            'student_code' => 'required|string|unique:students,student_code,' . $student->id,
            'specialization_id' => 'required|exists:specializations,id',
            'class_name' => 'nullable|string|max:255',
        ]);

        // 2. Sử dụng Transaction để lưu đồng thời vào 2 bảng
        DB::transaction(function () use ($request, $student) {
            
            // Cập nhật thông tin vào bảng users trước
            $student->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Cập nhật các thông tin còn lại vào bảng students
            $student->update([
                'student_code' => $request->student_code,
                'specialization_id' => $request->specialization_id,
                'class_name' => $request->class_name,
            ]);
            
        });

        return redirect()->route('admin.students.index')->with('success', 'Cập nhật thông tin sinh viên thành công!');
    }

    // Xử lý xóa sinh viên
    public function destroy(Student $student)
    {
        // QUY TẮC CHẶN XÓA: Kiểm tra xem sinh viên có đơn đăng ký đề tài nào không
        // (Yêu cầu cậu phải có hàm topicRegistrations() trong model Student nhé)
        if ($student->topicRegistrations()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa! Sinh viên này đang có đơn đăng ký đề tài.');
        }

        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Đã xóa sinh viên thành công!');
    }
}
