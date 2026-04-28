<!-- resources/views/partials/navbar-configuracoes.blade.php -->

<nav class="navbar navbar-expand-lg navbar-light bg-light border rounded-top ">
    <div class="container">
        <ul class="navbar-nav d-flex justify-content-around w-100">
            <li class="nav-item {{ Request::is('clinica*') ? 'active' : '' }}">
                <a class="nav-link nav-link-config {{ Request::is('clinica*') ? 'active-line' : '' }}" href="{{ route('clinica.index') }}">Clínica</a>
            </li> 
            <li class="nav-item {{ Request::is('convenios*') ? 'active' : '' }}">
                <a class="nav-link nav-link-config {{ Request::is('convenios*') ? 'active-line' : '' }}" href="{{ route('convenios.index') }}">Convênios</a>
            </li>
            <li class="nav-item {{ Request::is('procedimentos*') ? 'active' : '' }}">
                <a class="nav-link nav-link-config {{ Request::is('procedimentos*') ? 'active-line' : '' }}" href="{{ route('procedimentos.index') }}">Procedimentos</a>
            </li>
        </ul>
    </div>
</nav>