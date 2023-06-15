<?php

namespace Database\Factories;

use App\Models\GeneralLedger;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GLT>
 */
class GLTFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type'      => Wallet::IMPACT_TYPE[rand(0,1)],
            'info'      => 'seeded',
            'amount'    => fake()->randomNumber(5),
            'prev_balance'  => fake()->randomNumber(5),
            'new_balance'   => fake()->randomNumber(6)
        ];
    }
}
