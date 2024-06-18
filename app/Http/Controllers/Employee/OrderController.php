<?php

namespace App\Http\Controllers\Employee;

use App\Events\NewOrderNotification;
use App\Exports\ExcelExport;
use App\Http\Requests\CreateOrderRequest;
use App\library\services\DashboardService;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderInvoice;
use App\Models\OrderNumbers;
use App\Models\OrderRemark;
use App\Models\User;
use App\Notifications\CreateOrderNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\ShipmentDispatch;

class OrderController extends Controller
{
    use ShipmentDispatch;

    /**
     * @var DashboardService
     */
    private $dashboardService;

    public function __construct(DashboardService $dashboardService){

        $this->dashboardService = $dashboardService;
    }
    public function allOrder(Request $request)
    {
        $totalDispatched = Order::where("status",'Dispatched')->count();
        $totalCanceled = Order::where("status",'Canceled')->count();
        $totalHold = Order::where("status",'Hold Order')->count();

        $shopNames = DB::table('orders')->distinct()->get(['shop_name']);


        $q = $this->filters($request);

        $filterTotalDispatched = clone $q;
        $filterTotalDispatched = $filterTotalDispatched->where("status",'Dispatched')->count();
        $filterTotalCanceled = clone $q;
        $filterTotalCanceled = $filterTotalCanceled->where("status",'Canceled')->count();
        $filterTotalHold =  clone $q;
        $filterTotalHold = $filterTotalHold->where("status",'Hold Order')->count();
        $filterTotalLatest =  clone $q;
        $filterTotalLatest = $filterTotalLatest->where("status",'Latest')->count();
        $filterTotalProceeded =  clone $q;
        $filterTotalProceeded = $filterTotalProceeded->where("status",'Proceeded')->count();

//        $overAllLP = $this->dashboardService->overAllLP($q);
        $todayOrder = $this->dashboardService->today();
        $overAllOrder = $this->dashboardService->overAll();
        $overAllStatusBased = $this->dashboardService->overAllStatusBased($q);
        $overAllLP = $this->dashboardService->overAllLP($q);

        $orders = $request->type != null ?  $q->paginate(20,['*'],'page', $request->page ?? 1)->setPath('/employee/order/all-order')
            ->appends(['type' => \request()->query('type'), 'statusFilter' => request()->query('statusFilter'),
                'shopName' => request()->query('shopName'),
                'cityFilter' => request()->query('cityFilter')
                ,'fromDate' => request()->query('fromDate'),'toDate' => request()->query('toDate'),
                'dispatchBy' => request()->query('dispatchBy'),
                'searchOrder' => request()->query('searchOrder'),
                'dispatch_status' => request()->query('dispatch_status'),
            ]) : $q->paginate(20)->appends($request->query());



        $orderCity = DB::table('orders')
            ->select('city')
            ->distinct('city')
            ->get()->toArray();

        $dispatchOrderStatus = DB::table('orders')
            ->select('dispatch_status')
            ->distinct('dispatch_status')
            ->get()->toArray();

        foreach ($dispatchOrderStatus as $key => $dos){
            if ($dos->dispatch_status !== null){
                if (strpos($dos->dispatch_status, 'No Data Found For:') !== false) {
                    unset($dispatchOrderStatus[$key]);
                }
            }
        }
        $riders = User::where('role_id',3)->get();

        if($request->ajax()){
            return view('employee.order.order-table',compact('orders'));
        }
        return view('employee.order.all-order',compact('orders','dispatchOrderStatus','shopNames',
            'totalDispatched','totalHold','totalCanceled','orderCity',
            'todayOrder','overAllOrder','overAllStatusBased','filterTotalHold',
            'filterTotalDispatched','filterTotalCanceled','filterTotalLatest','filterTotalProceeded','overAllLP','riders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();

        return view('employee.order.create-order',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $orderId = str_random(2).rand(1000,99999).str_random(2);

        $order = Order::create([
            'order_taker_id' => Auth::user()->id,
            'name' => $request->customer_name,
            'order_id' => $orderId,
            'address' => $request->customer_address,
            'product' => $request->product_url,
            'quantity' => $request->product_quantity,
            'price' => $request->price,
            'email' => $request->customer_email,
            'city' => $request->city,
            'shop_name' => $request->shop_name,
            'currency' => $request->currency,
        ]);
        foreach ($request->mobile as $mobile){
            if ($mobile !== null){
                $checkMobile = substr( $mobile, 0, 2 );
                if ($checkMobile == "03"){
                    $mobile = preg_replace('/0/', '+92', $mobile, 1);
                }
                OrderNumbers::create([
                    'mobile' => $mobile,
                    'order_id' => $order->id
                ]);
            }
        }
        $user = Auth::user()->id;
        if ($request->remarks){
            OrderRemark::create([
                'remark' => $request->remarks,
                'user_id' => $user,
                'order_id' => $order->id,
            ]);
        }
        $orderNumber = $order->orderNumbers()->first();

        $senderId = '';
        if ($request->shop_name == 'Benyar.com.pk' || $request->shop_name == 'Benyar.co'){
            $senderId = 'BENYAR';
        }
        if ($request->shop_name == 'Naviforcewatches.co' || $request->shop_name == 'Naviforcewatches.com.pk'){

            $senderId = 'NaviForce';
        }
        $message = "Hi $request->customer_name,
Your Order $orderId with total amount Rs. $request->price has been placed at $senderId.
Thanks for shopping with us
$senderId Team";

        Curl::to('https://bsms.hostandsoft.com/app/sms/api')
            ->withData( array(
                "action" => "send-sms",
                "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                "to" => $orderNumber->mobile,
                "from" => $senderId,
                "sms" => $message,
            ) )->asJson()
            ->get();
        $order->users()->attach($user,['order_status' => 'Latest']);



        $receiver = User::where("role_id",1)->first();
        $notification = Notification::send($receiver, new CreateOrderNotification($order));
        event(new NewOrderNotification($order));

        return redirect(route('employee_all_order'))->with('success','Order Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request,$id)
    {
        try {
            $order = Order::where('id', $id)->first();
            if ($order->open_by != null && $order->open_by != Auth::user()->id){
                $name = User::findOrFail($order->open_by)->name;
                return response()->json([
                    'status' => 'error',
                    'message' => 'This order is opened by'.' '.$name
                ]);
            }else{
                $order->update([
                    'status' => $request->status,
                    'created_at' => Carbon::now()
                ]);

                $user = Auth::user()->id;
                $order->users()->attach($user,['order_status' => $request->status]);

            }

            return response()->json([
                'status' => 'success',
                'orderStatus' => $order->status
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = \request()->get('url');
        $order = Order::findOrFail($id);
        if ($order->open_by != null && $order->open_by != Auth::user()->id){
            $name = User::findOrFail($order->open_by)->name;
            return back()->with('error','This order is opened by'.' '.$name);
        }else{
            if ($order->status !== 'Dispatched'){
                $order->update([
                    'open_by' => Auth::user()->id,
                ]);
            }
        }
        $cities = City::all();
        $riders = User::where('role_id',3)->get();


        return view('employee.order.edit-order',compact('order', 'url','cities','riders'));
    }
    public function newOrder($id)
    {
        $order = Order::findOrFail($id);

        return view('employee.order.new-order',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $updatedDate = Carbon::now();
        if ($order->dispatch_by !== 'Tcs' && $order->dispatch_by !== 'Stallion'){
            if ($orderStatus == 'Dispatched'){
                $updatedDate = $order->created_at ;
            }
        }
        if ($orderStatus == $requestStatus){
            $updatedDate = $order->created_at;
        }

        $status = $order->status;

        if($request->status == 'Canceled'){
            $this->changeDispatchOrder($request,$order->id);
    }
        $order->update([
            'created_at' => $updatedDate,
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
            'dispatch_status' => $request->dispatch_status ? $request->dispatch_status : null,
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
        if ($request->status == 'Dispatched' && $request->invoices){
            $orderInvoices = $order->invoices;
            if ($orderInvoices){
                $order->invoices()->delete();
            }

            foreach ($request->invoices as $invoice){
                if ($invoice != null){
                    $finalInvoice = explode('/',$invoice);
                    OrderInvoice::create([
                        'order_id' => $order->id,
                        'name' => $finalInvoice[0],
                        'quantity' => $finalInvoice[1],
                        'price' => $finalInvoice[2],
                    ]);
                }

            }
        }
        foreach ($request->mobile as $mobile){
            if ($mobile !== null){
                $checkMobile = substr( $mobile, 0, 2 );
                if ($checkMobile == "03"){
                    $mobile = preg_replace('/0/', '+92', $mobile, 1);
                }
                OrderNumbers::create([
                    'mobile' => $mobile,
                    'order_id' => $order->id
                ]);
            }
        }
//        $response =['status' => 'success'];
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
        //adding my code
        if ($order->status == 'Dispatched' && $order->dispatch_by == 'PostEx') {
            $response = $this->dispatchShipment($order, $oldStatus, 'PostEx');
            if ($response['status'] == 'error') {
                return back()->with('error', $response['message']);
            } else {
                if ($request->printInvoice == 'printInvoice') {
                    return redirect(route('admin_get_invoice', $order->id))->with('success', 'Order Updated Successfully');
                } else {
                    return redirect($request->redirectUrl)->with('success', $response['message']);
                }
            }
        }
        if ($order->status == 'Dispatched' && $order->dispatch_by == 'BlueEx') {
            $response = $this->dispatchShipment($order, $oldStatus, 'BlueEx');
            if ($response['status'] == 'error') {
                return back()->with('error', $response['message']);
            } else {
                if ($request->printInvoice == 'printInvoice') {
                    return redirect(route('admin_get_invoice', $order->id))->with('success', 'Order Updated Successfully');
                } else {
                    return redirect($request->redirectUrl)->with('success', $response['message']);
                }
            }
        }
        if ($order->status == 'Dispatched' && $order->dispatch_by == 'StallionDelivery') {
            $response = $this->dispatchShipment($order, $oldStatus, 'StallionDelivery');
            if ($response['status'] == 'error') {
                return back()->with('error', $response['message']);
            } else {
                if ($request->printInvoice == 'printInvoice') {
                    return redirect(route('admin_get_invoice', $order->id))->with('success', 'Order Updated Successfully');
                } else {
                    return redirect($request->redirectUrl)->with('success', $response['message']);
                }
            }
        }
        if ($request->status == 'Dispatched' || $order->status == 'Dispatched' && $order->dispatch_by !== 'Stallion' && $order->dispatch_by !== 'Tcs') {

            $mobile = $order->orderNumbers()->first();

            $order->update([
                'cn' => $order->order_id
            ]);

            $senderId = '';
            if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co') {
                $senderId = 'BENYAR';
            }
            if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk') {
                $senderId = 'NaviForce';
            }

            $rider = $order->rider->name;
            $riderPhone = $order->rider->phone;
            if ($rider == 'karachi') {
                $message = "Hi $order->name,
Your order amounting to Rs. $order->price/ has now been dispatched
and will be delivered within the next 24 to 48 hours.";

                Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                    ->withData(array(
                        "action" => "send-sms",
                        "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                        "to" => $mobile->mobile,
                        "from" => $senderId,
                        "sms" => $message,
                    ))->asJson()
                    ->get();


            } else {

                $message = "Hi $order->name,
Your order amounting to Rs. $order->price/ has now been dispatched
and will be delivered within the next 24 to 48 hours.
Rider Contact Number: $riderPhone";


                Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                    ->withData(array(
                        "action" => "send-sms",
                        "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                        "to" => $mobile->mobile,
                        "from" => $senderId,
                        "sms" => $message,
                    ))->asJson()
                    ->get();
            }
        }

        if ($request->dispatch_status == 'DELIVERED'){
            $mobile = $order->orderNumbers()->first();

            $senderId = '';
            $link = '';
            if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                $senderId = 'BENYAR';
                $link = 'https://m.facebook.com/benyarwatches/';
            }
            if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){
                $senderId = 'NaviForce';
                $link = 'https://m.facebook.com/naviforce.pk/';
            }

            $message = " Tell us About Your Shopping Experience.
Please Share your Feedback on our page time line by clicking
$link";
            Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                ->withData( array(
                    "action" => "send-sms",
                    "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                    "to" => $mobile->mobile,
                    "from" => $senderId,
                    "sms" => $message,
                ) )->asJson()
                ->get();
        }

        return redirect($request->redirectUrl)->with('success','Order Updated Successfully');
    }

    public function Stallion($order,$oldStatus)
    {
        $userId = Auth::user()->id;
        $orderPrice = (int)$order->price;
        $mobile = $order->orderNumbers()->first();

        $checkMobile = substr( $mobile->mobile, 0, 3 );
        $stallionMobile='';
        if ($checkMobile == "+92"){
            $stallionMobile = str_replace("+92","0",$mobile->mobile);
        }

        $response = Curl::to('http://109.163.232.133:8081/Stallion.asmx/BookParcel_New')
            ->withData( array(
                "username" => "pink palace",
                "password" => "72273330335",
                "ConsigneeAddress1" => $order->address,
                "ConsigneeName" => $order->name,
                "ConsigneeCityid" => $order->dispatch_to,
                "ConsigneePhone1" => str_replace("-","",$stallionMobile),
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
        $senderId='';
        if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
            $senderId = 'BENYAR';
        }
        if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){
            $senderId = 'NaviForce';
        }

        $message = "Hi $order->name,
Your Order ID $order->order_id  has been shipped via Stallion Courier.
Your tracking number is $cn[0].
$senderId Team.";

        Curl::to('https://bsms.hostandsoft.com/app/sms/api')
            ->withData( array(
                "action" => "send-sms",
                "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                "to" => $mobile->mobile,
                "from" => $senderId,
                "sms" => $message,
            ) )->asJson()
            ->get();

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
            $mobile = $order->orderNumbers()->first();
            $senderId='';
            if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                $senderId = 'BENYAR';
            }
            if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){
                $senderId = 'NaviForce';
            }

            $message = "Hi $order->name,
Your Order ID $order->order_id  has been shipped via TCS Courier.
Your tracking number is $cn.
$senderId Team.";

            Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                ->withData( array(
                    "action" => "send-sms",
                    "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                    "to" => $mobile->mobile,
                    "from" => $senderId,
                    "sms" => $message,
                ) )->asJson()
                ->get();
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->type == "trashed"){
            $order = Order::where('id',$id)->withTrashed()->first();
            $order->users()->detach();
            if ($order->orderNumbers){
                $order->orderNumbers()->delete();
            }
            $order->forceDelete();
        }
        else{
            $order =  Order::findOrFail($id);
            if ($order->status == 'Latest') {
                $order->delete();
            }else{
                return redirect()->back()->with('error',"Sorry! you can only delete latest order");
            }
        }

        return back()->with('success','Order Deleted Successfully');
    }

    public function export(Request $request)
    {
        $q = $this->filters($request);

        return Excel::download(new ExcelExport($q->get()), 'excel.xlsx');
    }

    public function filters($request)
    {
        $q = Order::query();

        if ($request->type == 'today' && $request->statusFilter !== 'all'){
            $q->whereDate('created_at',Carbon::now()->toDateString())->where('status',$request->statusFilter);
        }
        if ($request->type == 'overAll' && $request->statusFilter !== 'all'){
            $q->where('status',$request->statusFilter);
        }
        if ($request->cityFilter != "null" && $request->filled('cityFilter') ){
            if($request->cityFilter == 'all'){

            }else{
                $q->where("city",$request->cityFilter);
            }
        }
        if ($request->shopName != "null" && $request->filled('shopName') ){
            if($request->shopName == 'all'){

            }else{
                $q->where("shop_name",$request->shopName);
            }
        }
        if ($request->filled('fromDate')  && $request->filled('toDate')){
            $q->whereDate('created_at','>=',Carbon::parse($request->fromDate)->toDateString())->whereDate('created_at','<=',Carbon::parse($request->toDate)->toDateString());
        }
        if ($request->statusFilter != "null" && $request->filled('statusFilter') && $request->statusFilter != "all"){
            $q->where("status",$request->statusFilter);
        }
        if ($request->dispatchBy != "null" && $request->filled('dispatchBy') && $request->dispatchBy != "all"){
            $q->where("dispatch_by",$request->dispatchBy);
        }
        if ($request->dispatch_status != "all" && $request->dispatch_status != "null" && $request->filled('dispatch_status')){
            $q->where('dispatch_status',$request->dispatch_status);
        }

        if($request->filled('searchOrder')){
            $q->where(function ($q) use($request){
                $q->where('name', 'LIKE', "%".$request->searchOrder."%")
                    ->orWhereHas('orderNumbers',function (Builder $q) use($request){
                        $q->where('mobile', 'LIKE', "%".$request->searchOrder."%");})
                    ->orWhere('quantity', 'LIKE', "%".$request->searchOrder."%")
                    ->orWhere('price', 'LIKE', "%".$request->searchOrder."%")
                    ->orWhere('order_id', 'LIKE', "%".$request->searchOrder."%")
                    ->orWhere('city', 'LIKE', "%".$request->searchOrder."%")
                    ->orWhere('product', 'LIKE', "%".$request->searchOrder."%")
                    ->orWhere('address', 'LIKE', "%".$request->searchOrder."%");
            });
        }
        else{
            if(!$request->has('column')){
                $q->latest();
            }
        }

        return $q;
    }

    public function trashedOrder(Request $request)
    {
        if ($request->type == "today"){
            $q = Order::onlyTrashed()->whereDate('deleted_at',now()->toDateString())->paginate(20);
        }else{
            $q = Order::onlyTrashed()->paginate(20);
        }
        $orders = $q;

        return view('employee.order.trashed-order',compact('orders'));
    }

    public function deleteMultiple(Request $request)
    {
        try{
            foreach ($request->orders as $id){
                if ($request->action == 'status'){
                    $order =  Order::findOrFail($id);
                    if ($order->open_by != null && $order->open_by != Auth::user()->id){
                        $name = User::findOrFail($order->open_by)->name;
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This order'.'('.$order->order_id.')'.' is opened by'.' '.$name
                        ]);
                    }else{
                        $order->update([
                            'status' => $request->statusType,
                            'created_at' => Carbon::now()]);
                        $user = Auth::user()->id;
                        $order->users()->attach($user,['order_status' => $request->statusType]);
                    }
                }
                elseif ($request->type == "permanent"){
                    $order = Order::where('id',$id)->withTrashed()->first();
                    if ($order->orderNumbers){
                        $order->orderNumbers()->delete();
                    }
                    $order->forceDelete();
                }
                else{
                    $order =  Order::findOrFail($id);
                    if ($order->status == 'Latest') {
                        $order->delete();
                    }else{
                        return response()->json([
                            'status' => 'error',
                            'message' => 'You can only delete latest order'
                        ]);
                    }

                }
            }
            $orders = Order::paginate(20);

            return response()->json([
                'status' => 'success',
                'action' => $request->action,
                'view' => view('employee.order.order-table',compact('orders'))->render()
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
    public function deletePermanent(Request $request)
    {
        try{
            foreach ($request->orders as $id){
                $order =  Order::findOrFail($id);
                if ($order->orderNumbers){
                    $order->orderNumbers()->delete();
                }

                $order->forceDelete();
            }
            $orders = Order::paginate(20);

            return response()->json([
                'status' => 'success',
                'view' => view('employee.order.order-table',compact('orders'))->render()
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function restoreOrder(Request $request)
    {
        if ($request->type == 'multiple'){
            foreach ($request->orders as $id){
                $order =  Order::where('id',$id)->withTrashed()->first();
                $order->update([
                    'deleted_at' => null,
                ]);
            }

            return response()->json([
                'status' => 'success',
            ]);
        }else{

            $order =  Order::where('id',$request->order)->withTrashed()->first();
            $order->update([
                'deleted_at' => null,
            ]);

            return back()->with('success','order restore successfully');
        }

    }

    public function sortingOrder(Request $request)
    {
        $q = $this->filters($request);

        $orders = $q->orderBy($request->column, $request->type)->paginate(20,['*'], 'page',$request->page ?? 1);


        return response()->json([
            'status' => 'success',
            'view' => view('employee.order.order-table',compact('orders'))->render()
        ]);

    }

    public function todayDispatchOrders()
    {
        $orders =  Order::whereStatus('Dispatched')->where(function ($q) {
            $q->whereDate('updated_at',Carbon::now()->toDateString());
        })->paginate(10);
        return view('employee.order.order-details',compact('orders'));
    }

    public function viewOrderStatus($id)
    {
        $order = Order::find($id);
        return $order->users;
    }

    public function changeDispatchOrder(Request $request,$id)
    {
        $order = Order::findOrFail($id);
        $dispatchBy = $order->dispatch_by;
        $cn = $order->cn;
        $status = $request->status;
        if ($cn){
            if ($dispatchBy == 'Tcs'){
                $r =  $this->cancelTcs($cn,$status,$order);
                if ($r['status'] == 'success'){
                    return back()->with('success',$r['message']);
                }else{
                    return back()->with('error',$r['message']);
                }
            }if ($dispatchBy == 'Stallion'){
                $r = $this->cancelStallion($cn,$status,$order);
                if ($r == 'success'){
                    return back()->with('success','Status change successfully');
                }else{
                    return back()->with('error',$r);
                }
            }
            if($dispatchBy !== null && $dispatchBy !== 'Stallion' && $dispatchBy !== 'Tcs'){

                $order->update([
                    'status' => $status,
                ]);
                if ($status == 'Hold Order'){
                    $mobile = $order->orderNumbers()->first();
                    $senderId = '';
                    if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                        $senderId = 'BENYAR';
                    }
                    if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){

                        $senderId = 'NaviForce';
                    }


                    $message = "We acknowledge your order $order->order_id,
Unfortunately, I regret to inform you the product you have ordered is out of stock.
Our Team will Contact You Shortly.";
                    Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                        ->withData( array(
                            "action" => "send-sms",
                            "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                            "to" => $mobile->mobile,
                            "from" => $senderId,
                            "sms" => $message,
                        ) )->asJson()
                        ->get();
                }

                $user = Auth::user()->id;
                $order->users()->attach($user,['order_status' => $status]);
                return back()->with('success','Status change successfully');
            }
        }else{
            return back()->with('error',"CN is missing");
        }
    }

    public function syncRecord()
    {
        $a = "DELIVERED";
        $b = "Returned to TCS origin";

        $or = Order::where('status','Dispatched')->whereNotIn('dispatch_status',[$a,$b])->orWhere('dispatch_status',null)->whereNotNull('cn')->where(function ($q){
            $q->orWhere('dispatch_by','Tcs')->orWhere('dispatch_by','Stallion');
        });

        $orders = $or->get();

        foreach ($orders as $order){
            if ($order->dispatch_by == 'Tcs'){
                if ($order->cn !== null) {
                    $response = Curl::to('https://apis.tcscourier.com/production/track/v1/shipments/detail')
                        ->withHeaders(array('accept: application/json', 'X-IBM-Client-Id: 51a21837-3d33-4760-b172-2e036a509cbf',
                        ))
                        ->withData(array("consignmentNo" => $order->cn))
                        ->asJson()
                        ->get();

                    if (isset($response->returnStatus->status) && $response->returnStatus->status == "SUCCESS") {
                        if (isset($response->TrackDetailReply)) {
                            if (isset($response->TrackDetailReply->DeliveryInfo)) {
                                $order->update([
                                    'dispatch_status' => $response->TrackDetailReply->DeliveryInfo[0]->status,
                                ]);

                            } elseif (isset($response->TrackDetailReply->Checkpoints)) {
                                $order->update([
                                    'dispatch_status' => $response->TrackDetailReply->Checkpoints[0]->status,
                                ]);
                            }
                            if ($order->dispatch_status === 'DELIVERED'){
                                $mobile = $order->orderNumbers()->first();

                                $senderId = '';
                                $link = '';
                                if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                                    $senderId = 'BENYAR';
                                    $link = 'https://m.facebook.com/benyarwatches/';
                                }
                                if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){
                                    $senderId = 'NaviForce';
                                    $link = 'https://m.facebook.com/naviforce.pk/';
                                }

                                $message = " Tell us About Your Shopping Experience.
Please Share your Feedback on our page time line by clicking
$link";
                                Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                                    ->withData( array(
                                        "action" => "send-sms",
                                        "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                                        "to" => $mobile->mobile,
                                        "from" => $senderId,
                                        "sms" => $message,
                                    ) )->asJson()
                                    ->get();
                            }
                        }
                    } elseif (isset($response->returnStatus->status) && $response->returnStatus->status == "FAIL") {
                        $order->update([
                            'dispatch_status' => $response->returnStatus->message,
                        ]);
                    }
                }
            }
            if ($order->dispatch_by == 'Stallion'){
                if ($order->cn !== null) {
                    $response = Curl::to('http://109.163.232.133:8081/Stallion.asmx/parceltrack')
                        ->withData(array(
                            "parcno" => $order->cn,
                            "userid" => 'pink palace',
                            "pass" => '72273330335',
                        ))->post();

                    $reply = collect(json_decode(json_encode((array)simplexml_load_string($response)), true));

                    $removeDateReply = preg_replace('/\d/', '', $reply[0]);

                    $finalReply = explode('//', $removeDateReply);

                    $order->update([
                        'dispatch_status' => $finalReply[0],
                    ]);

                    if ($order->dispatch_status == 'DELIVERED'){
                        $mobile = $order->orderNumbers()->first();

                        $senderId = '';
                        $link = '';
                        if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                            $senderId = 'BENYAR';
                            $link = 'https://m.facebook.com/benyarwatches/';
                        }
                        if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){
                            $senderId = 'NaviForce';
                            $link = 'https://m.facebook.com/naviforce.pk/';
                        }

                        $message = " Tell us About Your Shopping Experience.
Please Share your Feedback on our page time line by clicking
$link";
                        Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                            ->withData( array(
                                "action" => "send-sms",
                                "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                                "to" => $mobile->mobile,
                                "from" => $senderId,
                                "sms" => $message,
                            ) )->asJson()
                            ->get();
                    }
                }
            }
        }
        return back()->with('success','Data sync successfully');
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);

        return view('invoice.invoice',compact('order'));
    }

    public function cancelTcs($cn,$status,$order)
    {
        if ($cn !== null){
            $response = Curl::to('https://apis.tcscourier.com/production/v1/cod/cancel-order')
                ->withHeaders( array( 'accept: application/json', 'X-IBM-Client-Id: 51a21837-3d33-4760-b172-2e036a509cbf' ,
                ) )
                ->withData( array(
                        "userName" => "pink.palace",
                        "password" => "@bdul553",
                        "consignmentNumber" => $cn
                    )
                )->asJson()
                ->put();
            if (isset($response->returnStatus->status) && $response->returnStatus->status == 'SUCCESS'){

                $order->update([
                    'status' => $status,
                ]);
                if ($status == 'Hold Order'){
                    $mobile = $order->orderNumbers()->first();
                    $senderId = '';
                    if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                        $senderId = 'BENYAR';
                    }
                    if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){

                        $senderId = 'NaviForce';
                    }


                    $message = "We acknowledge your order $order->order_id,
Unfortunately, I regret to inform you the product you have ordered is out of stock.
Our Team will Contact You Shortly.";
                    Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                        ->withData( array(
                            "action" => "send-sms",
                            "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                            "to" => $mobile->mobile,
                            "from" => $senderId,
                            "sms" => $message,
                        ) )->asJson()
                        ->get();
                }

                $user = Auth::user()->id;
                $order->users()->attach($user,['order_status' => $status]);
                return ['status'=> 'success',
                    'message' => $response->cancelShipmentReply->result
                ];

            }elseif (isset($response->returnStatus->status) && $response->returnStatus->status == 'FAIL'){
                return [ 'status'=> 'error',
                    'message' =>    $response->returnStatus->message
                ];
            }
        }
    }

    public function cancelStallion($cn,$status,$order)
    {
        if ($cn !== null){
            $response = Curl::to('http://109.163.232.133:8081/Stallion.asmx/CancelParcel')
                ->withData( array(
                    "parcelno" => $cn,
                ) )->post();

            $reply = collect(json_decode(json_encode((array) simplexml_load_string($response)), true));

            if ($reply[0] == 'Parcel Status Cancelled Updated!'){
                $order->update([
                    'status' => $status,
                ]);

                if ($status == 'Hold Order'){
                    $mobile = $order->orderNumbers()->first();
                    $senderId = '';
                    if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co'){
                        $senderId = 'BENYAR';
                    }
                    if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk'){

                        $senderId = 'NaviForce';
                    }


                    $message = "We acknowledge your order $order->order_id,
Unfortunately, I regret to inform you the product you have ordered is out of stock.
Our Team will Contact You Shortly.";
                    Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                        ->withData( array(
                            "action" => "send-sms",
                            "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                            "to" => $mobile->mobile,
                            "from" => $senderId,
                            "sms" => $message,
                        ) )->asJson()
                        ->get();
                }

                $user = Auth::user()->id;
                $order->users()->attach($user,['order_status' => $status]);
                return 'success';

            }else{
                return $reply[0];
            }
        }
    }

    public function receiveParcel($id)
    {
        $order = Order::findOrFail($id);
        if ($order->is_returned == 0){
            $order->update([
                'is_returned' => 1
            ]);
        }
        return response()->json([
            'status' => 'success'
        ]);
    }

}
