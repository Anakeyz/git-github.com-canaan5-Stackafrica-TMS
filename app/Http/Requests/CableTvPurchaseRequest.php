<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CableTvPurchaseRequest extends TerminalTransactionRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'decoder' => 'required|in:dstv,gotv,startimes',
            'decoderId' => 'required|string',
            'phone' => 'required|digits:11',
            'planCode' => 'required',
            'amount' => 'required|numeric',
            'months' => 'required|int|min:1',
            'paymentData' => 'required|array',
        ];
    }
}
