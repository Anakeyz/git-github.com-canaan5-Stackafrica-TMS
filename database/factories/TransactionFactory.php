<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $s = Service::all()->pluck('id')->toArray();

        $amount = fake()->randomNumber(5);
        $charge = (1.5 / 100) * $amount;
        $total = $amount + $charge;

        return [
            'type_id'   => $s[rand(0, count($s) - 1)],
            'amount'    => $amount,
            'charge'    => $charge,
            'total_amount' => $total,
            'reference' => Str::random(),
            'status'    => 'SUCCESSFUL',
            'info'      => 'Seeded',
//            'created_at' => fake()->dateTimeBetween('- 2 months')
        ];
    }
}
