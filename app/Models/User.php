<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','bio','role_id','avatar','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->role_id == 1){
            return true;
        }

        return false;
    }

    public function isEmployee()
    {
        if ($this->role_id == 2){
            return true;
        }

        return false;
    }

    public function getNewOrderUrl()
    {
        if(Auth::user()->isAdmin()) {
            $return = url('admin/order/new-order');
        }else{
            $return = '#!';
        }
        return $return;
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'user_order','user_id','order_id');

    }
    public function getFormattedDateTimeForStatus()
    {
        return Carbon::parse($this->pivot->updated_at)->format('y-m-d');
    }
    public function scopeEmployee($query)
    {
        $query->where('role_id',Role::where('name',Role::Employee)->select('id')->first()->id);
    }

    public function UserOrders()
    {
        return $this->hasMany(Order::class,'order_taker_id','id');
    }

    public function riderOrders()
    {
        return $this->hasMany(Order::class,'dispatch_by','id');
    }
}
