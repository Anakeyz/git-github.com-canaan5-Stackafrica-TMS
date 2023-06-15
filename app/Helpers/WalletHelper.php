<?php

namespace App\Helpers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletHelper
{

    public static function creditTransaction(Transaction $transaction): array
    {
        try {
            $wallet = $transaction->agent->wallet;

            // Check if wallet is active
            if (!$wallet->is_active) {
                return [
                    'success' => false,
                    'message' => "Wallet is {$wallet->status}"
                ];
            }

            $response = [
                'success' => false,
                'message' => 'Error crediting wallet'
            ];

            DB::transaction(function () use ($transaction, $wallet, &$response ) {

                $prev_bal = $wallet->balance;
                $wallet->balance += (double) $transaction->total_amount;

                $wallet->updated_at = now();
                $wallet->save();

                $wallet->transactions()->create([
                    'user_id' => $transaction->user_id,
                    'amount' => $transaction->total_amount,
                    'reference' => $transaction->reference,
                    'type' => 'CREDIT',
                    'prev_balance' => $prev_bal,
                    'new_balance' => $wallet->balance,
                    'status' => $transaction->status,
                    'info' => $transaction->info,
                    'product_id' => $transaction->type_id,
                ]);

                $response = [
                    'success' => true,
                    'message' => 'Wallet crediting was successful.'
                ];
            });

            return $response;

        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * Credit user Wallet
     *
     * @param User $user
     * @param float $amount
     * @param string $info
     * @param string $trans_type
     * @param string $reference
     * @return array
     */
    public static function credit(User $user, float $amount, string $info, string $reference, string $trans_type = 'OTHERS' ): array
    {
        try {
            $wallet = $user->wallet;

            // Check if wallet is active
            if (!$wallet->is_active) {
                return [
                    'success' => false,
                    'message' => "Wallet is {$wallet->status}"
                ];
            }

            $response = [
                'success' => false,
                'message' => 'Error crediting wallet'
            ];

            DB::transaction(function () use ($user, $wallet, $amount, $info, $trans_type, &$response, $reference ) {

                $prev_bal = $wallet->balance;
                $wallet->balance += $amount;

                $wallet->updated_at = now();
                $wallet->save();

                $wallet->transactions()->create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'reference' => $reference ?? General::generateReference('wallet'),
                    'type' => 'CREDIT',
                    'prev_balance' => $prev_bal,
                    'new_balance' => $wallet->balance,
                    'info' => $info,
                    'product' => $trans_type,
                ]);

                $response = [
                    'success' => true,
                    'message' => 'Wallet crediting was successful.'
                ];
            });

            return $response;

        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * Debit user Wallet
     *
     * @param User $user
     * @param float $amount
     * @param string $info
     * @param string $reference
     * @param string $trans_type type/product of transactions
     * @param bool $allow_negative
     * @return array
     */
    public static function debit(User $user, float $amount, string $info, string $reference, string $trans_type = 'OTHERS' , bool $allow_negative = false): array
    {
        try {
            $wallet = $user->wallet;

            // Check if wallet is active
            if (!$wallet->is_active) {
                return [
                    'success' => false,
                    'message' => "Wallet is {$wallet->status}"
                ];
            }

            if ($amount > $wallet->balance) {
                if ( !$allow_negative) {
                    return [
                        'success' => false,
                        'message' => "Insufficient Fund!"
                    ];
                }
            }

            $response = [
                'success' => false,
                'message' => 'Error with debit'
            ];

            DB::transaction(function () use ($user, $wallet, $amount, $info, $trans_type, $reference, &$response ) {

                $prev_bal = $wallet->balance;

                $wallet->balance -= $amount;
                $wallet->updated_at = now();
                $wallet->save();

                $wallet->transactions()->create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'type' => 'DEBIT',
                    'reference' => $reference ?? General::generateReference('wallet'),
                    'prev_balance' => $prev_bal,
                    'new_balance' => $wallet->balance,
                    'info' => $info,
                    'product' => $trans_type,
                ]);

                $response = [
                    'success' => true,
                    'message' => 'Wallet debit was successful.'
                ];
            });

            return $response;
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
