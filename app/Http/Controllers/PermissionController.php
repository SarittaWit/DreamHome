<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('permissions.index', compact('roles'));
    }

    public function create()
    {
        $roles = \App\Models\Role::all();
        return view('permissions.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        Permission::create($request->only('name', 'role_id'));
        return redirect()->route('permissions.index')->with('success', 'Permission ajoutée.');
    }
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        $permission->update($request->only('name', 'role_id'));
        return redirect()->route('permissions.index')->with('success', 'Permission modifiée.');
    }
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission supprimée.');
    }
    public function syncPermissions(Request $request, $roleId)
    {
        $role = \App\Models\Role::findOrFail($roleId);
        $role->permissions()->sync($request->permissions ?? []);
        return back()->with('success', 'Permissions mises à jour');
    }


}
