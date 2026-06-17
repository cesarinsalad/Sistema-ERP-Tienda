<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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

    public function rules()
    {
        $rules = [
            'product.*' => [
                'max:'
            ],
            'vendedor_id' => [
                'nullable',
                'exists:empleados,id'
            ]
        ];

        // If client is not selected, we validate the new client fields
        if (!$this->input('client_id_name')) {
            $rules['cedula_name'] = ['required', 'regex:/^[0-9]{1,8}$/', 'unique:clients,cedula'];
            $rules['client_nom'] = ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s\-\'\.]+$/u'];
            $rules['client_ape'] = ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s\-\'\.]+$/u'];
            $rules['client_tel'] = ['required', 'regex:/^[0-9]{11}$/'];
            $rules['client_dir'] = ['required', 'string', 'max:50'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'cedula_name.required' => 'La cédula es obligatoria.',
            'cedula_name.regex' => 'La cédula solo puede contener números enteros y tener un máximo de 8 caracteres.',
            'cedula_name.unique' => 'La cédula ya se encuentra registrada.',
            'client_nom.required' => 'El nombre es obligatorio.',
            'client_nom.max' => 'El nombre no puede superar los 50 caracteres.',
            'client_nom.regex' => 'El nombre solo puede contener letras, espacios, guiones, apóstrofes y puntos.',
            'client_ape.required' => 'El apellido es obligatorio.',
            'client_ape.max' => 'El apellido no puede superar los 50 caracteres.',
            'client_ape.regex' => 'El apellido solo puede contener letras, espacios, guiones, apóstrofes y puntos.',
            'client_tel.required' => 'El teléfono es obligatorio.',
            'client_tel.regex' => 'El teléfono debe contener solo números y tener exactamente 11 caracteres.',
            'client_dir.required' => 'La dirección es obligatoria.',
            'client_dir.max' => 'La dirección no puede superar los 50 caracteres.',
        ];
    }
}
