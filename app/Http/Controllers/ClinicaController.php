<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinica;

class ClinicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clinica = Clinica::first(); // retrieve the first clinica record
        return view('clinica.index', compact('clinica'));
    }

    private function validarClinica(Request $request)
    {
        return $request->validate([
            'cnpj_clin' => 'required|string|max:18',
            'nome_clin' => 'required|string|max:255',
            'descricao_clin' => 'nullable|string',
            'telefone_clin' => 'required|string|max:20',
            'email_aten_clin' => 'required|email|max:255',
            'email_resp_clin' => 'required|email|max:255',
            'cep_clin' => 'nullable|string|max:10',
            'rua_clin' => 'nullable|string|max:255',
            'numero_clin' => 'nullable|string|max:20',
            'bairro_clin' => 'nullable|string|max:255',
            'complemento_clin' => 'nullable|string|max:255',
            'cidade_clin' => 'nullable|string|max:255',
            'uf_clin' => 'nullable|string|max:2',
            'cod_ibge_clin' => 'nullable|string|max:20',
        ]);
    }

    public function store(Request $request)
    {       
        $validatedData = $this->validarClinica($request);

        // Remove formatting characters
        $validatedData['cnpj_clin'] = preg_replace('/\D/', '', $validatedData['cnpj_clin']);
        $validatedData['telefone_clin'] = preg_replace('/\D/', '', $validatedData['telefone_clin']);

        // Check if a record with the same value already exists
        $existingClinica = Clinica::first();

        if ($existingClinica) {
            // If a record exists, update it instead of creating a new one
            $existingClinica->fill($validatedData);
            $existingClinica->save();
            return redirect()->route('clinica.index')->with('success', 'Dados da clínica atualizados com sucesso!');
        } else {
            // If no record exists, create a new one
            $clinica = new Clinica();
            $clinica->fill($validatedData);
            $clinica->save();

            // Redirect to the success page
            return redirect()->route('clinica.index')->with('success', 'Dados da clínica cadastrados com sucesso!');
        }
    }   

    public function update(Request $request)
    {
        $validatedData = $this->validarClinica($request);

        $validatedData['cnpj_clin'] = preg_replace('/\D/', '', $validatedData['cnpj_clin']);
        $validatedData['telefone_clin'] = preg_replace('/\D/', '', $validatedData['telefone_clin']);

        $clinica = Clinica::first(); // retrieve the first clinica record
        if ($clinica) {
            $clinica->fill($validatedData); // fill the model with the validated data
            $clinica->save(); // save the changes
            return redirect()->back()->with('success', 'Dados da clínica atualizados com sucesso!');
        }
        
        return redirect()->back()->withErrors('Nenhuma clínica encontrada para atualizar.');
    }
}
