<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function index()
    {
        $student = Student::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('backend.Students.profile',compact('student'));
    }
}
