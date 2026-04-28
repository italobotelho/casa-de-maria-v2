{{-- modal buscar --}}
<div class="modal fade" id="searchPatientModal" tabindex="-1" aria-labelledby="searchPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="searchPatientModalLabel">Buscar Agendamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="patientName" class="form-label">Nome do Paciente</label>
                    <input type="text" class="form-control" id="patientName" placeholder="Digite o nome do paciente">
                </div>
                <button id="searchPatientButton" class="btn btn-primary">Buscar</button>
                <hr>
                <h5>Agendamentos</h5>
                <div id="appointmentsList">
                    <!-- A lista de agendamentos será preenchida aqui -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>