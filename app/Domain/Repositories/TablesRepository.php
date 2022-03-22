<?php

namespace App\Domain\Repositories;



use App\Models\Tables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TablesRepository extends Repository
{


    /**
     * @var Tables
     */
    protected $model;
    protected $guarded = [];
    public $timestamps = false;





    public function __construct(Tables $model)
    {
        $this->model = $model;


    }

    public function getAvailableTables($data){

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $data['from_time']);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s',  $data['from_time']);
        $query=    $this->model->latest()->select('tables.id')
           ->where('tables.capacity' , $data['no_gust'])
           ->whereNotIn('tables.id', function ($query) use($startDate , $endDate ) {
               $query->select('table_id')->from('reservations')
                   ->where('reservations.from_time' , '>' , $startDate)
                   ->where('reservations.to_time' , '<' , $endDate);
           })


           ->first();
        return $query;

    }
}
