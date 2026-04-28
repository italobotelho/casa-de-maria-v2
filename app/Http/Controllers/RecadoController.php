<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recado;
use App\Models\Procedimento;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Event;

class RecadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        // Verifica se o usuário quer visualizar recados excluídos
        $mostrarExcluidos = $request->query('mostrarExcluidos', false);
        
        // Ajusta a consulta para buscar os recados com base na flag de exclusão
        if ($mostrarExcluidos) {
            $recados = Recado::onlyTrashed()->paginate(5); // Recados excluídos
        } else {
            $recados = Recado::paginate(3); // Recados não excluídos
        }
    
        $procedimentos = Procedimento::where('status', 'ativo')->get();
        $medicos = Medico::all();
        $pacientes = Paciente::all();

         // Exemplo de filtro de paciente com base no id passado como parâmetro na URL
        $pacienteId = $request->query('paciente_id');

        if ($pacienteId) {
            // Filtro de eventos relacionados ao paciente específico
            $events = Event::where('paciente_id', $pacienteId)->get();  
        } else {
            // Caso não haja filtro, retorna todos os eventos
            $events = Event::all();
        }
    
        return view('agenda.home', compact('recados', 'procedimentos', 'medicos', 'pacientes', 'events', 'mostrarExcluidos'));
    }

    public function showPacienteEventos($pacienteId)
    {
        $events = Event::where('paciente_id', $pacienteId)->get();
        return view('agenda.home', compact('events'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'texto' => 'required|string|max:200',
        ]);

        $recado = new Recado;
        $recado->texto = $request->input('texto');
        $recado->deleted_at = $request->has('somente_dia') ? now()->addDay() : null;
        $recado->save();

        return redirect()->route('agenda.home');
    }

    public function destroy($id)
    {
        $recado = Recado::findOrFail($id);
        $recado->delete();

        return redirect()->route('agenda.home');
    }
}
