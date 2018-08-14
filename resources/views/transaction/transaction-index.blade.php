@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card my-4">
                <div class="card-body">
                    <h2 class="card-title">Transactions</h2>
                </div>
                @component('transaction.transaction-table', ['transactions' => $transactions])
                @endcomponent
                <div class="card-footer text-right">
                    <a href="{{ route('transaction.create') }}" class="btn btn-primary">Add Transaction</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
