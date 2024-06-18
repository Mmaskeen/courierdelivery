<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isAdmin()){

            return redirect(route('admin_dashboard'));
        }

        if (Auth::user()->isEmployee()){

            return redirect('employee/dashboard');
        }


        return redirect(404);
    }

    public function markNotificationRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response('success');
    }

    public function getTcsCity()
    {
        $response = Curl::to('https://apis.tcscourier.com/production/v1/cod/cities')
            ->withHeaders( array( 'accept: application/json', 'x-ibm-client-id: 51a21837-3d33-4760-b172-2e036a509cbf' ) )
            ->asJson()
            ->get();

        City::truncate();

        foreach ($response->allCities as $city){
            $cityName = strtolower($city->cityName);
            City::create([
                'name' => ucwords($cityName),
                'type' => 'Tcs'
            ]);
        }

        return redirect(route('admin_dashboard'))->with('success','City added successfully');
    }
    public function getStallionCity()
    {

        $response = Curl::to('http://109.163.232.133:8081/Stallion.asmx/cityname')
            ->post();

        $cities = collect(json_decode(json_encode((array) simplexml_load_string($response)), true));

        foreach ($cities as $city){
            foreach ($city as $cityName) {
                $cityNa = strtolower($cityName['CityName']);
                City::create([
                    'name' => ucwords($cityNa),
                    'type' => 'Stallion'
                ]);
            }
        }

        return redirect(route('admin_dashboard'))->with('success','City added successfully');
    }

    public function postOrderStallion(Request $request)
    {


        $response = Curl::to('https://bsms.hostandsoft.com/app/sms/api')

            ->withData( array(
                "action" => "send-sms",
                "api_key" => "d2F0Y2h6OjEyMzQ1Ng==",
                "to" => "+92346-6282329",
                "from" => "BENYAR",
                "sms" => "testing sms api Lahore",
            ) )->asJson()
            ->get();
        dd($response);
    }

}
