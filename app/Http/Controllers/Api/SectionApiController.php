<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionApiController extends Controller
{

    //📌 All Sections
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Section::with('class')->latest()->get()
        ]);
    }

    // Create Section/Store Section
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capasity' => 'required',
            'class_id' => 'required|exists:classes,id'
        ]);

        $section = Section::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Section Created',
            'data' => $section
        ]);
    }


    //single Section
    public function show($id)
    {
        $section = Section::with('class')->find($id);

        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $section
        ]);
    }

    //Update Section
    public function update(Request $request, $id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json(['status' => false], 404);
        }

        $section->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Updated',
            'data' => $section
        ]);
    }

    //Daelete Section
    public function destroy($id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json(['status' => false], 404);
        }

        $section->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted'
        ]);
    }

    //Class wise Section
    public function byClass($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();

        return response()->json([
            'status' => true,
            'data' => $sections
        ]);
    }


}
