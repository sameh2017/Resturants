<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    use HasFactory;

    protected $table='tables';
    protected $guarded = [];
    public $timestamps = false;
    public function reservations(){
        return $this->hasMany(Reservations::class,'table_id');
    }
}
