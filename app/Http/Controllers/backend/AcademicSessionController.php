<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::latest()->get();

        return view('backend.AcademicSessions.index',compact('sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|unique:academic_sessions,name'
        ]);

        AcademicSession::create([
        'name' => $request->name
        ]);

        return redirect()->back()->with('success','Session Created Successfully!');
    }


    public function active($id)
    {
        AcademicSession::query()
            ->update([
                'is_active' => false
            ]);

        AcademicSession::find($id)
            ->update([
                'is_active' => true
            ]);

        return redirect()->back()->with('success','Active Session Updated!');
    }
}
