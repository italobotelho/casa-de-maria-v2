<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
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
        $rules = [
            'img_paci' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'angulo_rotacao' => 'nullable|integer',
            'nome_paci' => 'required|string|max:54',
            'data_nasci_paci' => 'required|date',
            'telefone_paci' => 'required|string|max:15',
            'email_paci' => 'required|email',
            'genero' => 'required',
            'fk_convenio_paci' => 'required|string',
            'data_obito_paci' => 'nullable|date',
            'cpf_paci' => 'required|string|max:14|cpf',
            'cep_paci' => 'nullable|string|max:9',
            'rua_paci' => 'nullable|string|max:50',
            'numero_paci' => 'nullable|string|max:5',
            'bairro_paci' => 'nullable|string|max:50',
            'cidade_paci' => 'nullable|string|max:30',
            'complemento_paci' => 'nullable|string|max:100',
            'uf_paci' => 'nullable|string|max:2',
        ];

        if ($this->has('data_nasci_paci')) {
            $birthDate = new \DateTime($this->input('data_nasci_paci'));
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;

            if ($age < 18) {
                $rules['cpf_responsavel_paci'] = 'required|string|max:14';
                $rules['responsavel_paci'] = 'required|string|max:54';
            }
        }

        return $rules;
    }
}
