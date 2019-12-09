<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SponsorRequest extends FormRequest
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
        switch($this->method())
        {
            case 'POST':
            {
                $rules= [
                    'name' => 'required|string|max:255', 
                    'email' => 'required|string|email|max:150|unique:sponsors',
                    'link' => 'nullable|max:150|url',
                    'image' => 'nullable|image|max:8000',
                    ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:255', 
                    'email' => 'required|string|email|max:150|unique:sponsors,email,'.$this->id,
                    'link' => 'nullable|max:150|url',
                    'image' => 'nullable|image|max:8000',
                ];
            }
            default:break;
        }
        return [
            
        ];
    }
    
    public function messages()
    {
        return [
                'image.max' => 'A imagem deve ter tamanho maximo de 8Mb.',
                'name.required' => 'O nome é campo obrigatório',
                'name.max' => 'Campo nome pode ter no máximo 250 caracteres',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Verifique o campo de e-mail.',
                'email.unique' => 'Este e-mail já está em uso',
                'email.max' => 'E-mail pode ter no máximo 150 caracteres',
                'link.url' => 'O link do Site tem que ser uma URL',
                'link.max' => 'O link deve ter no máximo 150 caracteres.'
        ];
    }
}
