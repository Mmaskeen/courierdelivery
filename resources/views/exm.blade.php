public function update(CreateOrderRequest $request, $id)
{
if ($request->status == 'Hold Order' || $request->status == 'Canceled' || $request->status == 'Latest'){
$requestRemarks = $request->remarks;
if ($requestRemarks == null){
return redirect()->back()->with('error','remarks are required for this actions');
}
if ($requestRemarks !== null && !empty($request->remarks)){
$arr = array_filter($request->remarks);
if (empty($arr)){
return redirect()->back()->with('error','remarks are required for this actions');
}
}
}

$order = Order::findOrFail($id);

$oldStatus = $order->status;
$orderStatus = $order->status;
$requestStatus = $request->status;

$status = $order->status;
$order->update([
'created_at' => $orderStatus == $requestStatus ? $order->created_at : Carbon::now(),
'open_by' => null,
'name' => $request->customer_name,
'order_id' => $request->order_number,
'address' => $request->customer_address,
'product' => $request->product_url,
'quantity' => $request->product_quantity,
'price' => $request->price,
'email' => $request->customer_email,
'status' => $request->status === null ? $status : $request->status ,
'city' => $request->city,
'shop_name' => $request->shop_name,
'dispatch_by' => $request->dispatch_by ? $request->dispatch_by : null,
'dispatch_to' => $request->dispatch_to ? $request->dispatch_to : null,
'dispatch_remark' => $request->dispatch_remark ? $request->dispatch_remark : null,
'currency' => $request->currency,
]);

$user = Auth::user()->id;
$order->users()->attach($user,['order_status' =>  $request->status === null ? $status : $request->status]);

$order->orderNumbers()->delete();
if ($request->remarks){
$userRemarks = OrderRemark::where('order_id',$order->id)->where('user_id',$user)->get();
foreach ($userRemarks as $userRemark){
$userRemark->delete();
}
foreach ($request->remarks as $remark){
if ($remark != null){
OrderRemark::create([
'remark' => $remark,
'user_id' => $user,
'order_id' => $order->id,
]);
}

}
}
foreach ($request->mobile as $mobile){
OrderNumbers::create([
'mobile' => $mobile,
'order_id' => $order->id
]);
}
if ($order->status == 'Dispatched' && $order->dispatch_by == 'Tcs'){
$response = $this->tcs($order,$oldStatus);
if ($response['status'] == 'error'){
return back()->with('error',$response['message']);
}else{
return redirect($request->redirectUrl)->with('success',$response['message']);
}
}

if ($order->status == 'Dispatched' && $order->dispatch_by == 'Stallion'){
$response = $this->Stallion($order,$oldStatus);
return redirect($request->redirectUrl)->with('success',$response['message']);
}

return redirect($request->redirectUrl)->with('success','Order Updated Successfully');
}

public function Stallion($order,$oldStatus)
{
$userId = Auth::user()->id;
$orderNumber = '';
$orderPrice = (int)$order->price;
foreach ($order->orderNumbers as $number){
$orderNumber = $number->mobile ;
}
$response = Curl::to('http://109.163.232.133:8081/Stallion.asmx/BookParcel_New')
->withData( array(
"username" => "pink palace",
"password" => "72273330335",
"ConsigneeAddress1" => $order->address,
"ConsigneeName" => $order->name,
"ConsigneeCityid" => $order->dispatch_to,
"ConsigneePhone1" => str_replace("-", "",$orderNumber),
"ItemType" => $order->product,
"PickupDate" => Carbon::now()->toDateString(),
"SpecialInstruction" => $order->dispatch_remark,
"CODAmount" => $orderPrice,
"PickupAddressid" => "10583",
"Hide" => "test",
"Quantity" => $order->quantity,
"shiperOrderId" => $order->order_id,
) )->post();

$cn = collect(json_decode(json_encode((array) simplexml_load_string($response)), true));

$order->update([
'cn' => $cn[0],
]);
return [
'status' => 'success',
'message'=> $cn[0]." Dispatch successfully"
];
}

public function tcs($order,$oldStatus)
{
$userId = Auth::user()->id;
$orderNumber = '';
foreach ($order->orderNumbers as $number){
$orderNumber = $number->mobile;
}
$response = Curl::to('https://apis.tcscourier.com/production/v1/cod/create-order')
->withHeaders( array( 'accept: application/json', 'X-IBM-Client-Id: 51a21837-3d33-4760-b172-2e036a509cbf' ,
) )
->withData( array(
"userName" => "pink.palace",
"password" => "@bdul553",
"costCenterCode" => "037555",
"consigneeName" => $order->name,
"consigneeAddress" => $order->address,
"consigneeMobNo" => $orderNumber,
"consigneeEmail" => $order->email,
"originCityName" => "Karachi",
"destinationCityName" => $order->dispatch_to,
"weight" => "0.5",
"pieces" => $order->quantity,
"codAmount" => $order->price,
"customerReferenceNo" => $order->order_id,
"services" => "O",
"productDetails" => $order->product,
"fragile" => "Yes",
"remarks" => $order->dispatch_remark ? $order->dispatch_remark : '',
"insuranceValue" => '1'
) )
->asJson()
->post();
if ($response->returnStatus->status == 'SUCCESS'){
$cn = preg_replace('/[^0-9]/', '', $response->bookingReply->result);
$order->update([
'cn' => $cn,
]);
return [
'status' => 'success',
'message'=> $response->bookingReply->result
];

}elseif ($response->returnStatus->status == 'FAIL'){
$order->update([
'status' => $oldStatus,
'dispatch_to' => null,
'dispatch_by' => null,
'dispatch_remark' => null,
]);
return [
'status' => 'error',
'message' => $response->returnStatus->message
];
}
}
