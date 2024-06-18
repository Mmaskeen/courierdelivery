<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    private $orders;

    public function __construct($orders)
    {

        $this->orders = $orders;

    }
    public function view(): View
    {
        $orders = $this->orders;

        return view('admin.export.export-selected-order', compact('orders'));
    }
//    public function collection()
//    {
//        return $this->orders;
//    }
//    public function headings(): array
//    {
//        return [
//            'ORDER ID',
//            'Order_taker_id',
//            'NAME',
//            'ADDRESS',
//            'PRODUCT URL',
//            'QTY',
//            'PRICE',
//            'EMAIL',
//            'CITY',
//            'REMARKS',
//            'STATUS',
//            'Deleted_AT',
//            'CREATED_AT',
//            'UPDATED_AT',
//
//        ];
//    }
}

