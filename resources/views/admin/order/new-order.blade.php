@extends('layouts.master')
@section('page-title')
    <title>Admin | New Order</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Order Detail </h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">New Order</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
                </ol>
            </div>
            <div class="row row-cards">
                <div class="col-md-12 wrapper wrapper-content animated fadeInRight">
                    <div class="ibox card">
                        <div class="card-header">
                            <h5 class="card-title">Order Detail</h5>
                        </div>
                        <div class="card-body">
                            <div class="ibox-content">
                                <div class="row">

                                    <div class="col-md-12 col-lg-12">
                                        <div class="card-body p-5">
                                            <h3>
                                                <a href="javascript:void(0);" class="text-navy">
                                                    {{$order->name}}
                                                </a>
                                            </h3>
                                            <div class="mb-3">
                                                <span class="font-weight-bold h1 text-danger">{{$order->price}}</span>
                                            </div>
                                            <p class="small">
                                                {{$order->address}}
                                            </p>
                                            <h4 class="mt-4 mb-4 font-weight-semibold">Order Details</h4>
                                            <table class="table table-striped table-bordered m-top20">
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Product:</th>
                                                    <td>{{$order->name}} {{ $order->product}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Quantity:</th>
                                                    <td>{{$order->quantity}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Model</th>
                                                    <td>{{$order->model}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email</th>
                                                    <td>{{$order->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Size</th>
                                                    <td>{{$order->size}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Mobile</th>
                                                    <td>
                                                        @forelse($order->orderNumbers as $num)
                                                            {{$num->mobile}} ,
                                                        @empty
                                                            N/A
                                                        @endforelse
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">CMO Number</th>
                                                    <td>{{$order->cmo}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">City</th>
                                                    <td>{{$order->city}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Remarks</th>
                                                    <td>
                                                        @forelse($order->remarks as $remark)
                                                            {{$remark->remark}} <br>
                                                        @empty
                                                            N/A
                                                        @endforelse
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
