<?php

namespace App\Model\UserCenter;

//use Illuminate\Database\Eloquent\Model;

use App\Model\Model;

class User extends Model
{
    protected $table='users';
    protected $hidden=['password'];
    protected $guarded=['id'];
}