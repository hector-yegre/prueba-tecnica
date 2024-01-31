<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class storeRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // definir rglas de validacion
            "email"=>"required",
            "name"=>"required",
            "password"=>"required",
            
        ];
    }

    public function failedValidation( Validator $validator ){
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            "email.required"=> "El correo es Obligatorio",
            "password.required"=> "la contraseña es obligatorio",
            "name.required"=> "El  nombre es obligatorio",
        ];
    }
}
