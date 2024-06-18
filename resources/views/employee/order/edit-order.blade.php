@extends('layouts.master')
@section('page-title')
    <title>Employee | Edit Order</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Order</h4>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Edit Order</h3>
                        </div>
                        <form method="post" action="{{route('employee_update_order',$order->id)}}" enctype="multipart/form-data" onsubmit="myButton.disabled = true; return true;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="redirectUrl" value="{{$url}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Shop Name</label>
                                            <input type="text" class="form-control" value="{{$order->shop_name}}" name="shop_name" placeholder="Shop Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Enter Name</label>
                                            <input type="text" class="form-control" value="{{$order->name}}" name="customer_name" placeholder="Name">
                                            @error('customer_name') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Product</label>
                                            <input type="text" class="form-control" value="{{$order->product}}" onclick="window.open( '{{$order->product}}')" name="product_url" placeholder="Product">
                                            @error('product_url') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" value="{{$order->email}}" name="customer_email" placeholder="Email..">
                                            @error('customer_email') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group m-0">
                                            <label class="form-label">Mobile</label>
                                            @foreach($order->orderNumbers as $number)
                                                <input type="text"  class="form-control mobile" value="{{$number->mobile}}" name="mobile[]" placeholder="Mobile Number" required>
                                            @endforeach
                                            @error('mobile') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        @if($order->status == 'Dispatched')

                                        <div class="form-group m-0">
                                            <label class="form-label">CN</label>
                                                <input type="text"  class="form-control " value="{{$order->cn}}" disabled >
                                        </div>

                                         <div class="form-group m-0">
                                            <label class="form-label">Dispatch Status</label>
                                                <input type="text"  class="form-control" value="{{$order->dispatch_status}}" name="{{$order->dispatch_by == "Tcs" || $order->dispatch_by == "Stallion" ? '' : 'dispatch_status'}}" {{$order->dispatch_by == "Tcs" || $order->dispatch_by == "Stallion" ? 'disabled' : ''}}>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <select class="form-control cities" name="city" data-placeholder="Choose City">
                                                <option value="" disabled selected>Select The City</option>
                                                @forelse($cities as $city)
                                                    <option value="{{$city->name}}"  {{ $order->city == $city->name ? "selected" : "" }}>{{$city->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('city') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group" id="dispatchBy" style="display: {{$order->dispatch_by == null ? 'none' : 'blocked'}}" >
                                            <label class="form-label">Dispatch By</label>
                                            <select class="form-control" id="dispatchSelect" name="dispatch_by" data-placeholder="Choose Service">
                                                <option value="">Select The Service</option>
                                                <option value="Tcs"{{$order->dispatch_by == 'Tcs' ? 'selected' : ''}}>Tcs</option>
                                                <option value="Stallion"{{$order->dispatch_by == 'Stallion' ? 'selected' : ''}}>Stallion</option>
                                                <option value="PostEx"{{$order->dispatch_by == 'PostEx' ? 'selected' : ''}}>PostEx</option>
                                                <option value="BlueEx"{{$order->dispatch_by == 'BlueEx' ? 'selected' : ''}}>BlueEx</option>
                                                <option value="StallionDelivery"{{$order->dispatch_by == 'StallionDelivery' ? 'selected' : ''}}>StallionDelivery</option>
                                                @forelse($riders as $rider)
                                                    <option value="{{$rider->id}}"{{$order->dispatch_by == $rider->id ? 'selected' : ''}}>{{$rider->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('dispatch_by') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group" id="dispatchCity" style="display: none">
                                            <label class="form-label">Dispatch To</label>
                                            <select class="form-control" id="dispatchTo" name="dispatch_to" data-placeholder="Choose Service">
                                                <option value="" >Select The City</option>
                                            </select>
                                            @error('dispatch_to') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group" id="dispatchRemark" style="display: none">
                                            <label class="form-label">Dispatch Remark</label>
                                            <input type="text" name="dispatch_remark"  class="form-control" value="{{$order->dispatch_remark}}">

                                            @error('dispatch_remark') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Order Id</label>
                                            <input type="text" class="form-control" value="{{$order->order_id}}" name="order_number" placeholder="Order Id">
                                            @error('order_number') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" value="{{$order->address}}" name="customer_address" placeholder="Address">
                                            @error('customer_address') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group m-0">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" class="form-control" value="{{$order->quantity}}" name="product_quantity" placeholder="Quantity">
                                            @error('product_quantity') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control" value="{{$order->price}}" name="price" placeholder="Price">
                                            @error('price') <div class="text-danger">{{$message}}</div>@enderror

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Currency</label>
                                            <input type="text" class="form-control" value="{{$order->currency}}" name="currency" placeholder="Currency">
                                            @error('currency') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <select class="form-control cities" name="status" data-placeholder="Choose Status" {{ $order->status == 'Dispatched' ? "disabled" : "" }}>
                                                <option value="Proceeded" {{ $order->status == 'Proceeded' ? "selected" : "" }}>Proceeded</option>
                                                <option value="Latest" {{ $order->status == 'Latest' ? "selected" : "" }}>Latest</option>
                                                <option value="Canceled" {{ $order->status == 'Canceled' ? "selected" : "" }}>Canceled</option>
                                                <option value="Hold Order" {{ $order->status == 'Hold Order' ? "selected" : "" }}>Hold Order</option>
                                                <option value="Dispatched" {{ $order->status == 'Dispatched' ? "selected" : "" }}>Dispatched</option>
                                            </select>
                                            @error('status') <div class="text-danger">{{$message}}</div>@enderror
                                        </div>
                                        <div class="form-group" id="remark-div">
                                            <label class="form-label">Remarks</label>
                                            @if($order->remarks)
                                                @forelse($order->remarks as $remark)
                                                    <input type="text" class="form-control" name="remarks[]" value="{{$remark->remark}}" placeholder="Remarks" {{$remark->user_id == \Illuminate\Support\Facades\Auth::user()->id ? ' ' : 'disabled'}}>
                                                @empty
                                                @endforelse
                                            @endif
                                            <button class="at-plusicon" id="addRemark"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="form-group" id="invoice-div" style="display: none">
                                            <label class="form-label">Invoice Record</label>

                                            @if($order->invoices)
                                                @forelse($order->invoices as $invoice)
                                                    <input type="text" class="form-control" name="invoices[]" value="{{$invoice->name}}-{{$invoice->quantity}}-{{$invoice->price}}" placeholder="Name-quantity-price">
                                                @empty
                                                    <input type="text" class="form-control" name="invoices[]" value="" placeholder="Name-quantity-price">
                                                @endforelse
                                            @endif
                                            @error('invoices') <div class="text-danger">{{$message}}</div>@enderror
                                            <button class="at-plusicon" id="addInvoice"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($order->status == 'Dispatched')
                                <button class="btn btn-primary" href="##" onClick="history.go(-1); return false;">Go back</button>
                            @else
                                <button type="submit" name="myButton" class="btn btn-primary">Update Order</button>
                            @endif
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
            let dispatchByStatus = '';

            // $('.mobile').mask('0000-000000000000000000000000000000');
            $(document).on('click','#addRemark',function (e) {
                e.preventDefault();
                let input = '<input type="text" class="form-control" name="remarks[]" value="" placeholder="Remarks">';
                $('#remark-div').append(input);
            });

            $(document).on('click','#addInvoice',function (e) {
                e.preventDefault();
                let input = '<input type="text" class="form-control" name="invoices[]" value="" placeholder="Name-quantity-price">';
                $('#invoice-div').append(input);
            });

            $('select[name="status"]').on('change',function (e) {
                let status = $(this).val();
                console.log(status);
                if(status === 'Dispatched'){
                    $('#dispatchBy').css('display','block');
                    $('#invoice-div').css('display','block');
                    $('#dispatchSelect').attr('required', true);
                }else{
                    $('#dispatchBy').css('display','none');
                    $('#dispatchSelect').val("null");
                    $('#invoice-div').css('display','none');
                    $('#dispatchSelect').removeAttr('required');
                }
            });

            $('select[name="dispatch_to"]').on('change',function (e) {
                let dispatch_to = $(this).val();
                console.log(dispatch_to,dispatch_to === '');
                if(dispatch_to !== ''){
                    $('#dispatchRemark').css('display','block');
                    if (dispatchByStatus === 'Stallion'){
                        $('input[name="dispatch_remark"]').attr('required', true);
                    }
                }else{
                    $('#dispatchRemark').css('display','none');
                    $('input[name="dispatch_remark"]').val("");
                    $('input[name="dispatch_remark"]').removeAttr('required', true);
                }
            });

            $('select[name="dispatch_by"]').on('change',function (e) {
                let val = $(this).val();
                dispatchByStatus = val;
                console.log(val,val !== '');
                if(val !== ''){
                    $('#dispatchCity').css('display','block');
                    $('#dispatchTo').attr('required', true);
                    let url = '{{route('employee_get_dispatch_city')}}';
                    let data = {
                        'type' : val,
                    };
                    $.get(url,data,function (response) {
                        if(response.status == 'success'){
                            console.log(response);
                            $('#dispatchTo').empty();
                            var option = $('<option></option>').attr("value", "").text("Select dispatch City");
                            $('#dispatchTo').append(option);
                            if(response.type=='BlueEx'){
                                $.each(response.cities,function (key, res) {
                                var option = $('<option></option>').attr("value", res.id).text(res.name);
                                // option.attr('data-id',res.id);
                                $('#dispatchTo').append(option);
                                });
                            }else if(response.type=='StallionDelivery'){
                                // option.attr('data-id',res.id);
                                $('#dispatchTo').append(response.cities);
                            }else{
                                $.each(response.cities,function (key, res) {
                                var option = $('<option></option>').attr("value", res.name).text(res.name);
                                // option.attr('data-id',res.id);
                                $('#dispatchTo').append(option);
                                });
                            }
                        }
                    });
                }else{
                    $('#dispatchCity').css('display','none');
                    $('#dispatchTo').val("null");
                    $('#dispatchTo').removeAttr('required');
                }
            });
        });

    </script>
@endsection
