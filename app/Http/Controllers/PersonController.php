<?php

namespace App\Http\Controllers; // Define o namespace do controlador

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Convenio;
use App\Traits\UploadsImages;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    use UploadsImages;

    public function __construct()
    {
        $this->middleware('auth'); // Aplica middleware de autenticação para proteger as rotas
    }

    public function getPaciente($id)
    {
        $paciente = Paciente::with('convenio')->findOrFail($id); // Busca o paciente com o convênio associado

        return response()->json([
            'nome_paciente' => $paciente->nome_paci,
            'telefone_paciente' => $paciente->telefone_paci,
            'convenio' => $paciente->convenio ? $paciente->convenio->nome_conv : 'Nenhum convênio associado', // Acesse o nome do convênio

        ]); // Retorna o paciente em formato JSON
    }

    // Método para buscar pacientes com base em uma consulta
    public function buscar(Request $request)
    {
        $query = $request->input('query'); // Obtém a consulta do request
        $pacientes = Paciente::where('nome_paci', 'like', '%' . $query . '%') // Filtra pacientes pelo nome
            ->select('pk_cod_paci', 'nome_paci', 'data_nasci_paci') // Seleciona campos específicos
            ->get(); // Obtém os resultados
        return response()->json($pacientes); // Retorna os pacientes em formato JSON
    }

    public function index()
    {
        // Paginação de pacientes com 10 itens por página
        $pacientes = Paciente::with('convenio')->paginate(10); // Paginação de 10 pacientes por página
        $convenios = Convenio::all(); // Recupera todos os convênios
        return view('pacientes.index', ['pacientes' => $pacientes, 'convenios' => $convenios]); // Retorna a view com os dados
    }
    

    public function show($id)
    {
        // Tente encontrar o paciente pelo ID
        $paciente = Paciente::findOrFail($id);
    
        // Retorne os dados do paciente como JSON
        return response()->json($paciente);
    }

    public function store(\App\Http\Requests\StorePacienteRequest $request)
    {
    
        // Cria um novo paciente
        $paciente = new Paciente();
    
        $imageData = $this->uploadImage($request, 'img_paci', 'imagens_pacientes');
        $paciente->img_paci = $imageData['path'];
        $paciente->angulo_rotacao = $imageData['angulo_rotacao'];
    
        // Atribui os outros dados do request
        $paciente->nome_paci = $request->nome_paci;
        $paciente->data_nasci_paci = $request->data_nasci_paci;
        $paciente->telefone_paci = $request->telefone_paci;
        $paciente->email_paci = $request->email_paci;
        $paciente->fk_convenio_paci = $request->fk_convenio_paci;
        $paciente->data_obito_paci = $request->data_obito_paci;
        $paciente->cpf_paci = $request->cpf_paci;
        $paciente->genero = $request->genero;
    
        // Adicionando campos de endereço
        $paciente->cep_paci = $request->cep_paci;
        $paciente->rua_paci = $request->rua_paci;
        $paciente->numero_paci = $request->numero_paci;
        $paciente->bairro_paci = $request->bairro_paci;
        $paciente->cidade_paci = $request->cidade_paci;
        $paciente->complemento_paci = $request->complemento_paci;
        $paciente->uf_paci = $request->uf_paci;
    
        if ($age < 18) {
            $paciente->cpf_responsavel_paci = $request->cpf_responsavel_paci;
            $paciente->responsavel_paci = $request->responsavel_paci;
        }
    
        if ($request->input('fk_convenio_paci') == 1) {
            $paciente->carteira_convenio_paci = null;
        } else {
            $paciente->carteira_convenio_paci = $request->carteira_convenio_paci;
        }
    
        $paciente->save();
    
        return redirect()->route('paciente.store')->with('success', 'Paciente cadastrado com sucesso!');
    }
    

    public function update(\App\Http\Requests\UpdatePacienteRequest $request)
    {
        $paciente = Paciente::findOrFail($request->input('id')); // Busca segura do paciente
    
        if ($paciente) {
            // Verifica se uma nova imagem foi enviada
            if ($request->hasFile('img_paci')) {
                // Verifica se a imagem atual é diferente da padrão
                $defaultImage = 'imagens_pacientes/default-profile-pic.png';
                if ($paciente->img_paci !== $defaultImage && file_exists(storage_path('app/public/' . $paciente->img_paci))) {
                    unlink(storage_path('app/public/' . $paciente->img_paci)); // Remove a imagem antiga
                }
    
                $imageData = $this->uploadImage($request, 'img_paci', 'imagens_pacientes');
                $paciente->img_paci = $imageData['path'];
                $paciente->angulo_rotacao = $imageData['angulo_rotacao'];
            } else {
                $paciente->angulo_rotacao = $request->input('angulo_rotacao', $paciente->angulo_rotacao);
            }
    
            // Atualiza os demais campos do paciente
            $paciente->nome_paci = $request->input('nome_paci');
            $paciente->data_nasci_paci = $request->input('data_nasci_paci');
            $paciente->telefone_paci = $request->input('telefone_paci');
            $paciente->genero = $request->input('genero');
            $paciente->cpf_paci = $request->input('cpf_paci');
            $paciente->responsavel_paci = $request->input('responsavel_paci');
            $paciente->cpf_responsavel_paci = $request->input('cpf_responsavel_paci');
            $paciente->fk_convenio_paci = $request->input('fk_convenio_paci');
            $paciente->cep_paci = $request->input('cep_paci');
            $paciente->rua_paci = $request->input('rua_paci');
            $paciente->numero_paci = $request->input('numero_paci');
            $paciente->bairro_paci = $request->input('bairro_paci');
            $paciente->cidade_paci = $request->input('cidade_paci');
            $paciente->complemento_paci = $request->input('complemento_paci');
            $paciente->uf_paci = $request->input('uf_paci');
    
            $paciente->save();
    
            // Verifica qual botão foi pressionado
            if ($request->input('action') == 'save_and_exit') {
                return redirect('/pacientes')->with('success', 'Paciente atualizado com sucesso!');
            } else {
                return redirect()->route('paciente.edit', ['id' => $paciente->pk_cod_paci])->with('success', 'Paciente atualizado com sucesso!');
            }
        }
    
        return redirect()->back()->withErrors('Falha na atualização.');
    }
    


    public function buscarPacientes(Request $request)
    {   
        $nome = $request->input('nome_paci');
        $dataNascimento = $request->input('data_nasc_paci');
    
        // Verifica se algum filtro foi aplicado
        $query = Paciente::query();
    
        if ($nome || $dataNascimento) {
            // Se houver filtro, aplica o filtro de nome e/ou data de nascimento
            $query->where(function($q) use ($nome, $dataNascimento) {
                if ($nome) {
                    $q->where('nome_paci', 'like', '%' . $nome . '%');
                }
    
                if ($dataNascimento) {
                    $q->whereDate('data_nasci_paci', $dataNascimento);
                }
            });
        }
    
        // Caso contrário, retorna todos os pacientes com paginação
        $pacientes = $query->paginate(10); // Adiciona paginação
        $convenios = Convenio::all(); // Recupera todos os convênios
    
        // Retorna a view com todos os pacientes ou com os pacientes filtrados
        return view('pacientes.index', compact('pacientes', 'convenios'));
    }
    
    
    
    public function ListarConvenio() // Nome do método corrigido
    {
        $convenios = Convenio::all(); // Recupera todos os convênios
        return response()->json($convenios); // Retorna os convênios em formato JSON
    }

    // Método para obter um convênio específico pelo ID 
    public function convenios($id)
    {
        $convenio = Convenio::findOrFail($id); // Busca o convênio de forma segura
        return response()->json($convenio); // Retorna o convênio em formato JSON
    }

    public function edit($id)
    {
        // Encontre o paciente pelo ID
        $paciente = Paciente::findOrFail($id);
        
        // Busque todos os convênios disponíveis, garantindo que sejam únicos
        $convenios = Convenio::distinct()->get(); // Usando distinct para garantir registros únicos
        
        // Retorne a view com o paciente e os convênios
        return view('pacientes.form_paciente', compact('paciente', 'convenios'));
    }

}
