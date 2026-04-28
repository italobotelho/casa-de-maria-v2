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

    public function store(Request $request)
    {       

        // Remove formatting characters
        $cnpj = preg_replace('/\D/', '', $request->input('cnpj_clin'));
        $telefone = preg_replace('/\D/', '', $request->input('telefone_clin'));

        // Check if a record with the same value already exists
        $existingClinica = Clinica::first();

        if ($existingClinica) {
            // If a record exists, update it instead of creating a new one
            $existingClinica->fill($request->all());
            $existingClinica->save();
            return redirect()->route('clinica.index')->with('success', 'Dados da clínica atualizados com sucesso!');
        } else {
            // If no record exists, create a new one
            $clinica = new Clinica();
            $clinica->cnpj_clin = $cnpj;
            $clinica->nome_clin = $request->input('nome_clin');
            $clinica->descricao_clin = $request->input('descricao_clin');
            $clinica->telefone_clin = $telefone;
            $clinica->email_aten_clin = $request->input('email_aten_clin');
            $clinica->email_resp_clin = $request->input('email_resp_clin');
            $clinica->cep_clin = $request->input('cep_clin');
            $clinica->rua_clin = $request->input('rua_clin');
            $clinica->numero_clin = $request->input('numero_clin');
            $clinica->bairro_clin = $request->input('bairro_clin');
            $clinica->complemento_clin = $request->input('complemento_clin');
            $clinica->cidade_clin = $request->input('cidade_clin');
            $clinica->uf_clin = $request->input('uf_clin');
            $clinica->cod_ibge_clin = $request->input('cod_ibge_clin');

            // Save the model
            $clinica->save();

            // Redirect to the success page
            return redirect()->route('clinica.index')->with('success', 'Dados da clínica cadastrados com sucesso!');
        }
    }   

    public function update(Request $request)
    {
        $clinica = Clinica::first(); // retrieve the first clinica record
        $clinica->fill($request->all()); // fill the model with the input data
        $clinica->save(); // save the changes
        return redirect()->with('success', 'Dados da clínica atualizados com sucesso!');
    }
}
