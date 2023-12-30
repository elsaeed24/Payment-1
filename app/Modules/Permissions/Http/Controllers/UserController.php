<?php

namespace App\Modules\Permissions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Permissions\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate();
        $roles = Permission::all();

        return view('permissions::users.index',[
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function show(User $user)
    {

        return view('permissions::users.show',compact('user'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $roles = Permission::all();
        $user_role = $user->roles()->pluck('id')->toArray();
        return view('permissions::users.edit',compact('user','roles','user_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $request->validate([
            'roles' => ['array'],
        ]);
        $data = $request->all(['roles']);

       // dd($request->all());
        $user->update($data);

        $user->roles()->sync($request->input('roles'));

        return redirect()->route('users.index')->with('info','User Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('error','User Deleted Successfully');
    }

}
