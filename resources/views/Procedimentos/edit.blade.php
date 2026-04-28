<!-- Edit Modal -->
<div class="modal fade" id="edit{{$procedimento->pk_cod_proc}}" tabindex="-1" aria-labelledby="procedimentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="procedimentoModalLabel">Edição de Procedimento</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('procedimentos.update', ['pk_cod_proc' => $procedimento->pk_cod_proc]) }}" method="post">
            @csrf
            @method('PUT')

            <label for="inputNomeProcedimento" class="form-label">Procedimento</label>
            <input type="text" class="form-control" id="nome_proc" name="nome_proc" value="{{ $procedimento->nome_proc }}" maxlength="20" required>

            <label for="inputDescricaoProcedimento" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao_proc" name="descricao_proc" value="{{ $procedimento->descricao_proc }}" maxlength="30" required>

            <input type="hidden" name="pk_cod_proc" value="{{ $procedimento->pk_cod_proc }}">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        </div>
      </div>
    </div>
  </div>