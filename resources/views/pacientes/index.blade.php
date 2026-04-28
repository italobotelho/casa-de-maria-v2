@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pacientes-medicos.css') }}">
<style>
    #convenio-suggestions {
        position: absolute;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 10px;
        width: 200px;
        z-index: 1000;
    }

    #convenio-suggestions li {
        padding: 5px;
        cursor: pointer;
    }

    #convenio-suggestions li:hover {
        background-color: #ccc;
    }
</style>
@endsection

@section('title')
@stop

@section('content')
    
    <div class="container">
        <div class="d-flex gap-4">
            <div>
                <h1 class="display-5">BUSCAR PACIENTE</h1>
            </div>
            
            <div class="mt-4">
                <p class="display-8">Listagem dos últimos pacientes cadastrados e busca geral.</p>
            </div>
        </div>
        
        
        <div class="container border border-1 rounded shadow-sm mb-5">
        
            <div class="my-4 mx-1"><button class="btn novoCadastro" onclick="window.location.href='/form_paciente'">CADASTRAR NOVO PACIENTE</button></div>
        
            <div class="my-3 mx-1">
                <h2 class="text-uppercase fs-5 fw-medium">Filtros para Busca:</h2>
            
                <!-- Formulário de busca -->
                <form action="{{ url('/pacientes') }}" method="GET" class="form-inline mb-4 d-flex align-items-center">
                    <!-- Input group para o campo de busca por nome -->
                    <div class="input-group me-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-search"></i> <!-- Ícone de busca -->
                        </span>
                        <input type="text" name="nome_paci" id="nome_paci" class="form-control" placeholder="Nome do paciente" aria-label="Nome do paciente" aria-describedby="basic-addon1">
                    </div>

                    <!-- Input group para o campo de busca por data de nascimento -->
                    <div class="input-group me-3">
                        <span class="input-group-text" id="basic-addon2">
                            <i class="bi bi-calendar"></i> <!-- Ícone de data -->
                        </span>
                        <input type="date" name="data_nasc_paci" id="data_nasc_paci" class="form-control" aria-label="Data de nascimento" aria-describedby="basic-addon2">
                    </div>
                    <div class="d-flex gap-2">
                        <!-- Botão de busca geral -->
                        <div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>

                            <!-- Botão de limpar filtro -->
                        <div>
                            <button type="button" class="btn btn-secondary" id="limparFiltroBtn">Limpar</button>
                        </div>
                    </div>
                    
                </form>



            </div>            
        
            <div class="my-3 mx-1"><h3 class="text-uppercase fs-5 fw-medium">Resultados:</h3></div>

                        <table class="table border table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data Nascimento</th>
                                    <th scope="col">Convênio</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Cidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pacientes as $paciente)
                                <tr onclick="window.location.href='/form_paciente/{{ $paciente->pk_cod_paci }}'">
                                    <th scope="row">{{ $paciente->pk_cod_paci }}</th>
                                    <td> {{ $paciente->nome_paci }}</td>
                                    <td>{{ \Carbon\Carbon::parse($paciente->data_nasci_paci)->format('d/m/Y') }}</td>
                                    <td>{{ $paciente->convenio->nome_conv }}</td>
                                    <td>{{ $paciente->telefone_paci }}</td>
                                    <td>{{ $paciente->cpf_paci }}</td>
                                    <td>{{ $paciente->cidade_paci}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center fs-4">
                                        Nenhum paciente cadastrado
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{ $pacientes->links('pagination::bootstrap-5') }}  <!-- Este método gera os links de navegação -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
@endsection

@section('scripts')
<!-- Por fim, carregue seu script personalizado -->
<script src="js/paciente.js"></script>

<script>
    window.onload = function() {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }

    document.getElementById('limparFiltroBtn').addEventListener('click', function() {
        // Limpar os campos de filtro
        document.getElementById('nome_paci').value = '';
        document.getElementById('data_nasc_paci').value = '';

        // Submeter o formulário sem parâmetros de filtro (mostrar todos os pacientes)
        document.getElementById('filtroForm').submit();
    });
</script>
@endsection
