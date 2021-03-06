@extends('layouts.html')

@section('body')
<div class="app" id="app">
    <nav class="sidebar navbar navbar-expand-md navbar-dark bg-primary">

        <a class="navbar-brand" href="{{ Auth::check() ? route('home') : url('/') }}">
            <i class="far fa-chart-bar"></i>
            {{ config('app.name', 'Laravel') }}
        </a>
        @isset($context)
        <strong class="navbar-text">{{ $context->label }}</strong>
        @endisset

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="sidebar-links collapse navbar-collapse flex-column" id="navbarSupportedContent">

        @guest
            <ul class="navbar-nav flex-column nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ is_active_route('home', ' active') }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
            </ul>
        @else

            @isset($context)
            <ul class="navbar-nav flex-column nav-pills">
                <li class="nav-item">
                    <a class="nav-link{{ route_starts_with('account', ' active') }}" href="{{ route('account.index') }}">Accounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ route_starts_with('transaction', ' active') }}" href="{{ route('transaction.index') }}">Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ route_starts_with('statement', ' active') }}" href="{{ route('statement.index') }}">Statements</a>
                </li>
            </ul>
            @endisset
            <ul class="navbar-nav flex-column nav-pills">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

        @endguest
        </div>
    </nav>

    <main class="main">

        <div class="nav-padding"></div>

        @yield('content')
    </main>
</div>
@endsection