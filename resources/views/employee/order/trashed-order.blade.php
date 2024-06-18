@extends('layouts.master')
@section('page-title')
    <title>Employee | Trashed Orders</title>
@endsection
@section('body')
    <div class="content-area">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Trashed orders</h4>

            </div>

            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <form class="float-left">
                                <button class="btn btn-primary" id="deleteAllPermanent"><i class="fa fa-trash mr-2"></i>Delete All</button>
                                <button  class="btn btn-primary" id="restoreOrders"><i class="fa fa-recycle mr-2"></i>Restore All</button>
                            </form>

                        </div>
                        <div class="table-responsive" >
                            <table class="table card-table table-vcenter text-nowrap" id="table_id">
                                <thead>
                                <tr>
                                    <th>
                                        <span class="at-checkbox">
                                            <input class="checkall" type="checkbox" name="selectall" id="checkall2">
                                            <span id="totalSelected"> (0)</span>
                                            <label for="checkall2"></label>
                                        </span>
                                    </th>
                                    <th class="w-1">Order ID</th>
                                    <th>Name</th>
                                    <th>Product URL</th>
                                    <th>Address</th>
                                    <th>Cell Number</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">

                                @forelse($orders as $order)
                                    <tr>
                                        <td data-title="">
                                            <span class="at-checkbox">
                                                <input class="checkboxes" type="checkbox" name="orderCheck" data-id="{{$order->id}}" id="at-user-{{$order->id}}">
                                                <label for="at-user-{{$order->id}}"></label>
                                            </span>
                                        </td>
                                        <td><span class="text-muted orderId">{{$order->id}}</span></td>
                                        <td>{{str_limit($order->name,10)}}</td>
                                        <td title="{{ $order->product}}"><a href="{{ $order->product}}">{{ str_limit($order->product,15)}}</a></td>
                                        <td>{{str_limit($order->address,15)}}</td>
                                        <td>
                                            @foreach($order->orderNumbers as $num)
                                                {{str_limit($num->mobile,6)}}
                                            @endforeach
                                        </td>
                                        <td>{{$order->quantity}}</td>
                                        <td>{{$order->price}}</td>
                                        <td><span class="badge badge-{{$order->status}} mt-2">{{$order->status}}</span></td>
                                        <td>{{\Carbon\Carbon::parse($order->created_at)->format('M, d, Y')}}</td>
                                        <td>
                                            <div class="btn-group mt-2 mb-2">
                                                <form action="{{route('employee_delete_order',$order->id)}}" method="post" class="btnform">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="type" value="trashed">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="at-actionbtn at-deleticon" title="" onclick="return confirm('Are you sure you want to permanently delete this order?');"><i class="ti-trash"></i></button>
                                                </form>
                                                <form action="{{route('employee_restore_order',['order' => $order->id])}}" method="post" class="btnform">
                                                    @csrf
                                                    <button type="submit" class="at-actionbtn at-deleticon" title="" onclick="return confirm('Are you sure you want to restore this order?');"><i class="fa fa-recycle"></i></button>
                                                </form>
                                            </div>


                                        </td>
                                    </tr>
                                @empty
                                @endforelse


                                </tbody>
                            </table>

                            {{ $orders->links() }}



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
            $(document).on('click','#deleteAllPermanent',function (e) {
                e.preventDefault();
                let orders =[];
                $("input:checkbox[name=orderCheck]:checked").each(function(){
                    orders.push($(this).data('id'));
                });
                if(orders.length === 0){
                    toastr.error('Please Select at least one order', 'error!')
                }else{
                    let data = { "orders": orders,"_token": "{{ csrf_token() }}","_method" : "DELETE","type" : "permanent"};
                    let url = "{{route('employee_delete_multiple_order')}}";

                    $.post(url,data,function (response) {
                        if(response.status == 'success'){
                            setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 10);
                            toastr.success('Orders Deleted Successfully', 'Success!')
                        }else{
                            toastr.error('Something went wrong', 'error!')
                        }
                    });
                }
            });
            $(document).on('click','#restoreOrders',function (e) {
                e.preventDefault();
                let orders =[];
                $("input:checkbox[name=orderCheck]:checked").each(function(){
                    orders.push($(this).data('id'));
                });
                if(orders.length === 0){
                    toastr.error('Please Select at least one order', 'error!')
                }else{
                    let data = { "orders": orders,"_token": "{{ csrf_token() }}",'type':'multiple'};
                    let url = "{{route('employee_restore_order')}}";

                    $.post(url,data,function (response) {
                        if(response.status == 'success'){
                            setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1000);
                            toastr.success('Orders Restore Successfully', 'Success!')
                        }else{
                            toastr.error('Something went wrong', 'error!')
                        }
                    });
                }
            });
        });
    </script>
@endsection
