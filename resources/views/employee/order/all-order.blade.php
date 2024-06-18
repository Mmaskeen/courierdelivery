@extends('layouts.master')
@section('page-title')
    <title>Employee | All Orders</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Orders</h4>
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
                @if( request('type') == 'overAll' && request('statusFilter') == 'Latest' ||request('type') == 'today')
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-pink">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            <h3 class="mb-0">{{request('statusFilter') == 'Latest' ? $overAllLP['latestOrders'] : $todayOrder['latestOrders'] }}</h3>
                                            <p class="text-white mt-1">Latest</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-teal">
                            <a href="{{route('employee_dispatch_orders')}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="mt-4 mb-0 text-white">
                                                <h3 class="mb-0">{{$todayOrder['totalDispatched'] }}</h3>
                                                <p class="text-white mt-1">Dispatched </p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <i class="fa fa-truck mt-3 mb-0"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-blue">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            <h3 class="mb-0">{{request('statusFilter') == 'Latest' ? $overAllOrder['totalProcessed'] : $todayOrder['totalProcessed'] }}</h3>
                                            <p class="text-white mt-1">Processed</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-purple">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            <h3 class="mb-0">{{$todayOrder['totalHolderOrders'] }}</h3>
                                            <p class="text-white mt-1">Hold Orders </p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(request('statusFilter') == 'Latest' && request('type') == 'overAll')
                        <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                            <div class="card card-counter bg-gradient-purple">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="mt-4 mb-0 text-white">
                                                <h3 class="mb-0">{{$todayOrder['totalCanceled'] }}</h3>
                                                <p class="text-white mt-1">canceled Orders </p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <i class="fa fa-truck mt-3 mb-0"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @elseif(request('type') == 'overAll' && request('statusFilter') == 'Hold Order' || request('type') == 'overAll' && request('statusFilter') == 'Dispatched'  || request('type') == 'overAll'&& request('statusFilter') == 'Proceeded' || request('type') == 'overAll' && request('statusFilter') == 'Canceled' )
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-blue">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            <h3 class="mb-0">
                                                @switch(request('statusFilter'))
                                                    @case('Hold Order')
                                                    {{$overAllStatusBased['karachiHolder']}}
                                                    @break
                                                    @case('Proceeded')
                                                    {{$overAllStatusBased['karachiProceeded']}}
                                                    @break
                                                    @case('Dispatched')
                                                    {{$overAllStatusBased['karachiDispatched']}}
                                                    @break
                                                    @default
                                                    {{$overAllStatusBased['karachiCancelled']}}
                                                @endswitch
                                            </h3>
                                            <p class="text-white mt-1">Karachi</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-purple">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            <h3 class="mb-0">
                                                @switch(request('statusFilter'))
                                                    @case('Hold Order')
                                                    {{$overAllStatusBased['otherCityHolder']}}
                                                    @break
                                                    @case('Proceeded')
                                                    {{$overAllStatusBased['otherCityProceeded']}}
                                                    @break
                                                    @case('Dispatched')
                                                    {{$overAllStatusBased['otherCityDispatched']}}
                                                    @break
                                                    @default
                                                    {{$overAllStatusBased['otherCityCancelled']}}
                                                @endswitch
                                            </h3>
                                            <p class="text-white mt-1">Other City </p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-secondary shadow-secondary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            @if(request('fromDate') != 'null' && request('toDate') != 'null' || request('cityFilter') != 'null' ||
                                             request('statusFilter') != 'null' || request('page'))
                                                <h3 class="mb-0">{{$filterTotalCanceled}}</h3>
                                            @else
                                                <h3 class="mb-0">{{$totalCanceled}}</h3>
                                            @endif
                                            <p class="text-white mt-1">Canceled Orders </p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">--}}
                    {{--                        <div class="card card-counter bg-gradient-primary shadow-primary">--}}
                    {{--                            <div class="card-body">--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <div class="col-8">--}}
                    {{--                                        <div class="mt-4 mb-0 text-white">--}}
                    {{--                                            @if(request('fromDate') != 'null' && request('toDate') != 'null' || request('cityFilter') != 'null' ||--}}
                    {{--                                            request('statusFilter') != 'null' || request('page')  )--}}
                    {{--                                                <h3 class="mb-0">{{$filterTotalDispatched}}</h3>--}}
                    {{--                                            @else--}}
                    {{--                                                <h3 class="mb-0">{{$totalDispatched}}</h3>--}}
                    {{--                                            @endif--}}
                    {{--                                            <p class="text-white mt-1">Dispatched Orders </p>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="col-4">--}}
                    {{--                                        <i class="fa fa-truck mt-3 mb-0"></i>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-counter bg-gradient-purple shadow-secondary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="mt-4 mb-0 text-white">
                                            @if(request('fromDate') != 'null' && request('toDate') != 'null' || request('cityFilter') != 'null' || request('statusFilter') != 'null'  || request('page'))
                                                <h3 class="mb-0">{{$filterTotalHold}}</h3>
                                            @else
                                                <h3 class="mb-0">{{$totalHold}}</h3>
                                            @endif
                                            <p class="text-white mt-1">Hold Orders </p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-truck mt-3 mb-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-inline-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="card-title float-left">Latest Orders</h3>

                                </div>
                                <div class="w-100 mt-2"></div>
                                <div class="col-sm-12">
                                    <ul class="order_filters static">
                                        <form id="orderFilterForm" class="filterform" action="{{route('employee_filter_order')}}" method="get">
                                            <input type="hidden" name="type" value="{{request('type')}}">
                                            <li>
                                                <div class="input-group float-right">
                                                    <input type="text" class="form-control " value="{{request('searchOrder')}}" name="searchOrder"  id="search" placeholder="Search for...">
                                                    <div class="input-group-append ">
                                                        <button type="button" class="btn btn-primary br-tr-7 br-br-7" >
                                                            <i class="fa fa-search " aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ml-0">
                                                <div class="at-dateholder">
                                                    <div class="at-startdate">
                                                        <span>From</span>
                                                        <div class="input-group date" data-provide="datepicker">
                                                            <input type="text" name="fromDate" value="{{request()->has('fromDate') ? request('fromDate') : ''}}" autocomplete="off" class="form-control orderDateFilter">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar at-calendericon" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="at-enddate">
                                                        <span>To</span>
                                                        <div class="input-group date" data-provide="datepicker">
                                                            <input type="text" name="toDate" value="{{request()->has('toDate') ? request('toDate') : ''}}" autocomplete="off" class="form-control orderDateFilter">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar at-calendericon" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <select name="shopName" class="form-control order-filter" id="shopName">
                                                    <option value="" disabled selected>Select Shop</option>
                                                    <option value="all"{{ request('shopName') == 'all' ? "selected" : "" }}>All</option>
                                                    @if($shopNames)
                                                        @foreach($shopNames as $shopName)
                                                            @if($shopName->shop_name !== null)
                                                                <option  value="{{$shopName->shop_name}}" {{ request('shopName') == $shopName->shop_name ? "selected" : "" }}>{{$shopName->shop_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </li>
                                            <li>
                                                <select class="form-control cities order-filter" name="cityFilter" data-placeholder="Choose City">
                                                    <option value="" disabled selected>Select The City</option>
                                                    <option value="all"  {{ request('cityFilter') == 'all' ? "selected" : "" }}>All City</option>
                                                    @foreach($orderCity as $city)
                                                        <option value="{{$city->city}}"  {{ request('cityFilter') == $city->city ? "selected" : "" }}>{{$city->city}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                            @if(request('statusFilter') === 'Dispatched')
                                                <li>
                                                    <select name="dispatchBy" class="form-control order-filter">
                                                        <option value="" disabled selected>Dispatch By</option>
                                                        <option value="all"  {{ request('dispatchBy') == 'all' ? "selected" : "" }}>All</option>
                                                        <option value="Tcs" {{request('dispatchBy')  == 'Tcs' ? 'selected' : ''}}>Tcs</option>
                                                        <option value="Stallion" {{request('dispatchBy')  == 'Stallion' ? 'selected' : ''}}>Stallion</option>
                                                        @forelse($riders as $rider)
                                                            <option value="{{$rider->id}}" {{request('dispatchBy')  == $rider->id ? 'selected' : ''}}>{{$rider->name}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </li>
                                            @endif
                                            <li>
                                                <select name="statusFilter" class="form-control order-filter">
                                                    <option value="" disabled selected>Select The status</option>
                                                    <option value="Hold Order" {{request('statusFilter')  == 'Hold Order' || request('status') == 'Hold Order' ? 'selected' : ''}}>On Hold</option>
                                                    <option value="Dispatched" {{request('statusFilter')  == 'Dispatched' || request('status') == 'Dispatched' ? 'selected' : ''}}>Dispatch</option>
                                                    <option value="Latest" {{request('statusFilter')  == 'Latest' || request('status') == 'Latest' ? 'selected' : ''}}>Latest</option>
                                                    <option value="Canceled" {{request('statusFilter')  == 'Canceled' || request('status') == 'Canceled' ? 'selected' : ''}}>Canceled</option>
                                                    <option value="Proceeded" {{request('statusFilter')  == 'Proceeded' || request('status') == 'Proceeded' ? 'selected' : ''}}>Proceeded</option>
                                                </select>
                                            </li>
                                            <li>
                                                <select name="dispatch_status" class="form-control" id="dispatchStatus">
                                                    <option value="" disabled selected>Select dispatch Status</option>
                                                    <option value="all"  {{ request('dispatch_status') == 'all' ? "selected" : "" }}>All</option>
                                                    @forelse($dispatchOrderStatus as $dos)
                                                        @if($dos->dispatch_status !== null && $dos->dispatch_status !== '')
                                                            <option  value="{{$dos->dispatch_status}}" {{request('dispatch_status')  == $dos->dispatch_status ? 'selected' : ''}}>{{$dos->dispatch_status}}</option>
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </li>
                                        </form>
                                        <li class="exportas">
                                            <div class="filter-export">
                                                <form action="{{route('employee_sync_record')}}" method="get">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-recycle mr-2"></i>Sync Record</button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" >
                            <table class="table card-table table-vcenter text-nowrap" id="table_id">
                                <thead>
                                <tr>
                                    <th class="w-1">Order ID <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="id"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="id"></i></th>
                                    @if(request('statusFilter') === 'Dispatched')
                                        <th class="w-1">CN</th>
                                        <th class="w-1">Dispatch Status</th>
                                    @endif
                                    <th>Name <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="name"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="name"></i></th>
                                    <th>Product URL <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="product"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="product"></i></th>
                                    <th>Address <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="address"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="address"></i></th>
                                    <th>City <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="city"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="city"></i></th>
                                    <th>Cell Number</th>
                                    <th>QTY <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="quantity"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="quantity"></i></th>
                                    <th>Price <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="price"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="price"></i></th>
                                    <th>Status <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="status"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="status"></i></th>
                                    <th>Date <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="created_at"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="created_at"></i></th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">
                                @include('employee.order.order-table')
                                </tbody>
                            </table>

                            {{ $orders->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('employee.order.status-modal')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change','.order-filter',function (e) {
                $('#orderFilterForm').submit();
            });
            $(document).on('click','.isReturned',function (e) {
                if($(this).prop("checked") == false){
                    toastr.error('You are not allowed to change this', 'error!');
                    $(this).prop("checked", true);
                }else{
                    let order_id = $(this).attr('data-id');
                    let url = '{{route('employee_received_parcel','id')}}';
                    url = url.replace('id',order_id);
                    let data ={
                        '_token' : '{{csrf_token()}}'
                    };

                    swal.fire({
                        title: "Did you receive the parcel?",
                        text: "You will not be able to revert this action!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sure'
                    }).then((result) => {
                        if (result.value) {
                            $.post(url,data,function (response) {
                                if (response.status == 'success'){
                                    toastr.success('Parcel received successfully', 'success!');
                                }
                            });
                        } else {
                            swal.fire(  "Your data is safe!");
                            $(this).prop("checked", false);

                        }
                    });
                }
            });

            $(document).on('click','.changeStatus',function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let value = $(this).data('value');

                let url ='{{route('employee_update_order_status','id')}}'
                url = url.replace('id',id);
                let data = {
                    '_token' : '{{csrf_token()}}',
                    'status' : value
                }
                $.post(url,data,function (response) {
                    if(response.status == 'success'){
                        // $("#table_id").load(window.location + " #table_id");
                        setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                        toastr.success('Status Updated Successfully', 'Success!')

                    }else{
                        toastr.error('Something went wrong', 'error!')
                    }
                });

            });
            $(document).on('change','.orderDateFilter',function (e) {
                e.preventDefault();
                let fromDate = $('input[name="fromDate"]').val();
                let toDate = $('input[name="toDate"]').val();
                let url = '{{route('employee_filter_order')}}';
                let data = {
                    "fromDate" : fromDate,
                    "toDate" : toDate,
                };
                if(fromDate && toDate){
                    $('#orderFilterForm').submit();
                };
            });

            $("#search").bind('blur keyup', function(e) {
                if (e.type === 'blur' || e.keyCode === 13) {
                    e.preventDefault();
                    $('#orderFilterForm').submit();

                    {{--let val = $(this).val();--}}
                    {{--let url = "{{route('admin_all_order', ['searchOrder' => 'searchValue'])}}&fromDate=" + $('input[name=fromDate]').val() + "&toDate=" + $('input[name=toDate]').val() + "&statusFilter=" + $('select[name=statusFilter]').val() + "&cityFilter=" + $('select[name=cityFilter]').val();--}}
                    {{--url = url.replace('searchValue', val);--}}
                    {{--$.get(url, function (response) {--}}
                    {{--    $('#mainTableBody').empty();--}}
                    {{--    $('#mainTableBody').append(response);--}}
                    {{--});--}}
                }
            });

            $(document).on('change',"select[name='dispatch_status']",function (e) {
                e.preventDefault();
                let dispatch_status = $(this).val();
                if(dispatch_status !== ''){
                    $('#orderFilterForm').submit();
                };
            });

            $("select[name='bulk-action']" ).on('change',function (e) {
                e.preventDefault();
                let type = $( "#deleteAll option:selected" ).data('type');
                let value = $( "#deleteAll option:selected" ).val();
                let orders =[];
                $("input:checkbox[name=orderCheck]:checked").each(function(){
                    orders.push($(this).data('id'));
                });

                if (orders.length == 0 ){
                    toastr.error('Please Select at least one order ', 'error!')
                }else{
                    let data = { "orders": orders,"_token": "{{ csrf_token() }}","_method" : "DELETE","action" : type,"statusType" : value};
                    let url = "{{route('employee_delete_multiple_order')}}";

                    swal.fire({
                        title: "Are you sure?",
                        text: "You will not be able to revert this action!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sure'
                    }).then((result) => {
                        if (result.value) {
                            $.post(url,data,function (response) {
                                if(response.status == 'success'){

                                    $('#mainTableBody').empty().append(response.view);

                                    if(response.action == 'delete'){
                                        toastr.success('Orders Deleted Successfully', 'Success!')
                                    }else{
                                        toastr.success('Status Updated Successfully', 'Success!')
                                    }

                                    setTimeout(function(){// wait for 5 secs(2)
                                        location.reload(); // then reload the page.(3)
                                    }, 10);
                                    $('.checkboxes').prop("checked",false);
                                    $(".checkboxes").attr("autocomplete", "off");
                                    $('#totalSelected').empty();
                                }else{
                                    toastr.error('Something went wrong', 'error!')
                                }
                            });
                        } else {
                            swal.fire(  "Your data is safe!");
                        }
                    });
                }
            });
        });
    </script>
@endsection
