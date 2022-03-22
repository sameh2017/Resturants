<?php

namespace App\Domain\Repositories;



use App\Models\Reservations;
use Illuminate\Support\Facades\DB;

class ReservationsRepository extends Repository
{


    /**
     * @var Reservations
     */
    protected $model;




    public function __construct(Reservations $model)
    {
        $this->model = $model;


    }

    public function checkAvailability($orderDetails){


        return $this->model->latest()
            ->where('table_id' ,$orderDetails['table_id'])
            ->where('from_time' , '>=' , $orderDetails['from_time'])
            ->where('to_time' , '<=' ,  $orderDetails['to_time'])
            ->where('created_at' , date('y-m-d h:i:s'))
            ->where('ordered' , 0)
            ->first();


}
public function getWaitingLIst($orderDetails){
    return $this->model->latest()->where('table_id' ,$orderDetails['table_id'])
        ->where('waiting_list' ,  1)
        ->where('ordered' , 0)
        ->count();
}
}
