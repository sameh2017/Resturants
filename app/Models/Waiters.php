<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiters extends Model
{
    use HasFactory;
    protected $table='waiters';
    protected $guarded = [];
    public $timestamps = false;
    public function orders(){
        return $this->hasMany(Orders::class,'waiter_id');
    }


}
