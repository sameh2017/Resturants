<?php

namespace App\Domain\Repositories;



use App\Models\Meals;

class MealsRepository extends Repository
{


    /**
     * @var Meals
     */
    protected $model;




    public function __construct(Meals $model)
    {
        $this->model = $model;


    }

    public function getMealsTotal($meals){
        $totalPrice = 0;
        $totalDiscount = 0;

        foreach ($meals as $meal){
           $mealObj = $this->getById($meal['meal_id']);
            $mealPrice = ( $mealObj->price * $meal['amount']) ;
            $mealDiscount = (( $mealObj->discount * $meal['amount'])  * 100) /  $mealPrice;

            $totalPrice += $mealPrice;
            $totalDiscount += $mealDiscount;


        }
        return ['totalDiscount' => $totalDiscount , 'totalPrice' => $totalPrice];
    }
}
