@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pacientes-medicos.css') }}">
@endsection

@section('title')
@stop

@section('content')

<div class="d-flex gap-4">
    <div class="">
        <h1 class="display-5">BUSCAR PROFISSIONAL</h1>
    </div>
    
    <div class=" mt-4">
        <p class="display-8">Listagem dos últimos médicos cadastrados e busca geral.</p>
    </div>
</div>


    <div class="container border border-1 rounded shadow-sm mb-5">

        <div class="my-4 mx-1"><button class="btn novoCadastro" onclick="window.location.href='/form_medico'">CADASTRAR NOVO MÉDICO</button></div>  

        <div class="my-3 mx-1">
            
            <h2 class="text-uppercase fs-5 fw-medium">Filtros para Busca:</h2>
           <!-- Formulário de busca -->
            <form action="{{ route('medico.buscar1') }}" method="GET" class="form-inline mb-4 d-flex align-items-center">
                <!-- Campo de Nome -->
                <div class="input-group me-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i> <!-- Ícone de busca -->
                    </span>
                    <input type="text" name="nome_med" id="nome_med" class="form-control" placeholder="Nome do profissional" aria-label="Nome do profissional" aria-describedby="basic-addon1">
                </div>

                <!-- Campo de CRM -->
                <div class="input-group me-3">
                    <span class="input-group-text" id="basic-addon2">
                        <i class="bi bi-search"></i> <!-- Ícone de busca -->
                    </span>
                    <input type="text" name="pk_crm_med" id="pk_crm_med" class="form-control" placeholder="CRM do profissional" aria-label="CRM do profissional" aria-describedby="basic-addon2">
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
                                    <th scope="col">CRM</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">UF</th>
                                    <th scope="col">1 Especialidade</th>
                                    <th scope="col">2 Especialidade</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($medicos as $medico)
                                <tr>
                                    <th scope="row">{{ $medico->pk_crm_med }}</th>
                                    <td>{{ $medico->nome_med }}</td>
                                    <td>{{ $medico->telefone_med }}</td>
                                    <td>{{ $medico->email_med }}</td>
                                    <td>{{ $medico->uf_med }}</td>
                                    <td>{{ $medico->especialidade1_med }}</td>
                                    <td>{{ $medico->especialidade2_med }}</td>
                                    
                                    <td><button class="btn btn-warning btn-sm editar-medico" 
                                        data-id="{{ $medico->pk_crm_med }}" 
                                        data-nome="{{ $medico->nome_med }}"
                                        data-telefone="{{ $medico->telefone_med }}" 
                                        data-email="{{ $medico->email_med }}"
                                        data-uf="{{ $medico->uf_med }}"
                                        data-especialidade="{{ $medico->especialidade1_med }}" 
                                        data-especialidade2="{{ $medico->especialidade2_med }}" 
                                        >
                                    Editar
                                </button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center fs-4">
                                        Nenhum médico cadastrado
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{ $medicos->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div><!-- fim da col -->
        </div><!-- fim da row -->
    </div> <!-- fim do container -->


<!-- Modal para editar informações do médico -->
<div class="modal fade" id="editarMedicoModal" tabindex="-1" role="dialog" aria-labelledby="editarMedicoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="editarMedicoModalLabel">Editar Médico</h3>
            </div>
            <form action="{{ route('medico.update') }}" id="formEditarMedico">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <input type="hidden" id="editar-id" name="id">
                    
                    <div class="form-group mb-2"> <!-- Ajustado para margem menor -->
                        <label for="editar-nome" class="fw-semibold">Nome</label>
                        <input type="text" class="form-control" id="editar-nome" name="nome" required>
                    </div>
                    <div class="form-group mb-2"> <!-- Ajustado para margem menor -->
                        <label for="editar-telefone" class="fw-semibold">Telefone</label>
                        <input type="text" maxlength="15" class="form-control" id="editar-telefone" name="telefone" required>
                    </div>
                    <div class="form-group mb-2"> <!-- Ajustado para margem menor -->
                        <label for="editar-email" class="fw-semibold">Email</label>
                        <input type="email" class="form-control" id="editar-email" name="email" required>
                    </div>
                    <div class="form-group mb-2"> <!-- Ajustado para margem menor -->
                        <label for="editar-uf" class="fw-semibold">UF</label>
                        <input type="text" maxlength="2" class="form-control" id="editar-uf" name="uf" required>
                    </div>
                    <div class="form-group mb-2"> <!-- Ajustado para margem menor -->
                        <label for="editar-especialidade" class="fw-semibold">Especialidade</label>
                        <input type="text" class="form-control" id="editar-especialidade" name="especialidade" required>
                    </div>
                    <div class="form-group mb-2"> <!-- Ajustado para margem menor -->
                        <label for="editar-especialidade2" class="fw-semibold">2ª Especialidade</label>
                        <input type="text" class="form-control" id="editar-especialidade2" name="especialidade2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<script src="js/medico.js"></script>
<script>
    window.onload = function() {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
    // Usando delegação de eventos
    document.querySelector('.table tbody').addEventListener('click', function(e) {
        if (e.target.classList.contains('editar-medico')) {
            // Lógica para abrir o modal de edição
            const btn = e.target;
            const id = btn.dataset.id;
            const nome = btn.dataset.nome;
            const especialidade = btn.dataset.especialidade;
            const especialidade2 = btn.dataset.especialidade2;
            const telefone = btn.dataset.telefone;
            const email = btn.dataset.email;
            const uf = btn.dataset.uf;

            // Preencher o modal com as informações do médico
            document.getElementById('editar-id').value = id;
            document.getElementById('editar-nome').value = nome;
            document.getElementById('editar-especialidade').value = especialidade;
            document.getElementById('editar-especialidade2').value = especialidade2;
            document.getElementById('editar-telefone').value = telefone;
            document.getElementById('editar-email').value = email;
            document.getElementById('editar-uf').value = uf;

            // Exibir o modal
            $('#editarMedicoModal').modal('show');
            }
        });
    });

    document.getElementById('limparFiltroBtn').addEventListener('click', function() {
        // Limpar os campos de filtro
        document.getElementById('nome_med').value = '';
        document.getElementById('pk_crm_med').value = '';

        // Submeter o formulário sem parâmetros de filtro (mostrar todos os pacientes)
        document.getElementById('filtroForm').submit();
    });
</script>
@endsection