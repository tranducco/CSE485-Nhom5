<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    // Lưu giảng viên
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:lecturers,code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:lecturers,email',
            'phone' => 'nullable|string|max:20',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        Lecturer::create($validated);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Thêm giảng viên thành công.');
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
                Rule::unique('lecturers', 'code')
                    ->ignore($lecturer->id),
            ],

            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('lecturers', 'email')
                    ->ignore($lecturer->id),
            ],

            'phone' => 'nullable|string|max:20',

            'specialization_id' => 'required|exists:specializations,id',
        ]);

        $lecturer->update($validated);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Cập nhật giảng viên thành công.');
    }

    // Xóa giảng viên
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Xóa giảng viên thành công.');
    }
}
