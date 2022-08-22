<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'original_url' => 'nullable|url',
            'custom_url' => 'nullable|string',
            'active' => 'nullable|boolean',
            'expiration_date' => 'nullable|date_format:"Y-m-d H:i:s"|after:yesterday',
        ];
    }
}
