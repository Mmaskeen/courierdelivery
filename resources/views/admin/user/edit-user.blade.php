@extends('layouts.master')
@section('page-title')
    <title>Admin | Edit User</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">User</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Edit User</h3>
                        </div>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert-danger">{{$error}}</div>
                            @endforeach
                        @endif
                        <form method="post" action="{{route('admin_update_user',$user->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Enter Name</label>
                                            <input type="text" value="{{$user->name}}" class="form-control" name="name" placeholder="Name">
                                            @error('name') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" value="{{$user->email}}" name="email" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Type</label>
                                            <select name="type" class="form-control">
                                                <option value="1" {{$user->role_id == 1 ? 'selected' : ''}}>Admin</option>
                                                <option value="2" {{$user->role_id == 2 ? 'selected' : ''}}>Staff</option>
                                            </select>
                                            @error('type') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Bio</label>
                                                <textarea rows="5" class="form-control" name="bio" placeholder="Enter About your description">{{$user->bio}}</textarea>
                                            </div>
                                            <div class="form-group m-0">
                                                <label class="form-label">Profile Picture</label>
                                                <input type="file" class="form-control" name="file">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Password</label>
                                                <input type="password"  class="form-control" name="password" placeholder="*****">
                                                @error('password') <div class="text-danger">{{$message}}</div>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="*****">
                                                @error('password_confirmation') <div class="text-danger">{{$message}}</div>@enderror

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

