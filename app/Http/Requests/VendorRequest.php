<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name' => 'required|string|between:3,40',
            'type_document'=>  'required|string|in:CI,RIF',
            'document'=> 'required|integer|between:500000,1000000000',
            'description' => 'required|string|between:3,40',
        ];
    }
}
