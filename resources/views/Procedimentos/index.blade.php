<!-- resources/views/procedimentos/index.blade.php -->
@extends('layouts.app-navbar-configuracoes')

@section('title', 'CONFIGURAÇÕES')

@section('css')
<link rel="stylesheet" href="{{ asset('css/check-switch.css') }}">
@endsection

@section('sub-content')

@include('procedimentos.create')

<div class="container border">
    <div class="row justify-content-between my-3">
        <div class="col-md-6">
            <h2 class="my-3">PROCEDIMENTOS</h2>
            <p>Listagem com todos os procedimentos cadastrados na clínica.</p>
        </div>
        
        <div class="col-md-3 mx-3">
            <button type="button" class="btn btn-primary btn-lg my-3" data-bs-toggle="modal" data-bs-target="#ProcedimentoModal">
                Cadastrar Novo Procedimento
            </button>
        </div>
    </div>

    <!-- Abas para Ativos e Inativos -->
    <ul class="nav nav-tabs" id="procedimentoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ativos-tab" data-bs-toggle="tab" data-bs-target="#ativos" type="button" role="tab" aria-controls="ativos" aria-selected="true">Ativos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="inativos-tab" data-bs-toggle="tab" data-bs-target="#inativos" type="button" role="tab" aria-controls="inativos" aria-selected="false">Inativos</button>
        </li>
    </ul>

    <div class="tab-content" id="procedimentoTabContent">
        <!-- Aba de Procedimentos Ativos -->
        <div class="tab-pane fade show active" id="ativos" role="tabpanel" aria-labelledby="ativos-tab">
            <table class="table table-bordered table-responsive text-center">
                <thead>
                    <tr>
                        <th scope="col" width="35%">Nome</th>
                        <th scope="col" width="35%">Descrição</th>
                        <th scope="col" width="15%">Editar</th>
                        <th scope="col" width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procedimentos as $procedimento)
                    @if($procedimento->status == 'ativo')
                    <tr>
                        <td class="align-middle">{{ $procedimento->nome_proc }}</td>
                        <td class="align-middle">{{ $procedimento->descricao_proc }}</td>
                        <td class="align-middle">
                            <a href="#edit{{$procedimento->pk_cod_proc}}" data-bs-toggle="modal" class="btn btn-link">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <div class="form-check form-switch d-flex large-switch justify-content-center align-items-center my-1">
                                <input class="form-check-input status-switch" type="checkbox" role="switch" data-id="{{ $procedimento->pk_cod_proc }}"
                                @if($procedimento->status == 'ativo') checked @endif>
                            </div>
                            @include('procedimentos.edit')
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Aba de Procedimentos Inativos -->
        <div class="tab-pane fade" id="inativos" role="tabpanel" aria-labelledby="inativos-tab">
            <table class="table table-bordered table-responsive text-center">
                <thead>
                    <tr>
                        <th scope="col" width="35%">Nome</th>
                        <th scope="col" width="35%">Descrição</th>
                        <th scope="col" width="15%">Editar</th>
                        <th scope="col" width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procedimentos as $procedimento)
                    @if($procedimento->status == 'inativo')
                    <tr>
                        <td class="align-middle">{{ $procedimento->nome_proc }}</td>
                        <td class="align-middle">{{ $procedimento->descricao_proc }}</td>
                        <td class="align-middle">
                            <!-- O botão de edição será removido para procedimentos inativos -->
                            <span class="text-muted">Edição Desabilitada</span>
                        </td>
                        <td>
                            <div class="form-check form-switch d-flex large-switch justify-content-center align-items-center my-1">
                                <input class="form-check-input status-switch" type="checkbox" role="switch" data-id="{{ $procedimento->pk_cod_proc }}">
                            </div>
                        </td>
                        @include('procedimentos.edit')
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.status-switch').forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const procedimentoId = this.getAttribute('data-id');
            const status = this.checked ? 'ativo' : 'inativo';

            fetch(`/procedimentos/${procedimentoId}/atualizar-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Erro ao atualizar status:', error));
        });
    });
</script>
@endsection
