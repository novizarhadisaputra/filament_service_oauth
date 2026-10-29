<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Confirm2faRequest
 *
 * Confirm2fa Request.
 */
class Confirm2faRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'secret' => 'required|string',
            'code' => 'required|string|min:6|max:20',
            'recovery_codes' => 'nullable|array',
            'recovery_codes.*' => 'string',
        ];
    }
}
