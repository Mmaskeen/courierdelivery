<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded=[];
    const Admin = 'admin';
    const Employee = 'employee';
}
