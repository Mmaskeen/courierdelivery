@extends('layouts.master')
@section('page-title')
    <title>Admin | All Users</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Users</h4>
                {{--<div class="input-group w-30">
                    <input type="text" class="form-control " value="{{request('searchOrder')}}" name="searchOrder"  id="search" placeholder="Search for...">
                    <div class="input-group-append ">
                        <button type="button" class="btn btn-primary br-tr-7 br-br-7" >
                            <i class="fa fa-search " aria-hidden="true"></i>
                        </button>
                    </div>
                </div>--}}
            </div>
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive" >
                            <table class="table card-table table-vcenter text-nowrap" id="table_id">
                                <thead>
                                <tr>
                                    <th>Name </th>
                                    <th>Email</th>
                                    <th>Type </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">
                                @forelse($users as $user)
                                    <tr>
                                        <td><span class="text-muted orderId">{{$user->name}}</span></td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role_id == 1 ? 'Admin' : 'Employee'}}</td>
                                        <td>
                                            <a href="{{route('admin_edit_user',$user->id)}}" class="at-actionbtn at-edit-icon btn" ><i class="fa fa-edit"></i></a>
                                            <form id="deleteForm{{$user->id}}"  action="{{route('admin_delete_user',[$user->id])}}" method="post" class="btnform">
                                                <input type="hidden" name="_method" value="DELETE">
                                                @method('DELETE')
                                                @csrf
                                                <button class="at-actionbtn at-deleticon d-none d-sm-block delete-user" data-id="{{$user->id}}"><i class="ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click','.delete-user',function (e) {
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




























{{--@extends('layouts.master')--}}
{{--@section('page-title')--}}
{{--    <title>Admin | All Users</title>--}}
{{--@endsection--}}
{{--@section('body')--}}
{{--    <div class="content-area">--}}
{{--        <div class="container">--}}
{{--            <div class="page-header">--}}
{{--                <h4 class="page-title">Users</h4>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                @forelse($users as $user)--}}
{{--                    <div class="col-lg-12 col-xl-4 col-sm-12">--}}
{{--                        <div class="card  mb-5">--}}
{{--                            <a href="client-detail.php">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="media mt-0">--}}
{{--                                        <figure class="rounded-circle align-self-start mb-0">--}}
{{--                                            <img src="{{asset('uploads/users-profile/'.$user->avatar)}}" alt="Generic placeholder image" class="avatar brround avatar-md mr-3">--}}
{{--                                        </figure>--}}
{{--                                        <div class="media-body">--}}
{{--                                            <h5 class="time-title p-0 mb-0 font-weight-semibold leading-normal">{{$user->name}}</h5>--}}
{{--                                        </div>--}}
{{--                                        <form action="{{route('admin_edit_user',$user->id)}}" method="get">--}}
{{--                                            <button type="submit" class="btn btn-info d-none d-sm-block mr-2"><i class="fe fe-edit-3"></i> </button>--}}
{{--                                        </form>--}}
{{--                                        <form id="deleteForm{{$user->id}}" action="{{route('admin_delete_user',[$user->id])}}" method="post" class="btnform">--}}
{{--                                            <input type="hidden" name="_method" value="DELETE">--}}
{{--                                            @csrf--}}
{{--                                            <button class="btn btn-primary d-none d-sm-block delete-user" data-id="{{$user->id}}" ><i class="fe fe-x"></i> </button>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @empty--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

