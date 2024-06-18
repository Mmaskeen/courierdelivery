@extends('layouts.master')
@section('page-title')
    <title>Admin | Add New User</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Users</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Add New User</h3>
                        </div>
                        <form method="post" action="{{route('admin_store_user')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Enter Name</label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}"  placeholder="Name">
                                            @error('name') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{old('email')}}"  placeholder="Email..">
                                            @error('email') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Type</label>
                                            <select name="type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="1" {{old('type' == "1" ? 'selected' : '')}}>Admin</option>
                                                <option value="2" {{old('type' == "2" ? 'selected' : '')}}>Staff</option>
                                            </select>
                                            @error('type') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Bio</label>
                                                <textarea rows="5" class="form-control" name="bio"   placeholder="Enter About your description">{{old('bio')}}</textarea>
                                            </div>
                                            <div class="form-group m-0">
                                                <label class="form-label">Profile Picture</label>
                                                <input type="file" class="form-control" accept="image/*" name="file">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-0">
                                                <label class="form-label">Password</label>
                                                <input type="password" name="password"   class="form-control" placeholder="Password">
                                                @error('password') <div class="text-danger">{{$message}}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-0">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation"   class="form-control" placeholder="Confirm Password">
                                                @error('password_confirmation') <div class="text-danger">{{$message}}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Add User</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


