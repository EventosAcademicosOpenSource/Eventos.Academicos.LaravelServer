<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventChildrenRequest extends FormRequest
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
                        'name' => 'required|string|max:191',
                        'palestrante' => 'required', 
                        'local' => 'required|max:255',
                        'date_time' => 'required',
                        'document' => 'nullable|max:150|url',
                    ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:191',
                    'local' => 'required|max:255',
                    'palestrante' => 'required', 
                    'date_time' => 'required',
                    'document' => 'nullable|max:150|url',
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
                'palestrante.required' => 'Selecione um Palestrante',
                'document.max' => 'O url deve ter tamanho máximo de 150 caracteres.',
                'document.url' => 'O documento do deve ser uma url.',
                'name.required' => 'O título é campo obrigatório.',
                'name.unique' => 'Já possui uma palestra com esse Título.',
                'name.max' => 'Use 191 caracteres ou menos para o Título da palestra.',
                'local.max' => 'Use 255 caracteres ou menos para o Local da palestra.',
                'local.required' => 'O local da palestra é obrigatório',
                'date_time.required' => 'A data e horário da palestra é obrigatória.'
        ];
    }
}
