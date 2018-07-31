@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row justify-content-around text-center">
                        <div class="col-sm-4 col-md-3 p-4 m-2 shadow-sm bg-light">
                            <h4>Liabilities</h4>
                            <p class="lead">{{ currency(rand(0,999999)) }}</p>
                        </div>
                        <div class="col-sm-4 col-md-3 p-4 m-2 shadow-sm bg-light">
                            <h4>Capital</h4>
                            <p class="lead">{{ currency(rand(0,999999)) }}</p>
                        </div>
                        <div class="col-sm-4 col-md-3 p-4 m-2 shadow-sm bg-light">
                            <h4>Assets</h4>
                            <p class="lead">{{ currency(rand(0,999999)) }}</p>
                        </div>
                    </div>


                    <a href="{{ route('account.index') }}" class="btn btn-primary">Accounts</a>
                    <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Transactions</a>
                    <a href="{{ route('statement.index') }}" class="btn btn-secondary">Statements</a>
                    <a href="{{ route('statement.uploader') }}" class="btn btn-secondary">Upload Statement</a>

                </div>


            </div>
        </div>
    </div>
</div>
@endsection
