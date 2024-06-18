<?php


namespace App\library\services;


use App\Models\Order;
use Carbon\Carbon;

class DashboardService
{
    public function overAll()
    {
        $latestOrders = Order::where('status','Latest')->count();
        $totalDispatched =Order::where('status','Dispatched')->count();
        $totalCanceled = Order::where('status','Canceled')->count();
        $totalProcessed = Order::where('status','Proceeded')->count();
        $totalHolderOrders = Order::where('status','Hold Order')->count();


        return [
            'latestOrders' => $latestOrders,
            'totalDispatched' => $totalDispatched,
            'totalCanceled' => $totalCanceled,
            'totalProcessed' => $totalProcessed,
            'totalHolderOrders' => $totalHolderOrders,
        ];
    }

    public function overAllLP($q)
    {
//        dd($q);
//        dd($q->count());
        $latestO12 = clone $q;
        $latestOrders = $latestO12->where('status','Latest')->count();
        return [
            'latestOrders' => $latestOrders,
            ];
    }

    public function overAllStatusBased($q)
    {
        $dispatchedKarachi = clone $q;
        $dispatchedOther = clone $q;
        $CanceledKarachi = clone $q;
        $CanceledOther = clone $q;
        $ProceededKarachi = clone $q;
        $ProceededOther = clone $q;
        $HoldOrderKarachi = clone $q;
        $HoldOrderOther = clone $q;
        $karachiDispatched = $dispatchedKarachi->whereStatus('Dispatched')->whereCity('Karachi')->count();
        $otherCityDispatched = $dispatchedOther->whereStatus('Dispatched')->where('city','!=','Karachi')->count();
        $karachiCancelled = $CanceledKarachi->whereStatus('Canceled')->whereCity('Karachi')->count();
        $otherCityCancelled = $CanceledOther->whereStatus('Canceled')->where('city','!=','Karachi')->count();
        $karachiProceeded = $ProceededKarachi->whereStatus('Proceeded')->whereCity('Karachi')->count();
        $otherCityProceeded = $ProceededOther->whereStatus('Proceeded')->where('city','!=','Karachi')->count();
        $karachiHolder = $HoldOrderKarachi->whereStatus('Hold Order')->where('city','Karachi')->count();
        $otherCityHolder = $HoldOrderOther->whereStatus('Hold Order')->where('city','!=','Karachi')->count();

        return [
            'karachiDispatched' => $karachiDispatched,
            'otherCityDispatched' => $otherCityDispatched,
            'karachiCancelled' => $karachiCancelled,
            'otherCityCancelled' => $otherCityCancelled,
            'karachiProceeded' => $karachiProceeded,
            'otherCityProceeded' => $otherCityProceeded,
            'karachiHolder' => $karachiHolder,
            'otherCityHolder' => $otherCityHolder,
        ];
    }

    public function today()
    {
        $latestOrders = Order::whereDate("created_at",Carbon::now()->toDateString())->where('status','Latest')->count();
        $totalDispatched =Order::whereDate("created_at",Carbon::now()->toDateString())->where('status','Dispatched')->count();
        $totalCanceled = Order::whereDate("created_at",Carbon::now()->toDateString())->where('status','Canceled')->count();
        $totalProcessed = Order::whereDate("created_at",Carbon::now()->toDateString())->where('status','Proceeded')->count();
        $totalHolderOrders = Order::whereDate("created_at",Carbon::now()->toDateString())->where('status','Hold Order')->count();
        $todayTrashed = Order::onlyTrashed()->whereDate('deleted_at',now()->toDateString())->count();

        return [
            'latestOrders' => $latestOrders,
            'totalDispatched' => $totalDispatched,
            'totalCanceled' => $totalCanceled,
            'totalProcessed' => $totalProcessed,
            'totalHolderOrders' => $totalHolderOrders,
            'todayTrashed' => $todayTrashed,
        ];
    }

    public function latestOrder()
    {
        $orders = Order::latest()->take(8)->get();

        return $orders;
    }
}
