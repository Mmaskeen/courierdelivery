<?php

namespace App\Http\Controllers\Admin;

use App\library\services\DashboardService;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {

        $this->dashboardService = $dashboardService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $monthsArr = ['Proceeded','Latest','Canceled','Hold Order','Dispatched'];
        $overAll = $this->dashboardService->overAll();
        $today = $this->dashboardService->today();

        $orders = $this->dashboardService->latestOrder();

        $chartData = [];

        foreach ($monthsArr as $key => $month){
            $startDate = Carbon::now()->year.'-'.$key.'-1';
            $endDate = Carbon::parse(Carbon::now()->year.'-'.$key.'-1')->endOfMonth();

            $karachiOrder = Order::where('status',$month)->count();
//            $karachiOrder = Order::where('city','karachi')->whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)->count();
//            $otherCityOrders = Order::where('city','!=','karachi')->whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)->count();

            $monthDataArr = [
                'y' => str_limit($month,5, $end = '.'),
                'a' => $karachiOrder
            ];

            array_push($chartData,$monthDataArr);
        }

//        dd($chartData);
        $finalDataStatusChart=[];
        $statusArr = ['Canceled','Hold Order' ,'Dispatched','Proceeded'];
        $allOrders = Order::count();

        foreach ($statusArr as $status){
            $val = Order::where('status',$status)->count();
            if ($allOrders !== 0){
             $finalVal = round(($val/$allOrders)*100,2);
            }else{
                $finalVal = 0;
            }
            $statusChart = [
              'value' =>  $finalVal,
              'label' => $status
            ];

            array_push($finalDataStatusChart,$statusChart);
        }

        return view('admin.dashboard',compact('overAll','today','orders','chartData','finalDataStatusChart'));
    }

}
