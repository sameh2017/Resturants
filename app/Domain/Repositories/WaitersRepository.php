<?php

namespace App\Domain\Repositories;



use App\Models\Waiters;

class WaitersRepository extends Repository
{


    /**
     * @var Waiters
     */
    protected $model;




    public function __construct(Waiters $model)
    {
        $this->model = $model;


    }
}
