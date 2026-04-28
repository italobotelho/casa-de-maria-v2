{{-- resources/views/convenios/index.blade.php --}}

@extends('layouts.app-navbar-configuracoes')

@section('title', 'CONFIGURAÇÕES')

@section('css')
<link rel="stylesheet" href="{{ asset('css/check-switch.css') }}">
@endsection

@section('sub-content')

@include('convenios.create') 

<div class="container border">
    <div class="row justify-content-between my-3">
        <div class="col-md-6">
            <h2 class="my-3">CONVÊNIOS</h2>
            <p>Listagem com todos os convênios cadastrados na clínica.</p>
        </div>
        
        <div class="col-md-3">
            <button type="button" class="btn btn-primary btn-lg my-3" data-bs-toggle="modal" data-bs-target="#ConvenioModal">
                Cadastrar Novo Convênio
            </button>
        </div>
    </div>

    <!-- Abas Ativos e Inativos -->
    <ul class="nav nav-tabs" id="convenioTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ativos-tab" data-bs-toggle="tab" data-bs-target="#ativos" type="button" role="tab" aria-controls="ativos" aria-selected="true">Ativos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="inativos-tab" data-bs-toggle="tab" data-bs-target="#inativos" type="button" role="tab" aria-controls="inativos" aria-selected="false">Inativos</button>
        </li>
    </ul>

    <div class="tab-content" id="convenioTabContent">
        <!-- Aba Ativos -->
        <div class="tab-pane fade show active" id="ativos" role="tabpanel" aria-labelledby="ativos-tab">
            <table class="table table-bordered table-responsive text-center">
                <thead>
                    <tr>
                        <th scope="col" width="35%">Nome</th>
                        <th scope="col" width="35%">Registro ANS</th>
                        <th scope="col" width="15%">Editar</th>
                        <th scope="col" width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($convenios as $convenio)
                        @if($convenio->status == 'ativo')
                        <tr>
                            <td class="align-middle">{{ $convenio->nome_conv }}</td>
                            <td class="align-middle">{{ $convenio->ans_conv }}</td>
                            <td class="align-middle">
                                <a href="#edit{{$convenio->pk_id_conv}}" data-bs-toggle="modal" class="btn btn-link">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                            <td>
                                <div class="form-check form-switch d-flex large-switch justify-content-center align-items-center my-1">
                                    <input class="form-check-input status-switch" type="checkbox" role="switch" data-id="{{ $convenio->pk_id_conv }}" 
                                    @if($convenio->pk_id_conv == 1) disabled @endif 
                                    @if($convenio->status == 'ativo') checked @endif>
                                </div>
                            </td>
                            @include('convenios.edit')
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Aba Inativos -->
        <div class="tab-pane fade" id="inativos" role="tabpanel" aria-labelledby="inativos-tab">
            <table class="table table-bordered table-responsive text-center">
                <thead>
                    <tr>
                        <th scope="col" width="35%">Nome</th>
                        <th scope="col" width="35%">Registro ANS</th>
                        <th scope="col" width="15%">Editar</th>
                        <th scope="col" width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($convenios as $convenio)
                        @if($convenio->status == 'inativo')
                        <tr>
                            <td class="align-middle">{{ $convenio->nome_conv }}</td>
                            <td class="align-middle">{{ $convenio->ans_conv }}</td>
                            <td class="align-middle">
                                <!-- O botão de edição será removido para procedimentos inativos -->
                                <span class="text-muted">Edição Desabilitada</span>
                            </td>
                            <td>
                                <div class="form-check form-switch d-flex large-switch justify-content-center align-items-center my-1">
                                    <input class="form-check-input status-switch" type="checkbox" role="switch" 
                                    data-id="{{ $convenio->pk_id_conv }}">
                                </div>
                            </td>
                            @include('convenios.edit')
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
<!-- Script para sincronizar o status -->
<script>
    document.querySelectorAll('.status-switch').forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const convenioId = this.getAttribute('data-id');
            const status = this.checked ? 'ativo' : 'inativo';

            fetch(`/convenios/${convenioId}/atualizar-status`, {
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