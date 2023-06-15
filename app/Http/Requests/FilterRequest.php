<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
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
        return [];
    }

    public function getFilterData(): array
    {
        $data = request()->only('service', 'email', 'status');

        if (!request()->anyFilled('date_range', 'email', 'service', 'status')) return $data;

//        dd(request('from'), request('to'));
        return $data;
    }
}
