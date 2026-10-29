<?php

namespace App\Http\Requests\Api\Integrations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PermissionSyncRequest
 *
 * Permission Sync Request.
 */
class PermissionSyncRequest extends FormRequest
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
            'system_slug' => 'required|string|exists:systems,slug',
            'permissions' => 'required|array',
            'permissions.*' => 'required|string',
        ];
    }
}
