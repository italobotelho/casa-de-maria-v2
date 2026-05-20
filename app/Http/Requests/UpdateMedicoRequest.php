<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:medicos,pk_crm_med',
            'nome' => 'required|string|max:255',
            'especialidade' => 'required|string|max:255',
            'especialidade2' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'uf' => 'string|max:2',
        ];
    }
}
