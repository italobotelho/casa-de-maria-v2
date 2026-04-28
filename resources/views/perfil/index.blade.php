@extends('layouts.app')

@section('title', 'PERFIL DO USUÁRIO')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-between">
        <!-- Formulário para Informações do Perfil -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center">
                    <h5>Informações do Perfil</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center" style="min-height: 300px;"> <!-- Ajuste o min-height conforme necessário -->
                    <form action="{{ route('perfil.updateProfile') }}" method="POST">
                        @csrf
                
                        <div class="form-floating mb-3"> 
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            <label for="name">Nome</label>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            <label for="email">Email</label>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary mt-3">Atualizar Informações</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

        <!-- Formulário para Atualizar Senha -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center">
                    <h5>Atualizar Senha</h5>
                </div>
                <div class="card-body   ">
                    <form action="{{ route('perfil.updatePassword') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="current_password">Senha Atual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Senha atual" required>
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Nova Senha</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nova Senha" required>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirme a Nova Senha</label>
                            <input type="password" class="form-control" placeholder="Confirme a nova senha" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary mt-3">Atualizar Senha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
