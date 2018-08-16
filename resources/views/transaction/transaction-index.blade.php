@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card my-4">
                <div class="card-body">
                    <h2 class="card-title">Transactions</h2>
                </div>
                <nav class="navbar navbar-dark justify-content-end">
                    <form class="form-inline">
                        <input class="form-control form-control-sm mr-sm-2" type="date" placeholder="From Date" aria-label="From Date">
                        <input class="form-control form-control-sm mr-sm-2" type="date" placeholder="To Date" aria-label="To Date">
                        <button class="btn btn-sm btn-success my-2 my-sm-0" type="submit">Filter</button>
                    </form>
                </nav>
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
