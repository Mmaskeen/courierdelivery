<?php

namespace App\Traits;

use Ixudra\Curl\Facades\Curl;
use App\Traits\StallionDeliveryCities;
use Carbon\Carbon;

trait ShipmentDispatch
{
    use StallionDeliveryCities;
    /**
     * Format date to a readable format.
     *
     * @param  string  $date
     * @return string
     */
    public function getCitiesByAPI($provider)
    {
        if ($provider == 'PostEx') {
            return $this->postExCities();
        } else if ($provider == 'BlueEx') {
            return $this->blueExCities();
        } else if ($provider == 'StallionDelivery') {
            return $this->stallionDeliveryCities;
        }
    }
    public function postExCities()
    {
        $response = Curl::to('https://api.postex.pk/services/integration/api/order/v2/get-operational-city')
            ->withHeaders([
                'token' => 'ZTlkOGIwYmI3NjVkNDFmOWI1ODcyMWRkZDRjYWU0MTI6NGEzNTM5MzMwZjRhNDhlOTk2NDVhZTY3ZThjYzhiZTQ=', // Setting Content-Type header
            ])
            ->asJson()
            ->get(); // Change this to post() for POST request
        if ($response->statusCode == 200) {
            // $operationalCities = collect($response->dist ?? [])->pluck('operationalCityName')->toArray();
            $cityNamesWithKey = collect($response->dist ?? [])->pluck('operationalCityName')
                ->map(function ($cityName) {
                    return ['name' => $cityName];
                });
            return $cityNamesWithKey;
        }
    }
    public function blueExCities()
    {
        $response = Curl::to('https://bigazure.com/api/json_v3/cities/get_cities.php')
            ->withOption('USERPWD', "KHI-07993:Q4Ms2LwkyZgTtnOYnLe")
            ->withData([
                'country_code' => 'PK'
            ])
            ->asJson()
            ->post(); // Change this to post() for POST request
        if ($response->status == 1) {
            $cityNamesWithKey = collect($response->response ?? [])
                ->map(function ($item) {
                    return [
                        'name' => $item->CITY_NAME,
                        'id' => $item->CITY_CODE
                    ];
                });
            return $cityNamesWithKey;
        }
    }
    function dispatchShipment($order, $oldStatus, $provider)
    {
        if ($provider == 'PostEx') {
            return $this->postexShipment($order, $oldStatus);
        } else if ($provider == "BlueEx") {
            return $this->blueExShipment($order, $oldStatus);
        } else if ($provider == "StallionDelivery") {
            return $this->stallionDeliveryShipment($order, $oldStatus);
        }
    }
    function stallionDeliveryShipment($order, $oldStatus)
    {
        $response = Curl::to('https://bitrix.pk/Rest/oauth/v2/Token')
            ->withContentType('application/x-www-form-urlencoded')
            ->withData([
                'grant_type' => 'password',
                'username' => 'watchzone.pk@gmail.com',
                'password' => '40d8aede-bc1c-4d2d-b1fa-20de7e546409'
            ])
            ->post();
        $tokenData = json_decode($response, true); // Convert JSON string to associative array
        if (isset($tokenData['access_token'])) {
            $accessToken = $tokenData['access_token']; // Access the 'access_token' key
            $mobile = $order->orderNumbers()->first();
            $checkMobile = substr($mobile->mobile, 0, 3);
            $postMobile = '';
            if ($checkMobile == "+92") {
                $postMobile = str_replace("+92", "0", $mobile->mobile);
            }
            $response = Curl::to('https://bitrix.pk/Rest/Stallion/Booking/')
                ->withHeaders([
                    'Content-Type: application/json',
                    "Authorization: Bearer {$accessToken}"
                ])
                ->withData(
                    [
                        "UserId" => $tokenData['UserID'],
                        "UserName" => $tokenData['UserName'],
                        "ParcelTypeID" => "1",
                        "PickUpAddressID" => "303838",
                        "PickUpDate" => Carbon::now()->toDateString(),
                        "ConsigneeCityID" => $order->dispatch_to,
                        "ChargeTypeID" => "2",
                        "Information" => "show",
                        "ConsigneeName" => $order->name,
                        "Phone1" => $postMobile,
                        "Phone2" => "",
                        "Address" => $order->address,
                        "Email" => $order->email,
                        "SelfPick" => "false",
                        "ShipperOrderID" => $order->order_id,
                        "ProductTypeID" => "13",
                        "PaymentModeID" => "1",
                        "ProductDescription" => $order->product,
                        "Quantity" => "1",
                        "SpecialInstruction" => "Hanlde With Care",
                        "EstimatedWeight" => "0.5",
                        "NoOfBag" => "1",
                        "COD" => (int)$order->price,
                        "ReplacementProductTypeID" => "",
                        "ReplacementProductDescription" => "",
                        "ReplacementQuantity" => "",
                        "ReplacementParcelno" => "",
                        "ReplacementDeclaredValue" => "",
                        "ParcelDeclaredValue" => "10000"
                    ]
                )->asJson()
                ->post();
                if($response[0]->ParcelNo){
                    $order->update([
                        'cn' => $response[0]->ParcelNo,
                    ]);
                    $this->sendMsg($order);
                    return [
                        'status' => 'success',
                        'message' => 'Successfully Shipped to Stallion Delivery'
                    ];
                }else{
                    $order->update([
                        'status' => $oldStatus,
                        'dispatch_to' => null,
                        'dispatch_by' => null,
                        'dispatch_remark' => null,
                    ]);
                    return [
                        'status' => 'error',
                        'message' => 'Something wrong'
                    ];
                }
        } else {
            return $tokenData['error'];
        }
    }
    function blueExShipment($order, $oldStatus)
    {
        $mobile = $order->orderNumbers()->first();
        $order_remark = '';
        $remarks = $order->remarks;
        foreach ($remarks as $index => $remark) {
            if ($index == 0) {
                $order_remark = $remark->remark;
            } else {
                $order_remark = $order_remark . ', ' . $remark->remark;
            }
        }
        $checkMobile = substr($mobile->mobile, 0, 3);
        $postMobile = '';
        if ($checkMobile == "+92") {
            $postMobile = str_replace("+92", "0", $mobile->mobile);
        }
        $response = Curl::to('https://bigazure.com/api/json_v3/shipment/create_shipment.php')
            ->withOption('USERPWD', "KHI-07993:Q4Ms2LwkyZgTtnOYnLe")
            ->withData([
                "shipper_name" => "Naviforce/benyar",
                "shipper_email" => "watchzone.pk@gmail.com",
                "shipper_contact" => "03419300003",
                "shipper_address" => "Office no. 1015, 10th floor, muhammadi trade tower nearby technosity main new challi karachi.",
                "shipper_city" => "KHI",
                "customer_name" => $order->name,
                "customer_email" => $order->email,
                "customer_contact" => $postMobile,
                "customer_address" => $order->address,
                "customer_city" =>  $order->dispatch_to,
                "customer_country" => "PK",
                "customer_comment" => $order_remark,
                "shipping_charges" => "150",
                "payment_type" => "COD",
                "service_code" => "BE",
                "total_order_amount" => (int)$order->price,
                "total_order_weight" => "0.5",
                "order_refernce_code" => $order->order_id,
                "fragile" => "N",
                "parcel_type" => "P",
                "insurance_require" => "N",
                "insurance_value" => "0",
                "testbit" => "Y",
                "cn_generate" => "Y",
                "multi_pickup" => "Y",
                "products_detail" => [
                    [
                        "product_code" => "1005",
                        "product_name" => $order->product,
                        "product_price" => (int)$order->price,
                        "product_weight" => "0.5",
                        "product_quantity" => $order->quantity,
                        "product_variations" => "",
                        "sku_code" => "12assk11aa"
                    ],
                ]
            ])
            ->asJson()
            ->post();
            if(isset($response->cn)){
                $order->update([
                    'cn' => $response->cn,
                ]);
                $this->sendMsg($order);
                return [
                    'status' => 'success',
                    'message' => 'Successfully Shipped to BlueEx'
                ];
            }else{
                $order->update([
                    'status' => $oldStatus,
                    'dispatch_to' => null,
                    'dispatch_by' => null,
                    'dispatch_remark' => null,
                ]);
                return [
                    'status' => 'error',
                    'message' => 'Something Wrong'
                ];
            }
    }
    function postexShipment($order, $oldStatus)
    {
        $response = Curl::to('https://api.postex.pk/services/integration/api/order/v1/get-merchant-address')
            ->withHeaders([
                'token' => 'ZTlkOGIwYmI3NjVkNDFmOWI1ODcyMWRkZDRjYWU0MTI6NGEzNTM5MzMwZjRhNDhlOTk2NDVhZTY3ZThjYzhiZTQ=', // Setting Content-Type header
            ])
            ->asJson()
            ->get();
        if ($response->statusCode == 200) {
            $addressCode = $response->dist[0]->addressCode;
            $mobile = $order->orderNumbers()->first();
            $checkMobile = substr($mobile->mobile, 0, 3);
            $postMobile = '';
            if ($checkMobile == "+92") {
                $postMobile = str_replace("+92", "0", $mobile->mobile);
            }
            $response = Curl::to('https://api.postex.pk/services/integration/api/order/v3/create-order')
                ->withHeaders([
                    'token' => 'ZTlkOGIwYmI3NjVkNDFmOWI1ODcyMWRkZDRjYWU0MTI6NGEzNTM5MzMwZjRhNDhlOTk2NDVhZTY3ZThjYzhiZTQ=', // Setting Content-Type header
                ])->withData([
                    "cityName" => $order->dispatch_to,
                    "customerName" => $order->name,
                    "customerPhone" => $postMobile,
                    "deliveryAddress" => $order->address,
                    "invoiceDivision" => 1,
                    "invoicePayment" => (int)$order->price,
                    "items" => 1,
                    "orderDetail" => $order->product,
                    "orderRefNumber" => $order->order_id,
                    "orderType" => "Normal",
                    // "transactionNotes" => "PK",
                    "pickupAddressCode" => $addressCode,
                    // "storeAddressCode" => "PK",
                ])
                ->asJson()
                ->post();
            if ($response->statusCode == 200) {
                $order->update([
                    'cn' => $response->dist->trackingNumber,
                ]);
                $this->sendMsg($order);
                return [
                    'status' => 'success',
                    'message' => $response->statusMessage
                ];
                // return $response;
            } else {
                $order->update([
                    'status' => $oldStatus,
                    'dispatch_to' => null,
                    'dispatch_by' => null,
                    'dispatch_remark' => null,
                ]);
                return [
                    'status' => 'error',
                    'message' => $response->statusMessage
                ];
            }
        }
    }
    function sendMsg($order)
    {
        $mobile = $order->orderNumbers()->first();
        $senderId = '';
        if ($order->shop_name == 'Benyar.com.pk' || $order->shop_name == 'Benyar.co') {
            $senderId = 'BENYAR';
        }
        if ($order->shop_name == 'Naviforcewatches.co' || $order->shop_name == 'Naviforcewatches.com.pk') {
            $senderId = 'NaviForce';
        }

        $message = "Hi $order->name,
            Your Order ID $order->order_id  has been shipped via TCS Courier.
            Your tracking number is $order->cn.
            $senderId Team.";

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
