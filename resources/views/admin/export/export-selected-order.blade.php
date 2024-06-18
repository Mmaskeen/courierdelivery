<tr>
    <td>Order-ID</td>
    <td>CN</td>
    <td>Dispatch Status</td>
    <td>Name</td>
    <td>Address</td>
    <td>Product url</td>
    <td>Quantity</td>
    <td>Mobile Number</td>
    <td>Price</td>
    <td>Email</td>
    <td>Status</td>
    <td>City</td>
    <th>Remarks</th>
    <th>Created_at</th>
    <th>Deleted_at</th>
</tr>
@foreach($orders as $order)
    <tr>
        <td>{{$order->order_id}}</td>
        <td>{{$order->cn}}</td>
        <td>{{$order->dispatch_status}}</td>
        <td>{{$order->name}}</td>
        <td>{{$order->address}}</td>
        <td>{{$order->product}}</td>
        <td>{{$order->quantity}}</td>
        <td>
            @foreach($order->orderNumbers as $num)
                {{$num->mobile}},
            @endforeach
        </td>
        <td>{{$order->price}}</td>
        <td>{{$order->email}}</td>
        <td>{{$order->status}}</td>
        <td>{{$order->city}}</td>
        <td>
            @foreach($order->remarks as $remark)
                {{$remark->remark}},
            @endforeach
        </td>
        <td>{{$order->created_at}}</td>
        <td>{{$order->deleted_at}}</td>
    </tr>
@endforeach
