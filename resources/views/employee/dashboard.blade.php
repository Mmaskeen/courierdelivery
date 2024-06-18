@extends('layouts.master')
@section('page-title')
    <title>Employee Dashboard</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Overall Orders</h4>

            </div>

            <div class="row row-cards">
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'overAll', 'statusFilter' => 'Latest'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-shopping-cart text-primary"></i><strong> {{$overAll['latestOrders']}}</strong></div>
                                <div class="text-muted mb-0"> Latest Orders</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'overAll', 'statusFilter' => 'Canceled'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-times text-primary"></i><strong> {{$overAll['totalCanceled']}}</strong></div>
                                <div class="text-muted mb-0"> Total Canceled</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'overAll', 'statusFilter' => 'Proceeded'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-rocket text-primary"></i><strong> {{$overAll['totalProcessed']}}</strong></div>
                                <div class="text-muted mb-0"> Total Processed</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'overAll', 'statusFilter' => 'Hold Order'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-pause text-primary"></i><strong> {{$overAll['totalHolderOrders']}}</strong></div>
                                <div class="text-muted mb-0"> Total Holder Orders</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>


            <div class="page-header">
                <h4 class="page-title">Today Orders</h4>
            </div>

            <div class="row row-cards">

                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'today', 'statusFilter' => 'Dispatched'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-truck text-info"></i><strong> {{$today['totalDispatched']}}</strong></div>
                                <div class="text-muted mb-0"> Today Dispatched</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'today', 'statusFilter' => 'Canceled'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-times text-info"></i><strong> {{$today['totalCanceled']}}</strong></div>
                                <div class="text-muted mb-0"> Today Canceled</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_all_order',['type' => 'today', 'statusFilter' => 'Hold Order'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-pause text-info"></i><strong> {{$today['totalHolderOrders']}}</strong></div>
                                <div class="text-muted mb-0"> Today Holder Orders</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{route('employee_trashed_order',['type' => 'today'])}}">
                            <div class="card-body text-center">
                                <div class="h1 m-0"><i class="fa fa-rocket text-info"></i><strong> {{$today['todayTrashed']}}</strong></div>
                                <div class="text-muted mb-0"> Today Trashed</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-cards">
                <div class="col-lg-12 col-sm-12 col-xl-8">
                    <div class="card text-center overflow-hidden ">
                        <div class="card-header">
                            <h3 class="card-title">Overall Status</h3>
                        </div>
                        <div class="card-body">
                            <span>This Graph is Showing the Comparison between orders on the base of their status </span>

                            <div id="bar-chart" class="chartsh chart-dropshadow"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div class="card  overflow-hidden ">
                        <div class="card-header">
                            <h3 class="card-title">Orders By Category</h3>
                        </div>
                        <div class="card-body text-center">
                            <div id="morrisBar8" class="chart-dropshadow h-230"></div>
                            <div class="mt-2 text-center">
                                <p style="float: left;"><span class="dot-label bg-primary"></span><span class="mr-3">Canceled</span></p>
                                <p style="float: left;"><span class="dot-label bg-secondary"></span><span class="mr-3">On Hold</span></p>
                                <p style="float: left;"><span class="dot-label bg-dispatch"></span><span class="mr-3">Dispatched</span></p>
                                <p style="float: left;"><span class="dot-label bg-warning"></span><span class="mr-3">Proceeded</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Latest Orders</h3>
                            <div class="input-group w-30 ml-auto">
                                <input type="text" class="form-control " id="search" placeholder="Search for...">
                                <span class="input-group-append">
                                    <button class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                                </span>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="order_table">
                                <thead>
                                <tr>
                                    <th class="w-1">Order ID <i class="ion-arrow-down-b sorting-orders" data-type="desc" data-column="id"></i><i class="ion-arrow-up-b sorting-orders" data-type="asc" data-column="id"></i></th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('employee.order.status-modal');
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
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
                        Swal.fire({
                            title: "Success!",
                            text: "Status Updated Successfully",
                            icon: "success",
                        });

                    }else{
                        Swal.fire({
                            title: "error!",
                            text: "Something went wrong",
                            icon: "error",

                        });
                    }
                });

            });
            $("#search").bind('blur keyup', function(e) {
                if (e.type === 'blur' || e.keyCode === 13) {
                    e.preventDefault();
                    let url = "{{route('employee_all_order', ['searchOrder' => 'searchValue'])}}";
                    url = url.replace('searchValue', $(this).val());
                    $.get(url, function (response) {
                        $('#mainTableBody').empty();
                        $('#mainTableBody').append(response);
                    });
                }
            });
        });

        var bar = new Morris.Bar({
            element: 'bar-chart',
            data: <?php print_r(json_encode($chartData)) ?>,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Tickets', 'Projects'],
            gridTextSize: 12,
            resize: true,
            barColors: function(row, series, type){
                if(series.key == 'a'){
                    if(row.y > 4){
                        return "#d22d2d";
                    }else{
                        return "#0b62a4"
                    }
                }else{
                    return "#7a92a3"
                }
            },
            hideHover: true
        });

        new Morris.Donut({
            element: 'morrisBar8',
            data: <?php print_r(json_encode($finalDataStatusChart))?>,
            colors: ['#ff685c ', '#32cafe', '#6768a8','#fdb561'],
            formatter: function(x) {
                return x + "%"
            }
        }).on('click', function(i, row) {
            console.log(i, row);
        });


    </script>
@endsection
