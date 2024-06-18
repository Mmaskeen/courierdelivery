<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $employees = User::where('id','!=',auth()->user()->id)->get();

        return view('admin.report.report',compact('employees'));
    }

    public function staffActivitiesReport($id)
    {
        $data = [];
        $activities = ['Hold Order','Canceled','Dispatched','Proceeded','Latest'];
        foreach ($activities as $activity) {
            $data [] = [
                'y' => $activity,
                'a' => User::find($id)->UserOrders()->where('status', $activity)->count(),
            ];
        }
        return $data;
    }

    public function salesReport($data)
    {
        $finalData = [];

        if ($data == 'Weekly'){
            $weeklyArr = [];
            for ($i = 0; $i < 7; $i++){
                array_push($weeklyArr, Carbon::now()->startOfWeek()->addDays($i)->toDateString());
            }

            foreach ($weeklyArr as $week){
                $karachiWeeklySale = Order::where('city','karachi')->where('status',"Dispatched")->whereDate('created_at','>=', $week)->whereDate('created_at','<=',$week)->sum('price');
                $otherCitWeeklySale = Order::where('city','!=','karachi')->where('status',"Dispatched")->whereDate('created_at','>=',$week)->whereDate('created_at','<=',$week)->sum('price');

                $weeklySaleArr = [
                    'period' => $week,
                    'karachi' => $karachiWeeklySale,
                    'Other City' => $otherCitWeeklySale,
                ];

                array_push($finalData,$weeklySaleArr);
            }

        }elseif ($data == 'Monthly'){
            $monthsArr = ['Jan','Feb','March','April','May','Jun','July','Aug','Sep','Oct','Nov','Dec'];

            $date =[];
            foreach ($monthsArr as $key => $month){
               $incrementedKey = $key+1;
                $startDate = Carbon::now()->year.'-'.$incrementedKey.'-1';
                $endDate = Carbon::parse(Carbon::now()->year.'-'.$incrementedKey.'-1')->endOfMonth();

                $karachiOrder = Order::where('city','karachi')->where('status',"Dispatched")->whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)->sum('price');
                $otherCityOrders = Order::where('city','!=','karachi')->where('status',"Dispatched")->whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)->sum('price');

                $monthDataArr = [
                    'period' => $month,
                    'karachi' => $karachiOrder,
                    'Other City' => $otherCityOrders
                ];

                array_push($finalData,$monthDataArr);
            }
        }
        elseif ($data == 'Yearly'){
            $yearlyArr = [];
            for ($i = 0; $i < 5; $i++){
                array_push($yearlyArr, Carbon::now()->startOfYear()->subYear($i)->year);
            }

            foreach ($yearlyArr as $year){
                $yearStartDate = '01-01-'.$year;
                $yearEndDate = '31-12-'.$year;
                $karachiYearlySale = Order::where('city','karachi')->where('status',"Dispatched")->whereDate('created_at','>=',Carbon::parse($yearStartDate)->toDateString())->whereDate('created_at','<=',Carbon::parse($yearEndDate)->toDateString())->sum('price');
                $otherCitYearlySale = Order::where('city','!=','karachi')->where('status',"Dispatched")->whereDate('created_at','>=',Carbon::parse($yearStartDate)->toDateString())->whereDate('created_at','<=',Carbon::parse($yearEndDate)->toDateString())->sum('price');

                $yearlySaleArr = [
                    'period' => $year,
                    'karachi' => $karachiYearlySale,
                    'Other City' => $otherCitYearlySale
                ];

                array_push($finalData,$yearlySaleArr);
            }
        }else{
            $date = Carbon::now()->toDateString();
            $karachiDailySale = Order::where('city','karachi')->where('status',"Dispatched")->whereDate('created_at',$date)->sum('price');
            $otherCitDailySale = Order::where('city','!=','karachi')->where('status',"Dispatched")->whereDate('created_at',$date)->sum('price');
            $finalData [] = [
                'period' => $data,
                'karachi' => $karachiDailySale,
                'Other City' => $otherCitDailySale
            ];
        }
        return $finalData;
    }
}
