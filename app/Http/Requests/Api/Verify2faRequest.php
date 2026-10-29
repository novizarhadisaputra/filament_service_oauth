<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Verify2faRequest
 *
 * Verify2fa Request.
 */
class Verify2faRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required_without:two_factor_token|nullable|uuid|exists:users,id',
            'two_factor_token' => 'required_without:user_id|nullable|string',
            'code' => 'required|string|min:6|max:20',
            'system_slug' => 'nullable|string|exists:systems,slug',
        ];
    }
}
