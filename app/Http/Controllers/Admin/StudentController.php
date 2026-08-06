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
}
