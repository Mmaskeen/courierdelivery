@extends('layouts.master')
@section('page-title')
    <title>Admin | Reports</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class=" content-area">
                <div class="page-header">
                    <h4 class="page-title">Order Sales Reports</h4>
                    <ol class="breadcrumb">
                        {{--                        <li class="breadcrumb-item"><a href="chart-morris.html#">Charts</a></li>--}}
                        {{--                        <li class="breadcrumb-item active" aria-current="page">Morris Charts</li>--}}
                    </ol>
                </div>



                <div class="row">
                    {{--                    <div class="col-lg-6 col-md-12">--}}
                    {{--                        <div class="card">--}}
                    {{--                            <div class="card-header">--}}
                    {{--                                <h3 class="card-title">Monthly Sales (Other Cities vs Karachi)</h3>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="card-body">--}}
                    {{--                                <div class="mt-2 mb-3 text-center">--}}
                    {{--                                    <span class="dot-label bg-primary"></span><span class="mr-3 Revenue1">Other Cities</span>--}}
                    {{--                                    <span class="dot-label bg-secondary"></span><span class="mr-3 Revenue1">Karachi</span>--}}
                    {{--                                </div>--}}
                    {{--                                <div id="monthly-chart" class="chartsh chart-dropshadow"></div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="col-lg-6 col-md-12">--}}
                    {{--                        <div class="card">--}}
                    {{--                            <div class="card-header">--}}
                    {{--                                <h3 class="card-title">Yearly Sales (Other Cities vs Karachi)</h3>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="card-body">--}}
{{--                                                    <div class="mt-2 mb-3 text-center">--}}
{{--                                                        <span class="dot-label bg-primary"></span><span class="mr-3 Revenue1">Other Cities</span>--}}
{{--                                                        <span class="dot-label bg-secondary"></span><span class="mr-3 Revenue1">Karachi</span>--}}
{{--                                                    </div>--}}
                    {{--                                <div id="yearlyChart" class="chartsh chart-dropshadow"></div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div class="col-lg-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sales Report</h3>
                            </div>
                            <div class="mt-2 mb-3 text-center">
                                <span class="dot-label bg-primary"></span><span class="mr-3 Revenue1">Karachi</span>
                                <span class="dot-label bg-secondary"></span><span class="mr-3 Revenue1">Other Cities</span>
                            </div>
                            <div class="card-body">
                                <div class="mt-2 mb-3 text-center">
                                    <select id="salesReport">
                                        <option value="Daily" selected>Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>
                                <div id="salesReportChart" class="chartsh chart-dropshadow"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Staff Today Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="mt-2 mb-3 text-center">

                                    <select id="employee_id">
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="staff-activities" class="chartsh chart-dropshadow"></div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

@endsection
@section('scripts')
    {{--    <a href="chart-morris.html#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>--}}
    <script src="{{asset('assets/js/morris.js')}}"></script>
    <script>
        $(document).ready(function () {
            let salesReport = $('#salesReport').val();
            $("#salesReport").on('change',function () {
                $("#salesReportChart").empty();
                let salesReport = $("#salesReport :selected").val();
                let url = '{{route('admin_sales_report','data')}}';
                url = url.replace('data',salesReport);
                $.ajax({
                    url: url,
                    method:"GET",
                    success:function (response) {
                        console.log(response);
                        $("#salesReportChart").empty();

                        new Morris.Bar({
                            element: 'salesReportChart',
                            data: response,
                            xkey: 'period',
                            ykeys: ['karachi', 'Other City'],
                            labels: ['karachi', 'Other City'],
                            barColors: ['#ff685c', '#32cafe'],
                            xLabelAngle: 0,
                        });
                    }

                })
            });
            $.ajax({
                url:'/admin/sales/report/'+salesReport,
                method:"GET",
                success:function (response) {
                    console.log(response);
                    new Morris.Bar({
                        element: 'salesReportChart',
                        data: response,
                        xkey: 'period',
                        ykeys: ['karachi', 'Other City'],
                        labels: ['karachi', 'Other City'],
                        barColors: ['#ff685c', '#32cafe'],
                        xLabelAngle: 0,
                    });
                }

            });

            var employeeId = $("#employee_id").val();
            $("#employee_id").on('change',function () {
                var employeeId = $("#employee_id :selected").val();
                $.ajax({
                    url:'/admin/staff/activities/'+employeeId,
                    method:"GET",
                    success:function (response) {
                        $("#staff-activities").empty();
                        new Morris.Bar({
                            hideHover: 'auto',
                            element: 'staff-activities',
                            data:response,
                            xkey: 'y',
                            ykeys: ['a'],
                            labels: ['Total Income'],
                            Colors: ['#ff685c ', '#32cafe'],
                            xLabelAngle: 0
                        });
                    }

                })
            });
            $.ajax({
                url:'/admin/staff/activities/'+employeeId,
                method:"GET",
                success:function (response) {
                    new Morris.Bar({
                        element: 'staff-activities',
                        data:response,
                        xkey: 'y',
                        ykeys: ['a'],
                        labels: ['Total Income'],
                        Colors: ['#ff685c ', '#32cafe'],
                        xLabelAngle: 0
                    });
                }

            })


        });
    </script>
@endsection
