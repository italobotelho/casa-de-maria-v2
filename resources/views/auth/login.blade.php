<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Casa de Maria') }} - Login</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100" style="background: radial-gradient(circle at top left, #fff, #FDFBF7);">

    <div class="container fade-in-up">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="glass-panel rounded-5 p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo.png') }}" class="img-fluid mb-3" style="max-width: 180px;" alt="Casa de Maria">
                        <h2 class="fw-bold mb-1" style="color: #A47D53;">Bem-vindo de volta</h2>
                        <p style="color: #795127;">Acesse sua conta para continuar</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="form-floating mb-4">
                            <input id="email" type="email" class="form-control form-control-custom rounded-pill px-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail">
                            <label for="email" class="px-4" style="color: #795127;"><i class="bi bi-envelope me-2"></i>E-mail</label>
                            @error('email')
                            <span class="invalid-feedback px-4" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input id="password" type="password" class="form-control form-control-custom rounded-pill px-4 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Senha">
                            <label for="password" class="px-4" style="color: #795127;"><i class="bi bi-lock me-2"></i>Senha</label>
                            @error('password')
                                <span class="invalid-feedback px-4" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary-custom btn-lg rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-2"></i>ENTRAR
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>