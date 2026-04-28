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

<div class="container border rounded shadow-sm">

    <form action="{{ route('medico.store') }}" method="POST">
        @csrf


        
        <div class="row g-3 my-2">
            <h1 class="fs-4">DADOS PESSOAIS</h1>

            <!-- Nome -->
            <div class="form-group col-md-4">
                <label for="nome_med">Nome:</label>
                <input  maxlength="50" type="text" class="form-control" id="nome_med" name="nome_med" value="{{ old('nome_med') }}" required>
            </div>

            <!-- Telefone -->
            <div class="form-group col-md-3">
                <label for="telefone_med">Telefone:</label>
                <input maxlength="15" type="text" class="form-control" id="telefone_med" name="telefone_med" value="{{ old('telefone_med') }}" required>
            </div>

            <!-- Email -->
            <div class="form-group col-md-4">
                <label for="email_med">Email:</label>
                <input maxlength="255"  type="email" class="form-control" id="email_med" name="email_med"
                    value="{{ old('email_med') }}" required>
            </div>

            <!-- UF -->
            <div class="form-group col-md-1">
                <label for="uf_med">UF:</label>
                <input maxlength="2"  type="text" class="form-control" id="uf_med" name="uf_med"
                    value="{{ old('uf_med') }}" required>
            </div>
        </div>

        <div class="row g-3 my-2">
            <h1 class="fs-4">DADOS PROFISSIONAIS</h1>   

            {{-- CRM --}}
            <div class="form-group col-md-4">
                <label for="pk_crm_med">CRM:</label>
                <input maxlength="6"  type="text" class="form-control" name="pk_crm_med" id="pk_crm_med" value="{{ old('pk_crm_med') }}" required>
            </div>

            <!-- ESPECIALIDADE -->
            <div class="form-group col-md-4">
                <label for="especialidade1_med">1° Especialidade:</label>
                <input maxlength="40"  type="text" class="form-control" id="especialidade1_med" name="especialidade1_med" value="{{ old('especialidade1_med') }}"
                    required>
            </div>

       
            <!-- ESPECIALIDADE 2 -->
            <div class="form-group col-md-4">
                <label for="especialidade2_med">2° Especialidade:</label>
                <input maxlength="40" type="text" class="form-control" name="especialidade2_med" id="especialidade2_med" value="{{ old('especialidade2_med') }}">
            </div>
        </div>
        <div class="d-flex justify-content-center my-3">
            <button type="submit" class="btn btn-primary">Cadastrar Médico</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="js/medico.js"></script>
@endsection