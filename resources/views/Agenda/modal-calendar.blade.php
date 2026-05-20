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

        /* Deixa todos os labels em negrito */
        .form-label {
            font-weight: bold;
            /* Aplica negrito aos labels */
        }

        /* ARRUMAR O ESCURECIMENTO DO MODAL PRINCIPAL QUANDO O MODAL DE EXCLUSAO É ABERTOOOOO */
    </style>


    <!-- Modal para agendamento de eventos -->
    <div class="modal fade" id="modalCalendar" tabindex="-1" aria-labelledby="titleModal" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-md-down"> <!-- Diálogo do modal configurado para scroll e tamanho grande -->
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
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Excluir Agendamento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="fs-5 mb-1 text-dark">Tem certeza que deseja cancelar e excluir este agendamento?</p>
                    <p class="text-muted small mb-0">Esta ação é irreversível e o horário voltará a ficar disponível na agenda.</p>
                </div>
                <div class="modal-footer justify-content-center bg-light">
                    <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger px-4 fw-bold" id="confirmDeleteButton">Sim, Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Sucesso Dinâmico -->
    <div class="modal" id="dynamicSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4 border-0 shadow-lg">
                <div class="modal-body">
                    <div id="dynamicSuccessIcon" class="mb-3">
                        <!-- O ícone será injetado aqui -->
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-2" id="dynamicSuccessTitle">Sucesso!</h5>
                    <p class="text-muted mb-0" id="dynamicSuccessText"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSuccessModal(title, text, iconClass, iconColor) {
            $('#dynamicSuccessTitle').text(title);
            $('#dynamicSuccessText').text(text);
            $('#dynamicSuccessIcon').html(`<i class="${iconClass}" style="font-size: 3rem; color: ${iconColor};"></i>`);
            
            $('#dynamicSuccessModal').modal('show');

            setTimeout(function () {
                $('#dynamicSuccessModal').modal('hide');
            }, 1500); // Fecha após 1.5 segundos
        }
    </script>


    <script src="{{ asset('js/buscaPaciente.js') }}"></script> <!-- Script para manipulação das buscas de pacientes -->