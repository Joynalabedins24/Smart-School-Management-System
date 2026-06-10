<?php

namespace App\Http\Controllers\rolepermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        // 🔍 Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 📦 Group filter (module)
        if ($request->module) {
            $query->where('module', $request->module);
        }

        $permissions = $query->latest()->paginate(10);

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'module' => 'required'
        ]);

        Permission::create([
            'name' => $request->name,
            'module' => $request->module,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);

        return view('backend.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'module' => 'required'
        ]);

        $permission->update([
            'name' => $request->name,
            'module' => $request->module
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return back()->with('success', 'Permission deleted');
    }
}
