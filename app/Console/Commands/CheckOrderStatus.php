<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;

class CheckOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check tcs order status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     public function handle()
    {
        $a = "DELIVERED";
        $b = "Returned to TCS origin";

        $or = Order::where('status','Dispatched')->whereNotIn('dispatch_status',[$a,$b])->orWhere('dispatch_status',null)->whereNotNull('cn')->where(function ($q){
            $q->orWhere('dispatch_by','Tcs')->orWhere('dispatch_by','Stallion');
        });

        $orders = $or->get(80);
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
    }

}
