<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderNumbers extends Model
{
    protected $table = 'order_numbers';
    protected $guarded=[];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
