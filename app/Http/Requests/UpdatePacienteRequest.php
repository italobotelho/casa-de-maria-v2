<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:pacientes,pk_cod_paci',
            'img_paci' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'angulo_rotacao' => 'nullable|integer',
            'nome_paci' => 'required|string|max:54',
            'email_paci' => 'required|email',
            'data_nasci_paci' => 'required|date',
            'telefone_paci' => 'required|string|max:15',
            'genero' => 'required',
            'cpf_paci' => 'required|string|max:14|cpf',
            'responsavel_paci' => 'nullable|string|max:54',
            'cpf_responsavel_paci' => 'nullable|string|max:14',
            'fk_convenio_paci' => 'nullable|string',
            'carteira_convenio_paci' => 'nullable|string',
            'cep_paci' => 'nullable|string|max:9',
            'rua_paci' => 'nullable|string|max:50',
            'numero_paci' => 'nullable|string|max:5',
            'bairro_paci' => 'nullable|string|max:50',
            'cidade_paci' => 'nullable|string|max:30',
            'complemento_paci' => 'nullable|string|max:100',
            'uf_paci' => 'nullable|string|max:2',
            'data_obito_paci' => 'nullable|date',
        ];
    }
}
