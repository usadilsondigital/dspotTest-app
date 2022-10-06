<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => 'required|unique:profiles|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|min:10|max:10',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'zipcode' => 'required|min:5|max:5',
            'available' => 'required'
        ];
    }
}
