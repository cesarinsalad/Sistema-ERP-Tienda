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
            'name' => 'required|string|max:40',
            'type_document'=>  'required|string|in:CI,RIF',
            'document'=> 'required|string|max:15',
            'email' => 'nullable|email|max:255|unique:vendors,email,' . ($this->vendor ? $this->vendor->id : ''),
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
