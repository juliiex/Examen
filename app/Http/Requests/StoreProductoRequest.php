<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],

            'categoria_id' => [
                'required',
                'integer',
                'exists:categorias,id',
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'precio' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'activo' => [
                'boolean',
            ],
        ];
    }
}
