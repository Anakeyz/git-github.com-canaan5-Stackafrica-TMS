<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        return [
            'status' => ['nullable', Rule::in(User::ALL_STATUS)],
            'bvn' => ['nullable', 'digits:11', Rule::unique('users', 'bvn')->ignoreModel($this->user)],
            'nin' => ['nullable', 'digits:15', Rule::unique('users', 'nin')->ignoreModel($this->user)],
        ];
    }


    public function fulfilled(): array
    {

        return collect($this->request->all())->filter()->toArray();
    }
}
