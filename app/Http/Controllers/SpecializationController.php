<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecializationController extends Controller
{
    /**
     * Danh sách chuyên môn
     */
    public function index()
    {
        $specializations = Specialization::withCount([
            'lecturers',
            'students'
        ])
        ->orderBy('name')
        ->get();

        return view(
            'specializations.index',
            compact('specializations')
        );
    }

    /**
     * Form thêm chuyên môn
     */
    public function create()
    {
        return view('specializations.create');
    }

    /**
     * Lưu chuyên môn
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:specializations,code',
            'name' => 'required|string|max:100',
        ]);

        Specialization::create($validated);

        return redirect()
            ->route('specializations.index')
            ->with('success', 'Thêm chuyên môn thành công.');
    }

    /**
     * Form sửa chuyên môn
     */
    public function edit(Specialization $specialization)
    {
        return view(
            'specializations.edit',
            compact('specialization')
        );
    }

    /**
     * Cập nhật chuyên môn
     */
    public function update(
        Request $request,
        Specialization $specialization
    ) {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('specializations', 'code')
                    ->ignore($specialization->id),
            ],

            'name' => 'required|string|max:100',
        ]);

        $specialization->update($validated);

        return redirect()
            ->route('specializations.index')
            ->with('success', 'Cập nhật chuyên môn thành công.');
    }

    /**
     * Xóa chuyên môn
     */
    public function destroy(Specialization $specialization)
    {
        // Không cho xóa nếu đang có sinh viên hoặc giảng viên sử dụng
        if (
            $specialization->lecturers()->exists() ||
            $specialization->students()->exists()
        ) {
            return redirect()
                ->route('specializations.index')
                ->with(
                    'error',
                    'Không thể xóa chuyên môn đang được sử dụng.'
                );
        }

        $specialization->delete();

        return redirect()
            ->route('specializations.index')
            ->with(
                'success',
                'Xóa chuyên môn thành công.'
            );
    }
}
