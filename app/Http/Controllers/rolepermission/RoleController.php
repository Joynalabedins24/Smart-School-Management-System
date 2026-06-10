<?php

namespace App\Http\Controllers\rolepermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(10);

        return view('backend.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        return view('backend.roles.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // Super Admin delete protection
        if ($role->name == 'admin') {
            return back()->with('error', 'Admin role cannot be deleted');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }


    public function editPermissions($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::all();

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('backend.roles.permissions', compact('role','permissions','rolePermissions'));
    }

    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Permissions updated successfully');
    }
}
