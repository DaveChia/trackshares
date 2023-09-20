<?php

namespace App\Http\Requests\UserListingController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'listings' => ['required', 'array', 'min:1'],
            "listings.*"  => "required|string|distinct|min:3|exists:listings,id",
        ];
    }
}
