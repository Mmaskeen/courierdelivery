<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderNumbers;
use App\Models\OrderRemark;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportOldData implements ToCollection,WithHeadingRow
{

    private $output;

    public function __construct($output)
    {

        $this->output = $output;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        $bar = $this->output->createProgressBar(count($collection));

        $this->output->writeln('Number of Record Found : '.count($collection));

        $bar->start();

        foreach ($collection as $key => $data) {
            $this->createOrder($data);

            $bar->advance();
        }
        $bar->finish();
    }

    public function createOrder($data){
        $this->output->writeln('Number of Record Found : '.$data['orderno']);
        $order = Order::create([
            'order_taker_id' => '3',
            'name' => $data['f_name'] ? $data['f_name'] : 'oldDataMissing',
            'order_id' => $data['orderno'] ? 'old'.$data['orderno'] : 'oldDataMissing',
            'address' => $data['address'] ? $data['address'] : 'oldDataMissing',
            'status' => 'Dispatched',
            'product' => $data['product_name'] ? substr($data['product_name'], 0, 60)  : 'oldDataMissing',
            'quantity' => $data['quantity'],
            'price' => $data['product_price'] ? $data['product_price'] : '0',
            'email' => $data['email'] ? $data['email'] : 'watchzone.pk@gmail.com',
            'city' => $data['city'] ? $data['city'] : 'oldDataMissing',
            'shop_name' => 'OldShop',
            'currency' => 'Pkr',
            'created_at' => $data['newdate'],
        ]);

        OrderNumbers::create([
            'mobile' => $data['mobile'] ? $data['mobile']  : '00000000000',
            'order_id' => $order->id
        ]);
    }
}
