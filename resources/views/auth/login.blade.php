<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Casa de Maria') }}</title>

    <!-- Link para o arquivo CSS de estilos personalizados da página de login -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css')}}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row rounded-5 p-3 shadow box-area" style="background-color:#E5D5C0;">

            <!--------------------------- Left Box ----------------------------->

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #c99c6580;">
                <div class="featured-image mb-3">
                    <img src="img/logo.png" class="img-fluid" style="width: 250px;">
                </div>
            </div> 

            <!-------------------- ------ Right Box ---------------------------->
            
            <div class="col-md-6 right-box d-flex align-items-center">
                <div class="card-body text-black">
                    <div class="header-text d-flex justify-content-center mb-3 pb-1">
                        <h1 style="color: #795127;">SEU LOGIN</h1>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-outline mb-4 d-grid gap-2 col-10 mx-auto">
                            <input id="email" type="email" class="form-control form-control-lg rounded-pill shadow-sm border border-0 @error('email') is-invalid @enderror" style="background-color: rgb(255, 255, 255, 0.5);" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-MAIL">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-outline mb-4 d-grid gap-2 col-10 mx-auto">
                            <input id="password" type="password" class="form-control form-control-lg rounded-pill shadow-sm border border-0 @error('password') is-invalid @enderror" style="background-color: rgb(255, 255, 255, 0.5);" name="password" required autocomplete="current-password" placeholder="SENHA">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-outline mb-4 d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-lg rounded-pill shadow-sm" style="background-color: rgb(138, 99, 58); color: white;">
                                {{ __('ENTRAR') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>