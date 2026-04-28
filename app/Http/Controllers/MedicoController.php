<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;


class MedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMedico($id)
    {
  
        $medico = Medico::find($id);
    
        if (!$medico) {
            return response()->json(['message' => 'Médico não encontrado'], 404);
        }
        return response()->json([
            'nome_medico' => $medico->nome_med, // Corrigido para usar 'nome_med'
        ]);
    }
    
    public function buscar1(Request $request)
    {
        $nome = $request->input('nome_med');
        $crm = $request->input('pk_crm_med');
    
        $medico = Medico::query();
    
        if ($nome) {
            $medico->where('nome_med', 'like', '%' . $nome . '%');
        }
    
        if ($crm) {
            $medico->orWhere('pk_crm_med', 'like', '%' . $crm . '%');
        }
    
        // Alterado para utilizar a paginação com 10 médicos por página
        $medico = $medico->select('pk_crm_med', 'nome_med', 'especialidade1_med', 'especialidade2_med', 'telefone_med', 'email_med')
                         ->paginate(10); // Paginação de 10 registros por página
    
        return view('medicos.index', ['medicos' => $medico]); // Passa os médicos paginados para a view
    }
    

    public function buscarMedico(Request $request)
    {
        $query = $request->input('query');
        
        // Certifique-se de que a consulta não esteja vazia
        if (empty($query)) {
            return response()->json([]); // Retorna um array vazio se a consulta estiver vazia
        }
    
        // Tente buscar médicos
        try {
            $medicos = Medico::where('nome_med', 'LIKE', "%{$query}%")->get();
            return response()->json($medicos);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Erro ao buscar médicos.'], 500);
        }
    }
    
    
    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:medicos,pk_crm_med',
            'nome' => 'required|string|max:255',
            'especialidade' => 'required|string|max:255',
            'especialidade2' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'uf' => 'string|max:2',
        ]);
    
        // Atualize o médico
        $medico = Medico::find($request->id);
        $medico->nome_med = $request->nome;
        $medico->especialidade1_med = $request->especialidade;
        $medico->especialidade2_med = $request->especialidade2;
        $medico->telefone_med = $request->telefone;
        $medico->email_med = $request->email;
        $medico->uf_med = $request->uf;
        $medico->save();
    
        return response()->json(['success' => true, 'message' => 'Médico atualizado com sucesso!']);
    }

    public function index()
    {
        $medicos = Medico::paginate(10); // Paginação de 10 registros por página
        return view('medicos.index', compact('medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_med' => 'required|string|max:54',
            'telefone_med' => 'required|string|max:15',
            'uf_med' => 'required|string|max:2',
            'email_med' => 'required|email',
            'especialidade1_med' => 'required|string|max:40',
            'especialidade2_med' => 'nullable|string|max:40',
            'pk_crm_med' => 'required|integer'
        ], [
            'nome_med.required' => 'O campo nome é obrigatório',
            'telefone_med.required' => 'O campo telefone é obrigatório',
            'uf_med.required' => 'O campo UF é obrigatório',
            'email_med.required' => 'O campo email é obrigatório',
            'especialidade1_med.required' => 'O campo 1° especialidade é obrigatório',
            'pk_crm_med.required' => 'O campo CRM é obrigatório'
        ]);

        $medico = new Medico();
        $medico->nome_med = $request->nome_med;
        $medico->telefone_med = $request->telefone_med;
        $medico->uf_med = $request->uf_med;
        $medico->email_med=$request->email_med;
        $medico->especialidade1_med=$request->especialidade1_med;
        $medico->especialidade2_med=$request->especialidade2_med;
        $medico->pk_crm_med=$request->pk_crm_med;

        $medico->save();

        return redirect()->route('medico.store')->with('success', 'Medico cadastrado com sucesso!');
    }
}
