{{-- resources/views/clinica/index.blade.php --}}
@extends('layouts.app-navbar-configuracoes')

@section('title', 'CONFIGURAÇÕES') <!-- Define o título específico -->

@section('sub-content')

<div class="border p-3 rounded-bottom">
  <div class="border p-2 my-2 rounded">
    <h2 class="mt-3 fs-4">DADOS DA CLÍNICA</h2>
    <form class="row g-3" method="POST" action="{{ route('clinica.store') }}" id="clinica">
      @csrf
      <div class="col-md-6">
        <label for="inputNome" class="form-label">NOME</label>
        <input type="text" class="form-control" id="nome_clin" name="nome_clin" value="{{ old('nome_clin', $clinica?->nome_clin) }}" required>
      </div>
      <div class="col-md-6">
        <label for="inputCNPJ" class="form-label">CNPJ</label>
        <input type="text" class="form-control" id="cnpj_clin" name="cnpj_clin" value="{{ old('cnpj_clin', $clinica?->cnpj_clin) }}" size="21" maxlength="21" required>
      </div>
      <div class="mb-3">
        <label for="FormControlDescricao" class="form-label">DESCRIÇÃO</label>
        <textarea class="form-control" id="descricao_clin" name="descricao_clin" rows="3" value="{{ old('descricao_clin', $clinica?->descricao_clin ?? '') }}">{{ $clinica?->descricao_clin ?? '' }}</textarea>
      </div>
      <div class="col-md-4">
        <label for="inputTelRecepcao" class="form-label">TELEFONE DA RECEPÇÃO</label>
        <input type="tel" class="form-control" id="telefone_clin" name="telefone_clin" value="{{ old('telefone_clin', $clinica?->telefone_clin) }}" maxlength="15" required>
      </div>
      <div class="col-md-4">
        <label for="inputEmailAtendimentoClinica" class="form-label">E-MAIL DE ATENDIMENTO DA CLÍNICA</label>
        <input type="email" class="form-control" id="email_aten_clin" name="email_aten_clin" value="{{ old('email_aten_clin', $clinica?->email_aten_clin) }}" required>
      </div>
      <div class="col-md-4">
        <label for="inputEmailResponsavelClinica" class="form-label">E-MAIL RESPONSÁVEL PELA CLÍNICA</label>
        <input type="email" class="form-control" id="email_resp_clin" name="email_resp_clin" value="{{ old('email_resp_clin', $clinica?->email_resp_clin) }}" required>
      </div>
  </div>

  <div class="border p-2 my-4 rounded">
    <div class="row g-2">
      <h2 class="fs-4">ENDEREÇO</h2>
      <div class="col-md-3">
        <label for="inputCEP" class="form-label">CEP</label>
        <input type="text" class="form-control" id="cep_clin" name="cep_clin" value="{{ old('cep_clin', $clinica?->cep_clin) }}" size="9" maxlength="8" onblur="pesquisacep(this.value);" oninput="this.value = formatCEP(this.value);">
      </div>
      <h5>*INFORME O CEP PARA O PREENCHIMENTO AUTOMÁTICO DOS DADOS</h5>
      <div class="col-md-6">
        <label for="inputLogradouro" class="form-label">LOGRADOURO</label>
        <input type="text" class="form-control" id="rua_clin" name="rua_clin" value="{{ old('rua_clin', $clinica?->rua_clin) }}" size="60" maxlength="60">
      </div>
      <div class="col-md-2">
        <label for="inputNumeroEstabelecimento" class="form-label">NÚMERO</label>
        <input type="number" class="form-control" id="numero_clin" name="numero_clin" value="{{ old('numero_clin', $clinica?->numero_clin) }}" size="10" maxlength="10">
      </div>
      <div class="col-md-4">
          <label for="inputCBairro" class="form-label">BAIRRO</label>
          <input type="text" class="form-control" id="bairro_clin" name="bairro_clin" value="{{ old('bairro_clin', $clinica?->bairro_clin) }}" size="40" maxlength="40">
      </div>
      <div class="col-md-4">
          <label for="inputComplemento" class="form-label">COMPLEMENTO</label>
          <input type="text" class="form-control" id="complemento_clin" name="complemento_clin" value="{{ old('complemento_clin', $clinica?->complemento_clin) }}" size="40" maxlength="40">
      </div>
      <div class="col-md-4">
          <label for="inputCidade" class="form-label">CIDADE</label>
          <input type="text" class="form-control" id="cidade_clin" name="cidade_clin" value="{{ old('cidade_clin', $clinica?->cidade_clin) }}" size="40" maxlength="40">
      </div>
      <div class="col-md-2">
          <label for="inputUF" class="form-label">UF (ESTADO)</label>
          <input type="text" class="form-control" id="uf_clin" name="uf_clin" value="{{ old('uf_clin', $clinica?->uf_clin) }}" size="2" maxlength="2">
      </div>
      <div class="col-md-2">
          <label for="inputCodIBGE" class="form-label">CÓD. IBGE</label>
          <input type="text" class="form-control" id="cod_ibge_clin" name="cod_ibge_clin" value="{{ old('cod_ibge_clin', $clinica?->cod_ibge_clin) }}" size="7" maxlength="7">
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end mx-1">
    <button type="reset" class="btn btn-secondary mx-1">Limpar</button>
    <button type="submit" class="btn btn-primary mx-1 flex-grow-1">Salvar</button>
  </div>

  </form>
</div> {{-- fim da container --}}
@endsection

@section('scripts')
<script src="{{ asset('js/validate-cnpj.js') }}"></script>
<script src="{{ asset('js/phone-format.js') }}"></script>
<script src="{{ asset('js/validate-email.js') }}"></script>
<script src="{{ asset('js/cep.js') }}"></script>
<script src="{{ asset('js/validate-cep.js') }}"></script>
@endsection