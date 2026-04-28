<!-- Modal -->
<div class="modal fade" id="ConvenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="convenioModalLabel">Cadastro de Convênio</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('convenios.store')}}" method="post">
            @csrf
            <label for="inputConvenio" class="form-label">Convênio</label>
            <input type="text" class="form-control" id="nome_conv" name="nome_conv" maxlength="55" required>

            <label for="inputNome" class="form-label">Registro ANS</label>
        <input type="text" class="form-control" id="ans_conv" name="ans_conv" maxlength="6" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        </div>
      </div>
    </div>
  </div>