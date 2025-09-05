<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class livroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "autor" => "required|string",
            "titulo" => "required|string",
            "sinopse" => "required|string",
            "capa" => "sometimes|string",
            "tags" => "sometimes|string",
            "descricao" => "required|string",
            "categoria" => "required|string|in:ficção,romance,terror,mistério,autoajuda,biografia,poesia,contos,suspense,outros",

        ];
    }
}
