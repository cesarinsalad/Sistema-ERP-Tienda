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
            'document'=> ['required', 'string', 'max:15', 'regex:/^[a-zA-Z0-9\-]+$/'],
            'email' => 'nullable|email|max:255|unique:vendors,email,' . ($this->vendor ? $this->vendor->id : ''),
            'phone' => ['nullable', 'string', 'max:11', 'regex:/^[0-9]+$/'],
            'description' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre/razón social es obligatorio.',
            'name.max' => 'El nombre/razón social no puede tener más de 40 caracteres.',
            'document.required' => 'El documento es obligatorio.',
            'document.max' => 'El documento no puede tener más de 15 caracteres.',
            'document.regex' => 'El documento solo puede contener letras, números y guiones.',
            'phone.max' => 'El teléfono no puede tener más de 11 caracteres.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'description.required' => 'La descripción es obligatoria.',
            'description.max' => 'La descripción no puede tener más de 1000 caracteres.',
        ];
    }
}
