<?php

namespace App\Http\Controllers; // Define o namespace do controlador

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Convenio;

class PersonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // Aplica middleware de autenticação para proteger as rotas
    }

    public function getPaciente($id)
    {
        $paciente = Paciente::with('convenio')->find($id); // Busca o paciente com o convênio associado
        if (!$paciente) {
            return response()->json(['message' => 'Paciente não encontrado'], 404);
        }
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
        $paciente = Paciente::find($id);
        
        // Verifique se o paciente foi encontrado
        if (!$paciente) {
            return response()->json(['message' => 'Paciente não encontrado'], 404);
        }
    
        // Retorne os dados do paciente como JSON
        return response()->json($paciente);
    }

    public function store(Request $request)
    {
        // Calcula a idade com base na data de nascimento fornecida
        $birthDate = new \DateTime($request->input('data_nasci_paci'));
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y; // Calcula a idade
    
        // Regras de validação básicas
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
    
        if ($age < 18) {
            $rules['cpf_responsavel_paci'] = 'required|string|max:14';
            $rules['responsavel_paci'] = 'required|string|max:54';
        }
    
        // Aplica a validação
        $request->validate($rules);
    
        // Cria um novo paciente
        $paciente = new Paciente();
    
        if ($request->hasFile('img_paci')) {
            $imagem = $request->file('img_paci');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $path = $imagem->storeAs('public/imagens_pacientes', $nomeImagem);
    
            $paciente->img_paci = 'imagens_pacientes/' . $nomeImagem;

            // Salvar o ângulo de rotação da imagem
            $paciente->angulo_rotacao = $request->input('angulo_rotacao', 0);
        } else {
            $paciente->img_paci = 'imagens_pacientes/default-profile-pic.png';  // Imagem padrão
            $paciente->angulo_rotacao = 0;  // Sem rotação
        }
    
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
    

    public function update(Request $request)
    {
        $data = $request->all();
    
        // Validação
        $request->validate([
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
        ]);
    
        $paciente = Paciente::find($request->input('id')); // Busca o paciente pelo ID
    
        if ($paciente) {
            // Verifica se uma nova imagem foi enviada
            if ($request->hasFile('img_paci')) {
                // Verifica se a imagem atual é diferente da padrão
                $defaultImage = 'imagens_pacientes/default-profile-pic.png';
                if ($paciente->img_paci !== $defaultImage && file_exists(storage_path('app/public/' . $paciente->img_paci))) {
                    unlink(storage_path('app/public/' . $paciente->img_paci)); // Remove a imagem antiga
                }
    
                // Armazena a nova imagem
                $imagem = $request->file('img_paci');
                $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
                $path = $imagem->storeAs('public/imagens_pacientes', $nomeImagem);
    
                // Atualiza o caminho da imagem no banco de dados
                $paciente->img_paci = 'imagens_pacientes/' . $nomeImagem;
            }
    
            // Atualiza o ângulo de rotação da imagem
            $paciente->angulo_rotacao = $request->input('angulo_rotacao', 0);
    
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
    
        return redirect()->back()->withErrors('Paciente não encontrado.');
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
        $convenio = Convenio::find($id); // Busca o convênio pelo ID
        if (!$convenio) {
            return response()->json(['message' => 'Convenio não encontrado'], 404); // Retorna erro se não encontrado
        }
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
