<?php

namespace App\Http\Controllers\Api;

use App\Events\NewOrderNotification;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderNumbers;
use App\Models\OrderRemark;
use App\Models\User;
use App\Notifications\CreateOrderNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;
use Notification;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        try{
            $mobile = $request->customer_phone;
            $checkMobile = substr( $mobile, 0, 2 );
            if ($checkMobile == "03"){
                $mobile = preg_replace('/0/', '+92', $mobile, 1);
            }
//            $insertion = "-";
//            $index = 4;
//            $mobile = substr_replace($string, $insertion, $index, 0);

            $order = Order::create([
                'name' => $request->customer_name,
                'order_id' => $request->order_number,
                'address' => $request->customer_address,
                'product' => $request->product_url,
                'quantity' => $request->product_quantity,
                'price' => $request->price,
                'email' => $request->customer_email,
                'city' => ucwords(strtolower($request->city)),
                'shop_name' => $request->shop_name,
                'postal_code' => $request->customer_postal_code,
                'currency' => $request->currency,
                'shipping_method' => $request->shipping_method
            ]);

            if ($request->customer_phone){
                $orderNumber = OrderNumbers::create([
                    'order_id' => $order->id,
                    'mobile' => $mobile,
                ]);
            }
            if ($request->remarks){
                OrderRemark::create([
                    'order_id' => $order->id,
                    'remark' => $request->remarks,
                ]);
            }

            $senderId = '';
            if ($request->shop_name == 'Benyar.com.pk' || $request->shop_name == 'Benyar.co'){
                $senderId = 'Benyar';
            }
            if ($request->shop_name == 'Naviforcewatches.co' || $request->shop_name == 'Naviforcewatches.com.pk'){

                $senderId = 'NaviForce';
            }

            $message = "Hi $request->customer_name,
Your Order $request->order_number with total amount Rs. $request->price has been placed at $senderId.
Thanks for shopping with us     
$senderId Team";
            $response = Curl::to('https://bsms.hostandsoft.com/app/sms/api')
                ->withData( array(
                    "action" => "send-sms",
                    "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                    "to" => $mobile,
                    "from" => $senderId,
                    "sms" => $message,
                ) )->asJson()
                ->get();
            $receiver = User::where("role_id",1)->first();
            $notification = Notification::send($receiver, new CreateOrderNotification($order));
            event(new NewOrderNotification($order));

            return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'message' => 'order created successfully',
                'data' => $order
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status_code' => $exception->getCode(),
                'status' => 'error',
                'message' => 'order could not be created'
            ]);
        }

    }

    public function test()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apis.tcscourier.com/uat/track/v1/shipments/checkpoints",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "x-ibm-client-id: 468fd418-bee6-46c5-abe2-83d21bc01695"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(json_decode($err));
        } else {
           return response()->json(json_decode($response));
        }
    }
}
