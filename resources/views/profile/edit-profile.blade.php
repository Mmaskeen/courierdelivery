@extends('layouts.master')
@section('page-title')
    <title>Admin | Edit Profile</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Edit Profile</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                </ol>

            </div>
            <div class="row row-deck">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Profile</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('update-profile',[\Illuminate\Support\Facades\Auth::user()->id])}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row mb-2">
                                    <div class="col-auto">
                                        <span class="avatar brround avatar-xl cover-image" data-image-src="{{asset('uploads/users-profile/'.\Illuminate\Support\Facades\Auth::user()->avatar)}}"></span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1 ">{{\Illuminate\Support\Facades\Auth::user()->name}}</h3>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <textarea name="bio" class="form-control" rows="5">{{\Illuminate\Support\Facades\Auth::user()->bio}}</textarea>
                                    @error('bio') <div class="text-danger">{{$message}}</div>@enderror

                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email-Address</label>
                                    <input class="form-control"  value="{{\Illuminate\Support\Facades\Auth::user()->email}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" name="old_password" class="form-control" placeholder="Old Password"/>
                                    @error('old_password') <div class="text-danger">{{$message}}</div>@enderror

                                </div>
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="New Password"/>
                                    @error('password') <div class="text-danger">{{$message}}</div>@enderror

                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"/>
                                    @error('password_confirmation') <div class="text-danger">{{$message}}</div>@enderror

                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

@endsection
