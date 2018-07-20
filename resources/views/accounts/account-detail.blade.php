@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 mb-2">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">
                        {{ $account->title }}
                        <small class="text-muted">{{ $account->id }}</small>
                    </h2>

                    <div class="row justify-content-around text-center">

                        <div class="col-sm-4 col-md-3 p-4 m-2 shadow-sm bg-light">
                            <h4>Credits</h4>
                            <p class="lead">{{ currency($credits_sum) }}</p>
                        </div>
                        <div class="col-sm-4 col-md-3 p-4 m-2 shadow-sm bg-light">
                            <h4>Debits</h4>
                            <p class="lead">{{ currency($debits_sum) }}</p>
                        </div>
                        <div class="col-sm-4 col-md-3 p-4 m-2 shadow-sm bg-light">
                            <h4>Balance</h4>
                            <p class="lead">{{ currency($balance) }}</p>
                        </div>

                    </div>

                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('accounts.create') }}" class="btn btn-warning">
                        <i class="far fa-edit"></i>
                        Edit Account
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="far fa-trash-alt"></i>
                        Delete Account
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm">
                <div class="card-header">
                Transactions
                </div>

                <table class="table table-striped table-hover table-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trans)
                        <tr>
                            <td>{{ $trans->date->format('Y-m-d') }}</td>
                            <td>{{ $trans->description }}</td>
                            <td>{{ $trans->amount }}</td>
                            <td>{{ $trans->debit_account_id }}</td>
                            <td>{{ $trans->credit_account_id }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-footer">
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
