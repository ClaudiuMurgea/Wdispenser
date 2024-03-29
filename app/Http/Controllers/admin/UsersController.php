<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(){
        $users = User::all();
        return view('layouts.admin.users.index')->with('users', $users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = ['Admin', 'User']; //Role::pluck('name','name')->all();
        return view('layouts.admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'username'  => 'required|unique:users,username',
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed',
            'roles'     => 'required'
        ]);

        $data['password'] = Hash::make($data['password']);

        $data['is_admin'] = 0;
        if($data['roles'] == 'Admin'){
            $data['is_admin'] = 1;
        }

        $user = User::create($data);
        //$user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        //$roles = Role::pluck('name','name')->all();
        //$userRole = $user->roles->pluck('name','name')->all();

        return view('layouts.admin.users.edit')->with('user', $user)->with('roles', ['Admin', 'User'])->with('userRole', []);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'username'  => 'required|unique:users,username,'.$id,
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$id,
            'password'  => 'confirmed',
            'roles'     => 'required'
        ]);

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        $data['is_admin'] = 0;
        if($data['roles'] == 'Admin') $data['is_admin'] = 1;

        $user = User::find($id);
        $user->update($data);

        return redirect()->route('users_list')
                        ->with('success','User updated successfully');
    }

    public function delete(User $user) {
        $user->delete();
        return redirect()->route('users_list')
                        ->with('success','User deleted successfully');
    }
}
