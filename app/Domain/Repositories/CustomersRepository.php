<?php

namespace App\Domain\Repositories;



use App\Models\Customers;

class CustomersRepository extends Repository
{


    /**
     * @var Customers
     */
    protected $model;




    public function __construct(Customers $model)
    {
        $this->model = $model;


    }
}
