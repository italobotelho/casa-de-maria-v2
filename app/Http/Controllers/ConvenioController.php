<?php

// app/Http/Controllers/ConvenioController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenio;

class ConvenioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $convenios = Convenio::all();
        return view('convenios.index', compact('convenios'));
    }

    public function create(Request $request)
    {
        return view('convenios.create'); // Create a new view for the modal form
    }

    public function store(Request $request)
    {
        $convenio = new Convenio();
        $convenio->ans_conv = $request->input('ans_conv');
        $convenio->nome_conv = $request->input('nome_conv');
        $convenio->save();

        return redirect()->route('convenios.index')->with('success', 'Convênio cadastrado com sucesso!');
    }

    public function destroy($pk_id_conv)
    {
        $convenio = Convenio::find($pk_id_conv);
        $convenio->delete();
        return redirect()->route('convenios.index')->with('success', 'Convênio excluído com sucesso!');
    }

    public function edit($pk_id_conv)
    {
        $convenio = Convenio::find($pk_id_conv);
        return view('convenios.edit', compact('convenios'));
    }
    
    public function update(Request $request, $pk_id_conv)
    {
        $convenio = Convenio::find($pk_id_conv);
        $convenio->nome_conv = $request->input('nome_conv');
        $convenio->ans_conv = $request->input('ans_conv');
        $convenio->save();
        
        return redirect()->route('convenios.index');
    }

    public function atualizarStatus(Request $request, $id)
    {
        $convenio = Convenio::findOrFail($id);
        $convenio->status = $request->status;
        $convenio->save();

        return response()->json(['success' => true]);
    }

}

