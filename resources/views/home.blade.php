@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>


            </div>
        </div>
    </div>
    <div class="row justify-content-center my-3">
        <div class="col-md-6">
            <a href="{{ route('accounts.index') }}" class="btn btn-primary btn-block btn-lg">Accounts</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-block btn-lg">Transactions</a>
        </div>
    </div>
</div>
@endsection
