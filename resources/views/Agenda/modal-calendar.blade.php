    <style>
        /* Estilo para a lista de sugestões de pacientes */
        #pacienteSuggestions {
            max-height: 200px;
            /* Limita a altura máxima da lista */
            overflow-y: auto;
            /* Adiciona rolagem vertical se necessário */
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* Estilo para cada item da lista de sugestões */
        #pacienteSuggestions .list-group-item {
            cursor: pointer;
            /* Indica que o item é clicável */
        }

        .modal-backdrop {
            opacity: 0.5;
        }

        /* Deixa todos os labels em negrito */
        .form-label {
            font-weight: bold;
            /* Aplica negrito aos labels */
        }

        /* ARRUMAR O ESCURECIMENTO DO MODAL PRINCIPAL QUANDO O MODAL DE EXCLUSAO É ABERTOOOOO */
    </style>


    <!-- Modal para agendamento de eventos -->
    <div class="modal fade" id="modalCalendar" tabindex="-1" aria-labelledby="titleModal" >
        <div class="modal-dialog modal-dialog-scrollable modal-lg"> <!-- Diálogo do modal configurado para scroll e tamanho grande -->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 d-flex justify-content-center"> <!-- Centraliza o título -->
                        <h1 class="modal-title fs-5 text-primary" id="titleModal"></h1>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botão para fechar o modal -->
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="message"></div> <!-- Área para exibir mensagens (ex: erros ou confirmações) -->
                        <div id="successMessage" class="alert alert-success" style="display: none;"></div> <!-- Mensagem de sucesso -->


                        <form id="formEvent" class="row g-3"> <!-- Formulário com classe para estilo de grade -->
                            <input type="hidden" name="id" id="id"> <!-- Campo oculto para ID -->
                            <input type="hidden" name="color" id="color" value=""> <!-- Campo oculto para cor -->

                            <!-- Campo para paciente -->
                            <div class="col-12">
                                <label for="paciente" class="form-label">Paciente</label>
                                <input type="hidden" name="paciente_id" id="paciente_id" value="">
                                <input type="text" class="form-control" name="paciente" id="paciente" placeholder="Informe o nome" oninput="buscarPacientes(this.value)" autocomplete="off">
                                <div id="pacienteSuggestions" class="list-group" style="display: none; position: absolute; z-index: 1000;"></div> <!-- Sugestões para pacientes -->
                            </div>

                            <!-- Campo para médico -->
                            <div class="col-12">
                                <label for="medico" class="form-label">Profissional</label>
                                <input type="hidden" id="medico" name="medico" value="">
                                <input type="text" class="form-control" name="medico_nome" id="medico_nome" placeholder="Informe o medico" oninput="buscarMedico(this.value)" autocomplete="off">
                                <div id="medicoSuggestions" class="list-group" style="display: none; position: absolute; z-index: 1000;"></div> <!-- Sugestões para médicos -->
                            </div>

                            <!-- Campo para procedimento -->
                            <div class="col-12">
                                <label for="procedimento_id" class="form-label">Procedimento</label>
                                <select class="form-select" id="procedimento_id" name="procedimento_id" aria-label="Default select example">
                                    <option value="">Selecione um Procedimento</option>
                                    @isset($procedimentos)
                                        @foreach($procedimentos as $procedimento)
                                            <option value="{{ $procedimento->pk_cod_proc }}">{{ $procedimento->nome_proc }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>                            

                            <!-- Campo para data do evento -->
                            <input type="hidden" class="form-control" name="eventDate" id="eventDate">

                            <!-- Campos para hora inicial e final -->
                            <div class="col-12 d-flex align-items-end"> <!-- Flex container para alinhar os campos -->
                                <div class="me-2" style="flex: 2;"> <!-- Coluna para a hora inicial -->
                                    <label for="start" class="form-label">Hora Inicial</label>
                                    <input type="time" class="form-control" name="start" id="start">
                                </div>
                                <div style="flex: 2;"> <!-- Coluna para a hora final -->
                                    <label for="end" class="form-label">Hora Final</label>
                                    <input type="time" class="form-control" name="end" id="end">
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="convenio_id" class="form-label">Convênio</label>
                                <input type="text" class="form-control" name="convenio_id" id="convenio_id" readonly disabled>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> <!-- Botão para fechar o modal -->
                    <button type="button" class="btn btn-danger deleteEvent">Excluir</button> <!-- Botão para excluir o evento -->
                    <button type="button" class="btn btn-primary saveEvent">Cadastrar Horário</button> <!-- Botão para salvar o evento -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir este evento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Sucesso -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Consulta cadastrada com sucesso!</p> <!-- Mensagem de sucesso -->
                </div>
                <p id="successMessageContent"></p> <!-- Conteúdo da mensagem de sucesso -->
            </div>
        </div>
    </div>
    </div>

    <!-- Modal de Sucesso para Alteração -->
    <div class="modal fade" id="successAlterationModal" tabindex="-1" aria-labelledby="successAlterationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successAlterationModalLabel">Sucesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Alteração realizada!</p> <!-- Mensagem de sucesso -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Function to close modal after 2 seconds
    const successModal = document.getElementById('successModal');
    const successAlterationModal = document.getElementById('successAlterationModal');

    // Listen for modal showing event
    successModal.addEventListener('shown.bs.modal', function () {
        setTimeout(function () {
            $('#successModal').modal('hide'); // Close the modal
        }, 750); // 2000ms = 2 seconds
    });

    successAlterationModal.addEventListener('shown.bs.modal', function () {
        setTimeout(function () {
            $('#successAlterationModal').modal('hide'); // Close the modal
        }, 750); // 2000ms = 2 seconds
    });
</script>


    <script src="js/buscaPaciente.js"></script> <!-- Script para manipulação das buscas de pacientes -->



    
    </body>

    </html>