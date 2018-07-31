@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Accounts</h2>
                </div>
                @component('transaction.transaction-table')
                @endcomponent
                <div class="card-footer text-right">
                    <a href="{{ route('transaction.create') }}" class="btn btn-primary">Add Transaction</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
