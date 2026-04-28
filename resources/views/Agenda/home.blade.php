
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/fullcalendar/css/calendar.css') }}">
@endsection

@section('title')
@stop

@section('content')
<div class="container">
    @include('agenda.modal-calendar')
    @include('agenda.modal-view-calendar')
    @include('agenda.modal-buscar')

    <div class="row justify-content-between my-3">
        <div class="col-md-6">
            <h1 class="display-4">AGENDA</h1> <!-- Exibindo o título diretamente -->
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="medicoSelect">Selecione o profissinal</label>
                <select id="medicoSelect" class="form-select custom-select" aria-label="Default select example">    
                    <option value="">Todos os profissionais</option>
                    @foreach ($medicos as $medico)
                        <option value="{{ $medico->pk_crm_med }}">{{ $medico->nome_med }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div id='wrap'>
        <div style="flex: 4;">
            <!-- Calendário principal com visualização de horários -->
            <div id='calendar'
                data-route-load-events="{{ route('routeLoadEvents') }}"
                data-route-event-update="{{ route('routeEventUpdate') }}"
                data-route-event-store="{{ route('routeEventStore') }}"
                data-route-event-delete="{{ route('routeEventDelete') }}">
            </div>
        </div>
        <div style="flex: 1;">
            <div class="d-flex justify-content-center align-items-center border rounded-4 pt-2">
                <p id="eventCount"><span id="visibleEventCount">0</span> agendamento(s)</p>
            </div>
            
            <div class="my-4" id="calendarMonth"></div>
            <div class="d-grid my-3">
                <!-- Bloco de recados salvos -->
                <div class="recados-salvos border rounded p-3 mb-4">
                    <h5>Recados</h5>
                    <!-- Checkbox para mostrar recados excluídos -->
                    <form method="GET" action="{{ route('agenda.home') }}" class="mb-3">
                        <input type="checkbox" class="form-check-input" id="mostrarExcluidos" name="mostrarExcluidos" 
                               onchange="this.form.submit()" {{ $mostrarExcluidos ? 'checked' : '' }}>
                        <label for="mostrarExcluidos">Mostrar recados excluídos</label>
                    </form>
                    <ul class="list-group">
                        @foreach($recados as $recado)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $recado->texto }}
                                    <small class="text-muted d-block my-1">Enviado em: {{ $recado->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <!-- Condição para exibir o botão de deletar apenas quando não estiver mostrando recados excluídos -->
                                @if(!$mostrarExcluidos)
                                    <form action="{{ route('recados.destroy', $recado->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                
                    <!-- Paginação -->
                    <div class="d-flex justify-content-center">
                        {{ $recados->links('pagination::bootstrap-5') }}
                    </div>
                
                    <!-- Área para adicionar novo recado -->
                    @if(!$mostrarExcluidos)
                        <form action="{{ route('recados.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="texto" id="novo_recado" rows="2" class="form-control mt-1" placeholder="Digite seu recado aqui..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Salvar Recado</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>     
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script src="{{ asset('assets/fullcalendar/packages/core/locales/pt-br.global.js') }}"></script>

{{-- cdn jquery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- cdn moments --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>


<script src="{{ asset('assets/fullcalendar/js/calendar.js') }}"></script>
<script src="{{ asset('assets/fullcalendar/js/script.js') }}"></script>

@endsection