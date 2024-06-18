@extends('layouts.master')
@section('page-title')
    <title>Admin | All Cities</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Cities</h4>
                <div class="input-group w-30">
                    <form action="{{route('admin_all_city')}}" method="get" class="d-flex">
                        <input type="text" class="form-control " value="{{request('searchCity')}}" name="searchCity"  id="searchCity" placeholder="Search for...">
                        <div class="input-group-append ">
                            <button type="submit" class="btn btn-primary br-tr-7 br-br-7" >
                                <i class="fa fa-search " aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @forelse($cities as $city)
                    <div class="col-lg-12 col-xl-4 col-sm-12">
                        <div class="card  mb-5">
                            <a href="client-detail.php">
                                <div class="card-body">
                                    <div class="media mt-0">
                                        <div class="media-body">
                                            <h5 class="time-title p-0 mb-0 font-weight-semibold leading-normal">{{$city->name}}</h5>
                                        </div>
                                        <form action="{{route('admin_edit_city',$city->id)}}" method="get" >
                                            <button type="submit" class="btn btn-info d-none d-sm-block mr-2"><i class="fe fe-edit-3"></i> </button>
                                        </form>
                                        <form id="deleteForm{{$city->id}}" action="{{route('admin_delete_city',[$city->id])}}" method="post" class="btnform">
                                            <input type="hidden" name="_method" value="DELETE">
                                            @csrf
                                            <button class="btn btn-primary d-none d-sm-block delete-city" data-id="{{$city->id}}" ><i class="fe fe-x"></i> </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 col-xl-4 col-sm-12">
                        <h3>No data found</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click','.delete-city',function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.value) {
                        $('#deleteForm'+id).submit();
                    }
                })
            }) ;


        });
    </script>
@endsection
