@extends('layouts.app')

@section('body')
<div class="container-fluid h-100">
    <div class="row align-items-center justify-content-center h-100">
        <main class="text-center">
            
            <h1 class="display-2"><i class="far fa-chart-bar display-4"></i> Budget</h1>

            <div class="btn-group m-4">
                @auth
                    <a class="btn btn-info" href="{{ url('/home') }}">Home</a>
                @else
                    <a class="btn btn-info" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </main>
    </div>
</div>
@endsection
