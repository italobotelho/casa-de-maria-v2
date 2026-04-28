<?php

use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecadoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rotas auth
Auth::routes();

// Rotas Login
Route::get('/', [LoginController::class, 'index'])->name('auth.login');

//Rotas Agenda
Route::get('/home', [HomeController::class, 'index'])->name('agenda.home');

// Rotas Eventos Agenda
Route::get('/load-events', [EventController::class, 'loadEvents'])->name('routeLoadEvents');
Route::put('/event-update', [EventController::class, 'update'])->name('routeEventUpdate');
Route::post('/event-store', [EventController::class, 'store'])->name('routeEventStore');
Route::delete('/event-destroy', [EventController::class, 'destroy'])->name('routeEventDelete');
Route::get('/get-procedimentos', [EventController::class, 'getProcedimentos'])->name('getProcedimentos');
Route::get('/get-convenios', [EventController::class, 'getConvenios'])->name('getConvenios');
Route::get('/home', [EventController::class, 'index'])->name('agenda.home');
Route::get('/load-events-by-paciente', [EventController::class, 'loadEventsByPaciente'])->name('routeLoadEventsByPaciente');
Route::get('/home', [EventController::class, 'index'])->name('agenda.home');
Route::get('/get-medico/{id}', [MedicoController::class, 'getMedico']);
Route::get('/get-paciente/{id}', [PersonController::class, 'getPaciente']);
Route::get('/get-event/{id}', [EventController::class, 'show']);
Route::post('/event-update-color', [EventController::class, 'updateColor']);
Route::get('/get-event/{id}', [EventController::class, 'getEvent']);

// Rota Perfil
Route::get('/perfil', [UserController::class, 'index'])->name('perfil.index');
Route::post('/perfil/update-profile', [UserController::class, 'updateProfile'])->name('perfil.updateProfile');
Route::post('/perfil/update-password', [UserController::class, 'updatePassword'])->name('perfil.updatePassword');

// Rota para o profissional (medico)
Route::get('/profissional', [MedicoController::class, 'index'])->name('medicos.index');
Route::get('/medico/buscar', [MedicoController::class, 'buscarMedico'])->name('medico.buscar');
Route::get('/medico/buscar1', [MedicoController::class, 'buscar1'])->name('medico.buscar1');

// Rota para o formulário de cadastro de médico
Route::get('/form_medico', [MedicoController::class, 'index'])->name('medico.index');

// Rota para armazenar um novo médico
Route::post('/form_medico', [MedicoController::class, 'store'])->name('medico.store');

// Rota para o formulário de edição de médico
Route::get('/medicos', [MedicoController::class, 'edit'])->name('medico.edit');

// Rota para atualizar os dados de um médico
Route::post('/update-medico', [MedicoController::class, 'update'])->name('medico.update');

// Rota para listar convênios
Route::get('/convenio', [PersonController::class, 'ListarConvenio'])->name('convenio.listar');

//PACIENTES
Route::put('/form_paciente', [PersonController::class, 'update'])->name('paciente.update');
Route::post('/convenios', 'PersonController@ListarConvenio');
Route::get('/pacientes', [PersonController::class, 'index'])->name('pacientes.index');
Route::get('/paciente/{id}', [PersonController::class, 'show']);

// Rota para o formulário de cadastro de paciente
Route::get('/form_paciente', [PersonController::class, 'index'])->name('paciente.index');
// Rota para armazenar um novo paciente
Route::post('/form_paciente', [PersonController::class, 'store'])->name('paciente.store');
Route::get('/pacientes/buscar', [PersonController::class, 'buscar'])->name('pacientes.buscar');


// Rota para buscar convênio por paciente
Route::prefix('api')->group(function () {
    Route::get('/pacientes/{id}', [PersonController::class, 'getPaciente']);
});



// Rotas da Tela Configurações Clinica
Route::get('/clinica', [ClinicaController::class, 'index'])->name('clinica.index');
Route::post('/clinica', [ClinicaController::class, 'store'])->name('clinica.store');
Route::patch('/clinica', [ClinicaController::class, 'update'])->name('clinica.update');

// Rotas da Tela Configurações Procedimentos
Route::resource('procedimentos', ProcedimentoController::class);

Route::get('/procedimentos', [ProcedimentoController::class, 'index'])->name('procedimentos.index');

Route::post('/procedimentos', [ProcedimentoController::class, 'store'])->name('procedimentos.store');

Route::get('/procedimentos/edit', [ConvenioController::class, 'edit'])->name('procedimentos.edit');
Route::put('/procedimentos/{pk_cod_proc}', [ConvenioController::class, 'update'])->name('procedimentos.update');
Route::delete('/procedimentos/{pk_cod_proc}', [ProcedimentoController::class, 'destroy'])->name('procedimentos.destroy');

Route::patch('/procedimentos/{id}/atualizar-status', [ProcedimentoController::class, 'atualizarStatus']);

//Rotas da Tela Configurações Convênios
Route::resource('convenios', ConvenioController::class);

Route::get('/convenios', [ConvenioController::class, 'index'])->name('convenios.index');
Route::get('/convenios/create', [ConvenioController::class, 'create'])->name('convenios.create');
Route::post('/convenios', [ConvenioController::class, 'store'])->name('convenios.store');

Route::get('/convenios/edit', [ConvenioController::class, 'edit'])->name('convenios.edit');
Route::put('/convenios/{pk_id_conv}', [ConvenioController::class, 'update'])->name('convenios.update');
Route::delete('/convenios/{pk_id_conv}', [ConvenioController::class, 'destroy'])->name('convenios.destroy');

Route::patch('/convenios/{id}/atualizar-status', [ConvenioController::class, 'atualizarStatus']);

// routes/web.php
Route::get('/pacientes', [PersonController::class, 'buscarPacientes'])->name('buscar.pacientes');

Route::get('/form_paciente/{id}', [PersonController::class, 'edit'])->name('paciente.edit');


// Rota para o formulário de cadastro de paciente
Route::get('/form_paciente', function () {
    return view('pacientes/form_paciente');
})->middleware('auth'); // Middleware para garantir que o usuário esteja autenticado

// Rota para o formulário de cadastro de médico
Route::get('/form_medico', function () {
    return view('medicos/form_medico');
})->middleware('auth'); // Middleware para garantir que o usuário esteja autenticado

// Defina a rota agenda.home para o RecadoController@index
Route::get('/home', [RecadoController::class, 'index'])->name('agenda.home');
Route::post('/recados', [RecadoController::class, 'store'])->name('recados.store');
Route::delete('/recados/{id}', [RecadoController::class, 'destroy'])->name('recados.destroy');

