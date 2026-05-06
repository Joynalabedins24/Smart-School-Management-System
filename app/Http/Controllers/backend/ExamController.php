<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        $exams = Exam::with('classe')->paginate(10);
        return view('backend.Exam.index', compact('exams','classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('backend.Exam.create', compact('classes'));
    }

    public function store(Request $request)
    {
        Exam::create($request->all());
        return redirect()->route('exams.index')->with('success', 'Exam created');
    }
}
