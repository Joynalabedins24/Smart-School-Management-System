<?php

namespace App\Http\Controllers\rolepermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        $roles = Role::all();

        return view(
            'backend.roles.usersRole',
            compact(
                'users',
                'roles'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);

        if ($user->id == auth()->id() && $request->role != 'admin'
        ) {
            return back()->with(
            'error',
            'You cannot remove your own admin role.'
            );
        }

        $user->syncRoles($request->role);

        return back()->with(
            'success',
            'Role updated successfully'
        );
    }
}
