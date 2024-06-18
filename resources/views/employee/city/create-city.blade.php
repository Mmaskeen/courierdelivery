@extends('layouts.master')
@section('page-title')
    <title>Employee | Add New City</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">City</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Add New City</h3>
                        </div>
                        <form method="post" action="{{route('employee_store_city')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Enter city Name</label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}"  placeholder="Name" required>
                                        </div>

                                    </div>
                                    <div class="card-footer text-right at-addnewcityfooter">
                                        <button type="submit" class="btn btn-primary">Add City</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


