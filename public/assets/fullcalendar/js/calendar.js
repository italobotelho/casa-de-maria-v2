let currentEvent = null; // Variável global para armazenar o evento atual
var calendar;

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendarMonthEl = document.getElementById('calendarMonth');

    // Selecione todos os botões de navegação do FullCalendar
    const buttons = document.querySelectorAll('#calendar .fc-button-primary');

    buttons.forEach(function(button) {
      // Adiciona o evento de clique a cada botão
      button.addEventListener('click', function() {
        // Remove a classe "clicked" de todos os botões
        buttons.forEach(function(btn) {
          btn.classList.remove('clicked');
        });
        
        // Adiciona a classe "clicked" ao botão clicado
        button.classList.add('clicked');
      });
    });

    // Evento de criação do calendário principal
    calendar = new FullCalendar.Calendar(calendarEl, {
      themeSystem: 'bootstrap5', // Define o sistema de tema como Bootstrap 5 para estilização.
      initialView: 'timeGridDay', // Define a visualização inicial como "timeGridDay", que exibe os eventos em blocos de tempo durante o dia.
      dayMaxEventRows: true, // Permite que o calendário exiba múltiplas linhas de eventos por dia.
      views: { dayGrid: { dayMaxEventRows: 3 } }, // Limita a exibição de eventos a 3 linhas em visualizações do tipo "dayGrid".
      eventMaxStack: 3, // Limita o número de eventos empilhados verticalmente no mesmo horário a 3.
      headerToolbar: { // Configura a barra de ferramentas de cabeçalho do calendário.
        left: 'prev,next today', // Exibe botões para navegar para o mês anterior, próximo e para o "hoje".
        center: 'title', // Exibe o título do mês no centro da barra de ferramentas.
        right: 'timeGridDay,timeGridWeek,dayGridMonth,listWeek' // Exibe os botões para navegar entre as visualizações de dia, semana, mês e lista.
      },
      businessHours: { // Define os horários comerciais para os dias da semana (segunda a sexta-feira).
        daysOfWeek: [1, 2, 3, 4, 5], // Define que os horários comerciais vão de segunda a sexta-feira.
        startTime: '8:00', // Define o horário de início do horário comercial como 9:00.
        endTime: '18:00' // Define o horário de término do horário comercial como 18:00.
      },
      allDaySlot: false, // Desativa o slot de "Dia Inteiro".
      slotMinTime: '8:00', // Define o horário mínimo visível no calendário como 9:00.
      slotMaxTime: '18:00', // Define o horário máximo visível no calendário como 18:00.
      slotDuration: '00:30', // Define que cada slot de tempo no calendário terá duração de 30 minutos.
      slotLabelInterval: '00:30', // Define o intervalo de rótulos de slot como 30 minutos.
      slotLabelFormat: { // Define o formato de exibição dos rótulos de slot (hora:minuto).
        hour: '2-digit', minute: '2-digit', omitZeroMinute: false, meridiem: false
      },
      noEventsContent: 'Não há agendamentos para mostrar', // Exibe uma mensagem quando não há eventos no calendário.
      height: 'auto', // Ajusta automaticamente a altura do calendário com base no conteúdo.
      locale: 'pt-br', // Define o idioma do calendário como português do Brasil.
      navLinks: true, // Permite a navegação ao clicar nas datas do calendário.
      selectable: true, // Permite a seleção de datas clicando no calendário.
      editable: true, // Permite a edição de eventos.
      droppable: true, // Permite arrastar eventos dentro do calendário.

      // Adicionando o evento para sincronizar o mês
      datesSet: function(dateInfo) {
        // Atualiza o calendário mensal para o mesmo mês
        calendarMonth.gotoDate(dateInfo.start);
        updateVisibleEventCount();
      },

      // Sincroniza a navegação ao clicar em um dia no calendário principal
      dateClick: function(info) {
          calendarMonth.gotoDate(info.date); // Sincroniza a navegação ao clicar em um dia no calendário principal
      },

      selectAllow: function(selectInfo) {
        // Verifica se o dia selecionado é final de semana
        const day = selectInfo.start.getDay(); // 0 = Domingo, 6 = Sábado
        return day !== 0 && day !== 6; // Permite apenas de segunda a sexta
      },

      eventDrop: function(element) {
        let newStart = element.event.start; // Nova data de início
        let day = newStart.getDay(); // 0 = Domingo, 6 = Sábado
      
        // Verifica se é final de semana
        if (day === 0 || day === 6) {
          // Reverte a movimentação do evento
          element.revert();
      
          // Exibe uma mensagem de aviso
          alert('Não é permitido agendar para finais de semana.');
          return;
        }

        let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
        let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
        let procedimentoId = element.event.extendedProps.procedimento_id;
        let pacienteId = element.event.extendedProps.paciente_id;
        let medico = element.event.extendedProps.medico;
        let convenio = element.event.extendedProps.convenio;

        // Verifica se existe um item no dropdown que contém "Reagendado"
        let dropdownItem = $('.dropdown-item').filter(function() {
          return $(this).text().includes("Reagendado");
        });

        let newColor = element.event.backgroundColor; // Cor atual do evento

        // Se o item "Reagendado" foi encontrado, altera a cor
        if (dropdownItem.length > 0) {
          newColor = dropdownItem.data('color'); // Obtém a nova cor do item dropdown
          element.event.setProp('backgroundColor', newColor); // Atualiza a cor do evento no calendário
        }

        let newEvent = {
          _method: 'PUT',
          title: element.event.title,
          id: element.event.id,
          start: start,
          end: end,
          color: newColor,
          procedimento_id: procedimentoId,
          medico: medico,
          convenio: convenio,
          paciente_id: pacienteId
        };

        if (!medico || !procedimentoId || !convenio) {
          console.error('Um ou mais campos obrigatórios estão vazios.');
          return;
        }

        sendEvent(routeEvents('routeEventUpdate'), newEvent);
      },

      eventClick: function(element) {
        // Limpa mensagens e reseta o formulário
        clearMessages('#message');
        resetForm("#formEvent");

        currentEvent = element.event; // Armazena o evento clicado
        
        console.log('Evento clicado:', element.event); // Log para verificar se o evento foi capturado

        let eventoId = element.event.id; // ID do evento

        let pacienteId = element.event.extendedProps.paciente_id;

        let startDate = moment(element.event.start).format("DD/MM/YYYY");
        
        $("#modalCalendar #titleModal").html('Alteração de agendamento para <strong>' + startDate + '</strong>');

        $("#modalCalendar button.deleteEvent").css("display", "flex");

        // Preencher os campos iniciais do modal
        $("#modalCalendar input[name='id']").val(element.event.id);
        $("#modalCalendar input[name='paciente']").val(element.event.title);

        $("#modalCalendar input[name='paciente_id']").val(pacienteId);

        $("#modalCalendar input[name='medico']").val(element.event.extendedProps.medico);

        $("#modalCalendar input[name='medico_nome']").val();

        $("#modalCalendar input[name='convenio_id']").val(element.event.extendedProps.convenio || '');

        // Preenchendo o campo de procedimento
        $("#modalCalendar select[name='procedimento_id']").val(element.event.extendedProps.procedimento_id || '').change();

        // Preenchimento dos horários e data
        let startTime = moment(element.event.start).format("HH:mm"); // Horário de início
        $("#modalCalendar input[name='start']").val(startTime); // Preenche o campo de horário de início
        let endTime = moment(element.event.end).format("HH:mm"); // Horário de término
        $("#modalCalendar input[name='end']").val(endTime); // Preenche o campo de horário de término
        let eventDate = moment(element.event.start).format("YYYY-MM-DD"); // Data do evento
        $("#modalCalendar input[name='eventDate']").val(eventDate); // Preenche o campo de data do evento
        

      // Configuração básica do modal
      $("#modalViewCalendar #modalViewCalendarLabel").html('Visualizar agendamento <strong>' + startDate + '</strong>');

      // AJAX para obter informações do evento
      $.ajax({
        url: `/get-event/${eventoId}`, // URL para obter o evento
        type: 'GET',
        success: function(response) {
            console.log('Resposta do servidor:', response);
            $('#pacienteFoto').attr('src', '/storage/' + response.paciente.img_paci); // Corrigido para incluir o prefixo 'storage'
            $('#pacienteNome').text(response.title); // Preenche a hora final
            $('#pacienteDataNasci').text(moment(response.paciente.data_nasci_paci).format("DD/MM/YYYY")); // Preenche a hora final
            $('#pacienteCPF').text(response.paciente.cpf_paci); // Preenche a hora final
            $('#pacienteTelefone').text(response.paciente.telefone_paci); // Preenche a hora final
            $('#pacienteEmail').text(response.paciente.email_paci); // Preenche a hora final
            $('#pacienteConvenio').text(response.convenio); // Preenche a hora final
            $('#medicoNome').text(response.medico.nome_med); // Preenche o nome do médico
            $('#procedimento').text(response.procedimento.nome_proc); // Preenche a hora final
            $('#horaInicial').text(moment(response.start).format("HH:mm")); // Preenche a hora inicial
            $('#horaFinal').text(moment(response.end).format("HH:mm")); // Preenche a hora final

            $("#modalCalendar input[name='medico_nome']").val(response.medico.nome_med);

            // Atualiza o link de cadastro do paciente com o ID do paciente
            let cadastroUrl = `/form_paciente/${pacienteId}`;
            $('#cadastroPacienteLink').attr('href', cadastroUrl); // Atualiza o href do link

            $("#modalViewCalendar").modal('show');
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Erro ao buscar evento: ' + xhr.responseJSON.message);
            } else {
                alert('Erro ao buscar evento: ' + xhr.statusText);
            }
        }
      });
      },

      eventResize: function(element) {
        // Capturando os Dados do Evento Redimensionado
        let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
        let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
        let pacienteId = element.event.extendedProps.paciente_id;
        let procedimentoId = element.event.extendedProps.procedimento_id;
        let medico = element.event.extendedProps.medico;
        let convenio = element.event.extendedProps.convenio;

        // Verifica se existe um item no dropdown que contém "Reagendado"
        let dropdownItem = $('.dropdown-item').filter(function() {
          return $(this).text().includes("Reagendado");
        });

        let newColor = element.event.backgroundColor; // Cor atual do evento

        // Se o item "Reagendado" foi encontrado, altera a cor
        if (dropdownItem.length > 0) {
          newColor = dropdownItem.data('color'); // Obtém a nova cor do item dropdown
          element.event.setProp('backgroundColor', newColor); // Atualiza a cor do evento no calendário
        }

        let newEvent = {
          //  Preparando os Dados para Envio
          _method: 'PUT',
          title: element.event.title,
          id: element.event.id,
          start: start,
          end: end,
          color: newColor,
          procedimento_id: procedimentoId,
          medico: medico,
          convenio: convenio,
          paciente_id: pacienteId
        };

        if (!medico || !procedimentoId || !convenio) { //os campós medico, procediemento e convenio, tem que estar preenchedios
          console.error('Um ou mais campos obrigatórios estão vazios.');
          return;
        }

        sendEvent(routeEvents('routeEventUpdate'), newEvent);
      },
      

      select: function(element) {
        clearMessages('#message');
        resetForm("#formEvent");

        let startDate = moment(element.start).format("DD/MM/YYYY");
        $("#modalCalendar #titleModal").html('Novo agendamento para <strong>' + startDate + '</strong>');

        $("#modalCalendar").modal('show');
        $("#modalCalendar button.deleteEvent").css("display", "none");

        let startTime = moment(element.start).format("HH:mm");
        $("#modalCalendar input[name='start']").val(startTime);

        let endTime = moment(element.end).format("HH:mm");
        $("#modalCalendar input[name='end']").val(endTime);

        $("#modalCalendar input[name='eventDate']").val(moment(element.start).format("YYYY-MM-DD"));
        $("#modalCalendar input[name='color']").val("#9D9D9B");

        $("#modalCalendar input[name='medico']").val('');

        calendar.unselect();
      },

      // filtro do medico
      
      events: function(fetchInfo, successCallback, failureCallback) {
        var medico= document.getElementById('medicoSelect').value;

        $.ajax({
          url: routeEvents('routeLoadEvents'),
          method: 'GET',
          data: { medico: medico },
          success: function(data) {
            successCallback(data);
            updateVisibleEventCount();
          },
          error: function() {
            failureCallback();
          }
        });
      },
    });

    // Inicialização do calendário mensal
    var calendarMonth = new FullCalendar.Calendar(calendarMonthEl, {

      height: '100%',
      contentHeight: 'auto',

      initialView: 'dayGridMonth', // Visualização inicial do mês
  
      // Personalização da barra de navegação
      headerToolbar: {
        left: 'prev',    // Adiciona as setas de navegação (prev e next)
        center: 'title',  // Exibe apenas o título do mês
        right: 'next'  // Não adiciona nada no lado direito
      },

      businessHours: {
        daysOfWeek: [1, 2, 3, 4, 5], // Segunda - Sexta
      },

      locale: 'pt-br',
      fixedWeekCount: false,
      selectable: true,

      events: calendar.getEvents(), // Sincroniza eventos entre os dois calendários

      dateClick: function(info) {
        calendar.gotoDate(info.date); // Sincroniza a navegação com o calendário principal
      },

    });
    // Sincroniza a navegação ao clicar em um dia no calendário principal
    calendar.on('dateClick', function(info) {
    calendarMonth.gotoDate(info.date); // Sincroniza a navegação ao clicar em um dia no calendário principal
  });

  // Função para atualizar a contagem de eventos visíveis
  function updateVisibleEventCount() {
    const events = calendar.getEvents(); // Obtém todos os eventos do calendário principal
    const visibleEvents = events.filter(event => {
        // Verifica se o evento está dentro do intervalo visível (pode ser ajustado conforme necessário)
        return event.start >= calendar.view.currentStart && event.end <= calendar.view.currentEnd;
    });
    document.getElementById('visibleEventCount').innerText = visibleEvents.length; // Atualiza o texto com a contagem
  }

  // Renderiza ambos os calendários
  calendar.render();
  calendarMonth.render();

  document.getElementById('medicoSelect').addEventListener('change', function() {
  calendar.refetchEvents();

  });
});