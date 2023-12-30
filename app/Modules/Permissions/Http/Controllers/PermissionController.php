<?php

namespace App\Modules\Permissions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permissions\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Permission::withCount('users')->paginate();
        //$roles = Permission::paginate();

        return view('permissions::permissions.index',compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions::permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);

        $role = Permission::create($request->all());

        return redirect()->route('permissions.index')
            ->with('success', __('Role :name created!', [
                'name' => $role->name,
            ]));
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
    public function edit(Permission $role)
    {
        return view('permissions::permissions.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $role)
    {
        $request->validate([
            'name' => 'required',
            'abilities' => 'required|array',
        ]);

        $role->update($request->all());

        return redirect()->route('permissions.index')
            ->with('info', __('Role :name updated!', [
                'name' => $role->name,
            ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $role)
    {
        $role->delete();

        return redirect()->route('permissions.index')
            ->with('danger', __('Role :name deleted!', [
                'name' => $role->name,
            ]));
    }
}
