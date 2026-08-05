<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::all();

        return view('lecturers.index', compact('lecturers'));
    }
}