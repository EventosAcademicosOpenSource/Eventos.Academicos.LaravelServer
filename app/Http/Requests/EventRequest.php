<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
                    'name' => 'required|string|max:191|unique:events', 
                    'local' => 'required|max:255',
                    'link' => 'nullable|max:150|url',
                    'date_time' => 'required',
                    'image' => 'nullable|image|max:8000',
                    ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:191|unique:events,name,'.$this->id,
                    'local' => 'required|string|max:255',
                    'link' => 'nullable|max:150|url',
                    'date_time' => 'required',
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
                'name.required' => 'O nome é campo obrigatório.',
                'name.unique' => 'Já possui um evento com esse nome.',
                'name.max' => 'O campo nome deve ter no máximo 191 caracteres.',
                'local.max' => 'O campo local deve ter no máximo 255 caracteres.',
                'local.required' => 'O local do evento é obrigatório',
                'link.url' => 'O link do Site tem que ser uma URL',
                'link.max' => 'O link deve ter no máximo 150 caracteres.',
                'date_time.required' => 'A data do evento é obrigatória.'
        ];
    }
}
