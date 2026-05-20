@extends('layouts.app')

@section('title', 'PROFISSIONAL')

@section('css')
<style>
    label {
      font-weight: bold;
      text-transform: uppercase;
    }
  </style>
@endsection

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <x-layout.page-header 
        title="{{ isset($medico) ? 'Editar Médico' : 'Cadastrar Médico' }}" 
        subtitle="Gerencie as informações detalhadas do profissional de saúde." 
        actionText="Voltar para a Lista" 
        actionUrl="/medicos" 
    />

    <form action="{{ isset($medico) ? route('medico.update', ['id' => $medico->pk_crm_med]) : route('medico.store') }}" method="POST">
        @csrf
        @if(isset($medico))
            @method('PUT')
        @endif

        <div class="d-flex flex-column flex-lg-row gap-4 mb-5">
            
            <!-- Sidebar do Perfil (Esquerda) -->
            <div class="glass-panel rounded-4 p-4 d-flex flex-column fade-in-up" style="flex: 1; align-self: flex-start; animation-delay: 0.1s;">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="profile-image-container mt-5 mb-2">
                        <h2 @if(!isset($medico)) style="visibility: hidden;" @endif>
                            {{ isset($medico) ? $medico->nome_med : 'Novo Médico' }}
                        </h2>
                        <!-- Avatar Padrão Moderno usando Bootstrap Icons via SVG ou IMG (usarei um ícone centralizado para não depender de img_med) -->
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light text-secondary" style="width: 150px; height: 150px; margin: 0 auto; font-size: 5rem; border: 4px solid rgba(164, 125, 83, 0.2);">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>

                    <div class="my-4 w-100">
                        @if(isset($medico))
                            <p>CRM: <span class="fw-bold text-end">{{ $medico->pk_crm_med }}</span></p>
                            <p>Celular: <span class="fw-bold text-end">{{ $medico->telefone_med }}</span></p>
                            <p>Especialidade: <span class="fw-bold text-end">{{ $medico->especialidade1_med }}</span></p>
                        @else
                            <p class="text-muted small">Preencha os dados ao lado para cadastrar este novo profissional no sistema.</p>
                        @endif
                    </div>

                    <!-- Botões de Ação -->
                    @if(!isset($medico))
                    <div class="d-flex justify-content-center mt-4 mb-2 w-100">
                        <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill w-100">Salvar novo médico</button>
                    </div>
                    @else
                    <div class="d-flex flex-column justify-content-center mt-4 mb-2 gap-2 w-100">
                        <button type="submit" name="action" value="save_and_exit" class="btn btn-primary-custom px-4 py-2 rounded-pill w-100">
                            Salvar e Sair
                        </button>
                        <button type="submit" name="action" value="save_and_stay" class="btn btn-outline-secondary px-4 py-2 rounded-pill w-100">
                            Salvar Dados
                        </button>
                    </div>
                    <div class="mt-3 text-center w-100">
                        <p class="small text-muted">Última alteração feita em:<br>
                            <span class="fw-bold">
                                @if($medico->updated_at)
                                    {{ \Carbon\Carbon::parse($medico->updated_at)->format('d/m/Y H:i') }}
                                @endif
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Formulário Principal (Direita) -->
            <div class="glass-panel rounded-4 p-4 fade-in-up" style="flex: 2; animation-delay: 0.2s;">
                
                <div class="row g-4 my-2">
                    <div class="col-12"><h2 class="fs-4 fw-bold text-secondary border-bottom pb-2">DADOS PESSOAIS</h2></div>

                    <x-form.input name="nome_med" label="Nome Completo" col="8" maxlength="50" required="true" :value="$medico->nome_med ?? ''" />
                    <x-form.input name="telefone_med" label="Telefone" col="4" maxlength="15" required="true" :value="$medico->telefone_med ?? ''" />
                    <x-form.input name="email_med" type="email" label="E-mail" col="9" maxlength="255" required="true" :value="$medico->email_med ?? ''" />
                    <x-form.input name="uf_med" label="UF" col="3" maxlength="2" required="true" :value="$medico->uf_med ?? ''" />
                </div>

                <div class="row g-4 my-4">
                    <div class="col-12"><h2 class="fs-4 fw-bold text-secondary border-bottom pb-2">DADOS PROFISSIONAIS</h2></div>   

                    <x-form.input name="pk_crm_med" label="CRM" col="4" maxlength="6" required="true" :value="$medico->pk_crm_med ?? ''" />
                    <x-form.input name="especialidade1_med" label="1ª Especialidade" col="4" maxlength="40" required="true" :value="$medico->especialidade1_med ?? ''" />
                    <x-form.input name="especialidade2_med" label="2ª Especialidade" col="4" maxlength="40" :value="$medico->especialidade2_med ?? ''" />
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="js/medico.js"></script>
@endsection