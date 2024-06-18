<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allUser()
    {
        $users = User::paginate(10);

        return view('admin.user.all-users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create-user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        $name='default.png';
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name  = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/users-profile/',$name);
        }

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'password' => bcrypt($request->password),
            'avatar' => $name,
            'role_id' => $request->type
        ]);

        return redirect(route('admin_all_user'))->with('success','User Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit-user',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $name = $user->avatar;
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name  = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/users-profile/',$name);
        }

        $user->update([
            'name' => $request->name,
            'role_id' => $request->type,
            'password' => $request->password !== null ? bcrypt($request->password) : $user->password,
            'bio' => $request->bio,
            'avatar' => $name,
        ]);

        return redirect(route('admin_all_user'))->with('success','User updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect(route('admin_all_user'))->with('success','User Deleted Successfully');
    }
}
