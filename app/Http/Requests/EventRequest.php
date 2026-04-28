<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     *  @return array
     */

     public function rules(): array
     {
         return [
            'title' => 'required',
            'start' => 'required|date_format:Y-m-d H:i:s|before:end',
            'end' => 'required|date_format:Y-m-d H:i:s|after:start',
            'color' => 'required',
            'procedimento_id' => 'required',
            'medico' => 'required',
            // 'convenio' => 'required',
         ];
     }
     
     public function messages(): array    
     {
         return [
            'title.required' => 'O nome do paciente é obrigatório.',
            'procedimento_id.required' => 'Selecione um procedimento.',
            'medico.required' => 'Selecione um médico.',
            'start.before' => 'A hora inicial deve ser menor que o horário final.',
            'end.after' => 'A hora final deve ser maior que o horário inicial.',
         ];
     }
}
