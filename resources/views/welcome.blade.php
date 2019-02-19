@extends('layouts.auth')

@section('content')
<div class="btn-group m-4">
    @auth
        <a class="btn btn-info" href="{{ url('/home') }}">Home</a>
    @else
        <a class="btn btn-info" href="{{ route('login') }}">Login</a>
        <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
    @endauth
</div>
@endsection
