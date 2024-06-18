<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id',3)->paginate(10);

        return view('admin.rider.all-riders',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        Role::create([
//            'id' => 3,
//            'name' => 'rider'
//        ]);
        return view('admin.rider.create-rider');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,',
        ]);

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
            'phone' => $request->phone,
            'password' => bcrypt('123123'),
            'avatar' => $name,
            'role_id' => '3'
        ]);

        return redirect(route('admin_all_rider'))->with('success','Rider Added Successfully');
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

        return view('admin.rider.edit-rider',compact('user'));
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
        $user = User::findOrFail($id);
        $name = $user->avatar;
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name  = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/users-profile/',$name);
        }

        $user->update([
            'phone' => $request->phone,
            'name' => $request->name,
            'bio' => $request->bio,
            'avatar' => $name,
        ]);

        return redirect(route('admin_all_rider'))->with('success','Rider updated Successfully');
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

        return redirect(route('admin_all_rider'))->with('success','Rider Deleted Successfully');
    }
}
