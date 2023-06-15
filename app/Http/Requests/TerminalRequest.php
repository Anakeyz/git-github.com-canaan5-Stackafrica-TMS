<?php

namespace App\Http\Requests;

use App\Models\Terminal;
use App\Models\User;
use App\Rules\UserIsAgent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerminalRequest extends FormRequest
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
        return $this->routeIs('terminals.store')
            ? $this->createRequest() : $this->updateRequest();
    }

    private function createRequest(): array
    {
        return [
            'email'         => ['required', 'email', 'exists:users,email', new UserIsAgent()],
            'tid'           => 'required|size:8|unique:terminals,tid',
            'mid'           => 'required|size:15',
            'serial'        => 'required|max:20|unique:terminals,serial',
            'device'        => 'required|string'
        ];
    }

    private function updateRequest()
    {
        return [
            'tid'           => ['nullable','size:8', Rule::unique('terminals', 'tid')->ignore($this->route('terminal'))],
            'mid'           => 'nullable|size:15',
            'serial'        => ['nullable','max:20', Rule::unique('terminals', 'serial')->ignore($this->route('terminal'))],
            'device'        => 'nullable|string'
        ];
    }
}
