<?php

namespace Database\Factories;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletTransaction>
 */
class WalletTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status'    => 'SUCCESSFUL',
            'type'      => Wallet::IMPACT_TYPE[rand(0,1)],
            'reason'    => WalletTransaction::REASON[rand(0,1)],
            'info'      => 'seeded',
            'amount'    => fake()->randomNumber(5),
            'prev_balance'    => fake()->randomNumber(5),
            'new_balance'    => fake()->randomNumber(6),
        ];
    }
}
