<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Specialization;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    // Hiển thị danh sách giảng viên
    public function index()
    {
        // Lấy giảng viên kèm thông tin chuyên ngành
        $lecturers = Lecturer::with('specialization')->get();

        return view('lecturers.index', compact('lecturers'));
    }


    // Hiển thị form thêm giảng viên
    public function create()
    {
        // Lấy danh sách chuyên ngành để chọn
        $specializations = Specialization::all();

        return view('lecturers.create', compact('specializations'));
    }


    // Lưu giảng viên mới
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:lecturers,code',
            'name' => 'required',
            'email' => 'required|email|unique:lecturers,email',
            'phone' => 'nullable',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        Lecturer::create([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization_id' => $request->specialization_id,
        ]);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Thêm giảng viên thành công');
    }
}