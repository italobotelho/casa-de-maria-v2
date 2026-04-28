<!-- Edit Modal -->
<div class="modal fade" id="edit{{$convenio->pk_id_conv}}" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="convenioModalLabel">Edição de Convênio</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('convenios.update', ['pk_id_conv' => $convenio->pk_id_conv]) }}" method="post">
            @csrf
            @method('PUT')

            <label for="inputNomeConvenio" class="form-label">Convênio</label>
            <input type="text" class="form-control" id="nome_conv" name="nome_conv" value="{{ $convenio->nome_conv }}" maxlength="55" required>

            <label for="inputANSConvenio" class="form-label">Registro ANS</label>
            <input type="text" class="form-control" id="ans_conv" name="ans_conv" value="{{ $convenio->ans_conv }}" maxlength="6" required>

            <input type="hidden" name="pk_id_conv" value="{{ $convenio->pk_id_conv }}">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        </div>
      </div>
    </div>
  </div>