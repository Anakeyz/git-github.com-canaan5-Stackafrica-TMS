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
        $prohibited = Rule::prohibitedIf(!$this->user()->isAdmin());
        $unique = Rule::unique('users')->ignoreModel($this->user);

        return [
            'first_name' => 'string',
            'other_names' => 'string',
            'email' => ['email:rfc,dns', $unique],
            'phone' => ['digits:11', $unique],
            'gender' => 'nullable|in:MALE,FEMALE',
            'state' => [$prohibited, 'nullable',  'string'],
            'address' => [$prohibited, 'nullable', 'string'],
            'dob' => 'nullable|date',
            'status' => [$prohibited, 'nullable', Rule::in(User::ALL_STATUS)],
            'bvn' => ['nullable', 'digits:11', $unique],
            'nin' => ['nullable', 'digits:15', $unique],
        ];
    }
}
