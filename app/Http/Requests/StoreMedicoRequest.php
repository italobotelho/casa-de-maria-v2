<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome_med' => 'required|string|max:54',
            'telefone_med' => 'required|string|max:15',
            'uf_med' => 'required|string|max:2',
            'email_med' => 'required|email',
            'especialidade1_med' => 'required|string|max:40',
            'especialidade2_med' => 'nullable|string|max:40',
            'pk_crm_med' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'nome_med.required' => 'O campo nome é obrigatório',
            'telefone_med.required' => 'O campo telefone é obrigatório',
            'uf_med.required' => 'O campo UF é obrigatório',
            'email_med.required' => 'O campo email é obrigatório',
            'especialidade1_med.required' => 'O campo 1° especialidade é obrigatório',
            'pk_crm_med.required' => 'O campo CRM é obrigatório'
        ];
    }
}
