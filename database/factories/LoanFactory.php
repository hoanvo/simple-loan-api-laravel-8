<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount'          => $this->faker->numberBetween(1000, 100000),
            'arrangement_fee' => $this->faker->numberBetween(100, 1000),
            'interest_rate'   => $this->faker->randomFloat(2, 5, 12),
            'term'            => $this->faker->randomElement(['12', '24']),
            'frequency'       => 'weekly'
        ];
    }
}
