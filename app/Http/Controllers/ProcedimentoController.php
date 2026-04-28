<?php

// app/Http/Controllers/ProcedimentoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedimento;
use App\Models\Medico;

class ProcedimentoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $procedimentos = Procedimento::all();
        
        return view('procedimentos.index', compact('procedimentos')); // Return the view with the Procedimentos data
    }

    public function store(Request $request)
    {
        $procedimento = new Procedimento();
        $procedimento->nome_proc = $request->input('nome_proc');
        $procedimento->descricao_proc = $request->input('descricao_proc');
        $procedimento->save();
    
        return redirect()->route('procedimentos.index')->with('success', 'Procedimento cadastrado com sucesso!');
    }

    public function edit($pk_cod_proc)
    {
        $procedimento = Procedimento::find($pk_cod_proc);
        return view('procedimentos.edit', compact('procedimento', 'medicos'));
    }
    
    public function update(Request $request, $pk_cod_proc)
    {
        $procedimento = Procedimento::find($pk_cod_proc);
        $procedimento->nome_proc = $request->input('nome_proc');
        $procedimento->descricao_proc = $request->input('descricao_proc');
        $procedimento->save();
    
        return redirect()->route('procedimentos.index');
    }

    public function destroy($pk_cod_proc)
    {
        $procedimento = Procedimento::find($pk_cod_proc);
        $procedimento->delete();
        return redirect()->route('procedimentos.index')->with('success', 'Procedimento excluído com sucesso!');
    }

    public function atualizarStatus(Request $request, $id)
    {
        $procedimento = Procedimento::findOrFail($id);
        $procedimento->status = $request->status;
        $procedimento->save();

        return response()->json(['success' => true]);
    }    
}