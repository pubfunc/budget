@extends('layouts.html')
@section('body')
<div class="h-100 d-flex flex-column justify-content-center align-items-center">

    <div class="text-center mb-3">
        <h1 class="display-3"><i class="far fa-chart-bar display-4"></i> Budget</h1>
    </div>

    @yield('content')

</div>
@endsection