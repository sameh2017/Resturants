<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Reservations extends Model
{
    protected $table='reservations';
    protected $guarded = [];
    protected $timestamp=false;



    public function tables(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tables::class,'id' ,'table_id');
    }

    public function customers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Customers::class,'id' , 'customer_id');
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Orders::class,'reservation_id');
    }
}
