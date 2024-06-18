@extends('layouts.master')
@section('page-title')
    <title>Admin | Add New Rider</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Riders</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Add New Rider</h3>
                        </div>
                        <form method="post" action="{{route('admin_store_rider')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Enter Name</label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}"  placeholder="Name" required>
                                            @error('name') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{old('email')}}"  placeholder="Email.." required>
                                            @error('email') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Phone</label>
                                            <input type="number" class="form-control" name="phone" value="{{old('phone')}}"  placeholder="Phone">
                                            @error('phone') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Notes</label>
                                                <textarea rows="5" class="form-control" name="bio"   placeholder="Enter About your description">{{old('bio')}}</textarea>
                                            </div>
                                            <div class="form-group m-0">
                                                <label class="form-label">Profile Picture</label>
                                                <input type="file" class="form-control" accept="image/*" name="file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Add Rider</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


