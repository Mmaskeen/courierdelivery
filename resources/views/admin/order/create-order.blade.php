

@extends('layouts.master')
@section('page-title')
    <title>Admin | Add New Order</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Orders</h4>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Add New Order</h3>
                        </div>
                        <form method="post" action="{{route('admin_store_order')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Shop Name</label>
                                            <input type="text" class="form-control" value="{{old('shop_name')}}" name="shop_name" placeholder="Shop Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Enter Name</label>
                                            <input type="text" class="form-control" value="{{old('customer_name')}}" name="customer_name" placeholder="Name">
                                            @error('customer_name') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Product</label>
                                            <input type="text" class="form-control" value="{{old('product_url')}}" name="product_url" placeholder="Product">
                                            @error('product_url') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" value="{{old('customer_email')}}" name="customer_email" placeholder="Email..">
                                            @error('customer_email') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group m-0" id="mobileDiv">
                                            <label class="form-label">Mobile</label>
                                            <input type="text"  class="form-control mobile" value="" name="mobile[]" placeholder="Mobile Number" required>
                                            <button class="at-plusicon" id="addNumber"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            @error('mobile') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <select class="form-control cities" name="city" data-placeholder="Choose City">
                                                <option value="" disabled selected>Select The City</option>
                                                @forelse($cities as $city)
                                                    <option value="{{$city->name}}"  {{ old('city') == $city->name ? "selected" : "" }}>{{$city->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('city') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
{{--                                        <div class="form-group">--}}
{{--                                            <label class="form-label">Postal Code</label>--}}
{{--                                            <input type="text" class="form-control" value="{{old('customer_postal_code')}}" name="customer_postal_code" placeholder="Postal Code">--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="col-md-6">
{{--                                        <div class="form-group">--}}
{{--                                            <label class="form-label">Order Id</label>--}}
{{--                                            <input type="text" class="form-control" value="{{old('order_number')}}" name="order_number" placeholder="Order Id">--}}
{{--                                            @error('order_number') <div class="text-danger">{{$message}}</div>@enderror--}}

{{--                                        </div>--}}
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" value="{{old('customer_address')}}" name="customer_address" placeholder="Address">
                                            @error('customer_address') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group m-0">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" class="form-control" value="{{old('product_quantity')}}" name="product_quantity" placeholder="Quantity">
                                            @error('product_quantity') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control" value="{{old('price')}}" name="price" placeholder="Price">
                                            @error('price') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Currency</label>
                                            <input type="text" class="form-control" value="Pkr" name="currency" placeholder="Currency">
                                            @error('currency') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Remarks</label>
                                            <input type="text" class="form-control" name="remarks" value="{{old('remarks')}}" placeholder="Remarks">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Add Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            // $('.mobile').mask('0000-000000000000000000000000000000');
            $(document).on('click','#addNumber',function (e) {
                e.preventDefault();
                let input = '<input type="text"  class="form-control mobile " value="" name="mobile[]" placeholder="Mobile Number 2">';
                $('#mobileDiv').append(input);
                // $('.mobile').mask('0000-000000000000000000000000000000');
                $(this).hide();
            })
        });
    </script>
@endsection
