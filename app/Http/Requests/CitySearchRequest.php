<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitySearchRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'number_of_latest_comments' => 'nullable|integer|min:0',
        ];
    }
}
