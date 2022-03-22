<?php

namespace App\Domain\Repositories;



use App\Models\Orders;

class OrdersRepository extends Repository
{


    /**
     * @var Orders
     */
    protected $model;




    public function __construct(Orders $model)
    {
        $this->model = $model;



    }
    public function getOrderTotal($meals){
        $totalPrice = 0;
        $totalDiscount = 0;

        foreach ($meals as $meal){
            dd($meal);
            $mealPrice = $meal['price'] ;
            $mealDiscount = ($meal['discount'] * 100) /  $mealPrice;

            $totalPrice += $mealPrice;
            $totalDiscount += $mealDiscount;


        }
        return ['totalDiscount' => $totalDiscount , 'totalPrice' => $totalPrice];
    }
}
