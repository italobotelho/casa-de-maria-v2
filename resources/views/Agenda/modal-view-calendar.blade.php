<style>
    .dot {
        height: 10px;
        /* Tamanho do ponto */
        width: 10px;
        /* Tamanho do ponto */
        border-radius: 50%;
        /* Faz o ponto ser redondo */
        display: inline-block;
        /* Para que o ponto fique ao lado do texto */
        margin-right: 8px;
        /* Espaçamento entre o ponto e o texto */
        vertical-align: middle;
        /* Alinha o ponto verticalmente ao centro do texto */
    }
  
    /* Define a cor padrão para o link */
    .custom-link {
        color: inherit; /* Herda a cor do botão */
        text-decoration: none; /* Remove o sublinhado */
    }

    /* Altera a cor do link no hover do botão */
    .btn-outline-primary.custom-btn-hover:hover .custom-link {
        color: white; /* Define a cor do link para branco */
    }

</style>

<div class="modal fade modal-lg" id="modalViewCalendar" aria-hidden="true" aria-labelledby="modalViewCalendarLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 d-flex justify-content-center">
                    <h1 class="modal-title fs-4 text-primary" id="modalViewCalendarLabel"></h1>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex gap-3">
                    <div class="d-flex gap-2 p-3 border rounded" style="flex-direction: column; align-items: center;">
                        <img id="pacienteFoto" class="rounded-circle" src="" alt="Foto do Paciente" style="width: 150px; height: 150px; object-fit: cover;">
                        <button class="btn btn-outline-primary custom-btn-hover mt-2">
                            <a class="custom-link link-offset-2 link-underline link-underline-opacity-0" id="cadastroPacienteLink" href="#">Cadastro paciente</a>
                        </button>  
                    </div>
                    
                    <div class="p-3 border rounded" style="flex: 1;">
                        <div>
                            <h1 class="text-primary fw-bold fs-4 mb-3" id="pacienteNome"></h1>
                        </div>
                        <table class="table table-stripped">
                            <tbody>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Data nasc. :</td>
                                    <td><span id="pacienteDataNasci"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">CPF:</td>
                                    <td><span id="pacienteCPF"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Contato:</td>
                                    <td><span id="pacienteTelefone"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">E-mail:</td>
                                    <td><span id="pacienteEmail"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Convênio:</td>
                                    <td><span id="pacienteConvenio"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Médico:</td>
                                    <td><span id="medicoNome"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Procedimento:</td>
                                    <td><span id="procedimento"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Hora Inicial:</td>
                                    <td><span id="horaInicial"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-body-tertiary fw-semibold text-end">Hora Final:</td>
                                    <td><span id="horaFinal"></span></td>
                                </tr>
                            </tbody>
                        </table>                           
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="dropup-center dropup">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Alterar Status
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" data-color="#85d17b"> <!-- Cor: Verde -->
                                <span class="dot" style="background-color: #85d17b;"></span> Finalizado
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-color="#9D9D9B"> <!-- Cor: Cinza -->
                                <span class="dot" style="background-color: #9D9D9B;"></span> Agendado
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-color="#8ea7e8"> <!-- Cor: Azul -->
                                <span class="dot" style="background-color: #8ea7e8;"></span> Confirmado
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-color="#f0b34a"> <!-- Cor: Laranja -->
                                <span class="dot" style="background-color: #f0b34a;"></span> Esperando
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-color="#f58493"> <!-- Cor: Rosa -->
                                <span class="dot" style="background-color: #f58493;"></span> Não Compareceu
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-color="#ff0000"> <!-- Cor: Vermelho -->
                                <span class="dot" style="background-color: #ff0000;"></span> Cancelado
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-color="#803c45"> <!-- Cor: Marrom -->
                                <span class="dot" style="background-color: #803c45"></span> Reagendado
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="btn btn-primary" data-bs-target="#modalCalendar" data-bs-toggle="modal">Editar Agendamento</button>
            </div>
        </div>
    </div>
</div>