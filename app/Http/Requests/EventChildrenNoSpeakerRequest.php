<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventChildrenNoSpeakerRequest extends FormRequest
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
                        'local' => 'required|max:255',
                        'date_time' => 'required'
                    ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:191',
                    'local' => 'required|max:255',
                    'date_time' => 'required'
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
                'name.required' => 'O título é campo obrigatório.',
                'name.max' => 'Use 191 caracteres ou menos para o Nome do Evento Integrante.',
                'local.max' => 'Use 255 caracteres ou menos para o Local do evento integrante',
                'local.required' => 'O local do evento integrante é obrigatório',
                'date_time.required' => 'A data e horário do evento integrante é obrigatório.'
        ];
    }
}
