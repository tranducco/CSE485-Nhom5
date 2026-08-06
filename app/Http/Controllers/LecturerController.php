<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::all();

        return view('lecturers.index', compact('lecturers'));
    }


    // Hiển thị form thêm giảng viên
    public function create()
    {
        return view('lecturers.create');
    }


    // Lưu giảng viên mới
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:lecturers,code',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
        ]);

        Lecturer::create([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Thêm giảng viên thành công');
    }
}
