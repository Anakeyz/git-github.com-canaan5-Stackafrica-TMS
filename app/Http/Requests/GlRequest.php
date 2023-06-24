<?php

namespace App\Http\Requests;

use App\Models\GeneralLedger;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GlRequest extends FormRequest
{
    public $gl;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {

        return request()->method == 'GET' ? $this->showRequest() : $this->updateRequest();
    }

    private function showRequest(): array
    {
        $this->gl = GeneralLedger::whereHas('service', function ($q) {
            $q->where('slug', $this->service ?? 'cashoutwithdrawal');
        })?->first();

        return $this->has('service') ? ['service' => 'exists:services,slug'] : [];
    }


    public function updateRequest(): array
    {
        return [
            'amount' => 'required|numeric'
        ];
    }
}
