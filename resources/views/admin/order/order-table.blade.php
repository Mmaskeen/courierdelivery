@forelse($orders as $order)
    <tr>
        <td data-title="">
            <span class="at-checkbox">
                <input class="checkboxes" type="checkbox" name="orderCheck" data-id="{{$order->id}}" id="at-user-{{$order->id}}" autocomplete="off">
                <label for="at-user-{{$order->id}}"></label>
            </span>
        </td>
        <td>
            @if($order->status === 'Dispatched' && $order->dispatch_status === 'Parcel Returned' || $order->status === 'Dispatched' && $order->dispatch_status === 'RETURN TO SHIPPER')
                <label class="custom-switch mr-3">
                    <input type="checkbox" name="is_returned" data-id="{{$order->id}}" class="custom-switch-input isReturned" {{$order->is_returned == 1 ? 'checked' : ''}}>
                    <span class="custom-switch-indicator"></span>
                </label>
            @endif
            <span class="text-muted orderId">{{$order->order_id}}</span>
        </td>
        @if(request('statusFilter') === 'Dispatched')
            <td>
                <span class="text-muted orderId">{{$order->cn ? $order->cn : 'N/A'}}
                    @if($order->dispatch_by == 'Tcs' || $order->dispatch_by == 'Stallion')
                        <figure class="at-logimg"><img {{$order->dispatch_by == 'Tcs' || $order->dispatch_by == 'Stallion' ?
                     'src='.asset('assets/images/'.$order->dispatch_by.'.png'): ''}}  alt="logo image"></figure>
                    @else
                        <strong style="color: black"> ({{$order->dispatch_by !== null && $order->rider ?  $order->rider->name  : ''}})</strong>
                    @endif
                </span>
            </td>
            <td><span class="text-muted orderId">{{$order->dispatch_status ? $order->dispatch_status : 'N/A'}}</span></td>
        @endif
        <td><a href="{{route('admin_edit_order',['id' => $order->id, 'url' => request()->fullUrl()])}}">{{str_limit($order->name,10)}}</a></td>
        <td title="{{ $order->product}}"><a href="{{ $order->product}}" target="_blank">{{ str_limit($order->product,15)}}</a></td>
        <td>{{str_limit($order->address,15)}}</td>
        <td>{{str_limit($order->city,15)}}</td>
        <td>
            @foreach($order->orderNumbers as $num)
                {{str_limit($num->mobile,6)}}
            @endforeach
        </td>
        <td>{{$order->shipping_method}}</td>
        <td>{{$order->quantity}}</td>
        <td>{{$order->price}}</td>
        <td><span class="badge badge-{{$order->status}} mt-2">{{$order->status}}</span></td>
        <td>{{$order->created_at_m_d_y}}</td>
        <td>
            <div class="btn-group mt-2 mb-2">
                {{--                <button type="button" class="at-actionbtn btn-primary dropdown-toggle " data-toggle="dropdown" aria-expanded="false">--}}
                {{--                    Status <span class="caret"></span>--}}
                {{--                </button>--}}
                {{--                <ul class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">--}}
                {{--                    <li class="dropdown-plus-title" >--}}
                {{--                        Dropdown--}}
                {{--                        <b class="fa fa-angle-up" aria-hidden="true"></b>--}}
                {{--                    </li>--}}
                {{--                    @foreach(\App\Utils\Constants\AppConst::$status as $status)--}}
                {{--                        <li class="changeStatus" data-id="{{$order->id}}" data-value="{{$status}}"><a href="javascript:void(0);">{{$status}}</a></li>--}}
                {{--                    @endforeach--}}

                {{--                </ul>--}}

                @if(request('statusFilter') === 'Dispatched')
                    <form action="{{route('admin_change_dispatch_order_status',$order->id)}}" method="post" class="btnform">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Canceled">
                        <button type="submit" class="at-actionbtn btn-primary">Cancel <span class="caret"></span></button>
                    </form>
                    <form action="{{route('admin_change_dispatch_order_status',$order->id)}}" method="post" class="btnform">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Hold Order">
                        <button type="submit" class="at-actionbtn btn-primary">Hold <span class="caret"></span></button>
                    </form>
                    <a href="{{route('admin_get_invoice',$order->id)}}"  class="at-viewstatusbtn" target="_blank"><i class="fa fa-print"></i></a>
                @endif
                @if($order->status !== 'Dispatched')
                    <a href="{{route('admin_edit_order',['id' => $order->id, 'url' => request()->fullUrl()])}}" class="at-actionbtn at-edit-icon" ><i class="fa fa-edit"></i></a>
                @endif
                <a href="javascript:void(0);" data-id="{{$order->id}}" class="at-viewstatusbtn order_status" data-toggle="modal" data-target="#at-viewstatusmodal"><i class="fa fa-eye"></i></a>
                @if($order->status !== 'Dispatched')
                    <form action="{{route('admin_delete_order',$order->id)}}" method="post" class="btnform">
                        <input type="hidden" name="_method" value="DELETE">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="at-actionbtn at-deleticon" title="" onclick="return confirm('Are you sure you want to delete this Order?');"><i class="ti-trash"></i></button>
                    </form>
                @endif
            </div>
        </td>
    </tr>
@empty
@endforelse

