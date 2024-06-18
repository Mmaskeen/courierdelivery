<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use SoftDeletes,Notifiable;
    protected $guarded=[];
    protected $appends = ['formatted_created_at'];


    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getCreatedAtMDYAttribute()
    {
        return $this->created_at->format('M, d, Y');
    }

    public function orderNumbers()
    {
        return $this->hasMany(OrderNumbers::class,'order_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_order','order_id','user_id')->withPivot('order_status')->withTimestamps();
    }

    public function remarks()
    {
        return $this->hasMany(OrderRemark::class,'order_id');
    }
    public function invoices()
    {
        return $this->hasMany(OrderInvoice::class,'order_id');
    }
    public function rider()
    {
        return $this->belongsTo(User::class,'dispatch_by','id');
    }
}
