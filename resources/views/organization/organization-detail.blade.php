@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $organization->label }}</h2>
                </div>

                <div class="list-group">
                    <a href="{{ route('account.index') }}" class="list-group-item">Accounts</a>
                    <a href="{{ route('statement.index') }}" class="list-group-item">Statements</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
