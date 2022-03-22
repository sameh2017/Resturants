<?php

namespace Database\Factories;

use App\Models\Meals;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meals::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->name,
            'price' => $this->faker->numberBetween( 50,  150),
            'discount' => $this->faker->numberBetween( 2,  5),
            'av_qty' => $this->faker->numberBetween( 10,  50),

        ];
    }

}
