<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
                    'title' => 'required|string|max:150', 
                    'message' => 'required|string|max:150',
                    ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|string|max:150', 
                    'message' => 'required|string|max:150',
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
                'title.max' => 'Use 150 caracteres ou menos para o título da notificação',
                'message.max' => 'Use 150 caracteres ou menos para o texto da notificação',
                'message.required' => 'Está faltando o texto da notificação',
                'title.required' => 'Está faltando o título da notificação',
        ];
    }
}
