<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if(isset($this->articulo->id)){
            $id=$this->articulo->id;
        }else{
            $id=0;
        }
        return [
            'codigo' => 'required|string|between:5,15|unique:App\Product,codigo,'.$id,
            'nombre' => 'required|string|between:3,40',
            'descripcion' => 'required|string|between:2,500',
            'vendor_id' => 'required|exists:App\Vendor,id',
            'brand_id' => 'required|exists:App\Brand,id',
            'category_id' => 'required|exists:App\Category,id',
            'cantidad' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
        ];
    }
}
