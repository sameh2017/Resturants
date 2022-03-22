<?php

namespace App\Domain\Repositories;



use App\Models\OrderDetails;

class OrderDetailsRepository extends Repository
{


    /**
     * @var OrderDetails
     */
    protected $model;




    public function __construct(OrderDetails $model)
    {
        $this->model = $model;


    }
}
