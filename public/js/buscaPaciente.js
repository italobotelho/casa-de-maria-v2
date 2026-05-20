(function() {
    "use strict";

    // Expondo globalmente apenas porque é chamado por atributos onclick/onkeyup no HTML
    window.buscarPacientes = function(query) {
        const sugestoesDiv = document.getElementById('pacienteSuggestions');

        if (query.length < 1) {
            sugestoesDiv.style.display = 'none';
            sugestoesDiv.innerHTML = '';
            return;
        }

        fetch(`/pacientes/buscar?query=${query}`)
            .then(response => response.json())
            .then(data => {
                sugestoesDiv.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(paciente => {
                        const dataNascimento = new Date(paciente.data_nasci_paci);
                        const dataFormatada = dataNascimento.toLocaleDateString('pt-BR');

                        const item = document.createElement('a');
                        item.className = 'list-group-item list-group-item-action';
                        item.href = '#';
                        item.textContent = `${paciente.nome_paci} - ${dataFormatada}`;
                        item.dataset.id = paciente.pk_cod_paci;

                        item.onclick = function (e) {
                            e.preventDefault();
                            document.getElementById('paciente').value = paciente.nome_paci;
                            document.getElementById('paciente_id').value = paciente.pk_cod_paci;
                            sugestoesDiv.style.display = 'none';
                            
                            window.preencherConvenio(paciente.pk_cod_paci).then(() => {
                                const convenioId = document.getElementById('convenio_id').value;
                                if (!convenioId) {
                                    console.warn("O valor do convênio está vazio.");
                                }
                            });
                        };
                        sugestoesDiv.appendChild(item);
                    });
                    sugestoesDiv.style.display = 'block';
                } else {
                    sugestoesDiv.innerHTML = '<div class="list-group-item">Paciente não cadastrado</div>';
                    sugestoesDiv.style.display = 'block';
                }
            })
            .catch(error => console.error('Erro ao buscar pacientes:', error));
    };

    window.buscarMedico = function(query) {
        const sugestoesDiv = document.getElementById('medicoSuggestions');

        if (query.length < 1) {
            sugestoesDiv.style.display = 'none';
            sugestoesDiv.innerHTML = '';
            return;
        }

        fetch(`/medico/buscar?query=${query}`)
            .then(response => response.json())
            .then(data => {
                sugestoesDiv.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(medico => {
                        const item = document.createElement('a');
                        item.className = 'list-group-item list-group-item-action';
                        item.href = '#';
                        item.textContent = medico.nome_med;
                        item.dataset.id = medico.pk_crm_med;

                        item.onclick = function (e) {
                            e.preventDefault();
                            document.getElementById('medico').value = medico.pk_crm_med;
                            document.getElementById('medico_nome').value = medico.nome_med;
                            sugestoesDiv.style.display = 'none';
                        };
                        sugestoesDiv.appendChild(item);
                    });
                    sugestoesDiv.style.display = 'block';
                } else {
                    sugestoesDiv.style.display = 'none';
                }
            })
            .catch(error => console.error('Erro ao buscar médico:', error));
    };

    window.preencherConvenio = function(pacienteId) {
        return fetch(`/api/pacientes/${pacienteId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.convenio) {
                    document.getElementById('convenio_id').value = data.convenio;
                } else {
                    console.error('A estrutura dos dados não contém o nome do convênio');
                }
            })
            .catch(error => {
                console.error('Erro ao preencher dados do paciente:', error);
            });
    };

    document.addEventListener('click', function(event) {
        const sugestoesDivPaciente = document.getElementById('pacienteSuggestions');
        const sugestoesDivMedico = document.getElementById('medicoSuggestions');

        if (sugestoesDivPaciente && !sugestoesDivPaciente.contains(event.target) && event.target.id !== 'paciente') {
            sugestoesDivPaciente.style.display = 'none';
        }

        if (sugestoesDivMedico && !sugestoesDivMedico.contains(event.target) && event.target.id !== 'medico') {
            sugestoesDivMedico.style.display = 'none';
        }
    });

})();
