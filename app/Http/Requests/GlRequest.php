<?php

namespace App\Http\Requests;

use App\Models\GeneralLedger;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

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
        if (request()->has('service')) {
            $validation = ['service' => 'required'];

            $this->gl = GeneralLedger::whereHas('service', function ($q) {
                $q->where('slug', request('service'));
            })?->first();
        }
        else {
            $this->gl = GeneralLedger::first();
        }

        return $validation ?? [];
    }


    public function updateRequest(): array
    {
        return [
            'amount' => 'required|numeric'
        ];
    }
}
