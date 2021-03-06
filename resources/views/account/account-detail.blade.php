@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-2">

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h1 class="card-title">
                        {{ $account->title }}
                        <small class="text-muted">#ACC{{ $account->id }}</small>
                    </h1>

                    <p>
                        {{ $account->description }}
                    </p>

                </div>
                <div class="container-fluid">
                    <div class="row justify-content-around text-center my-3">

                        <div class="col p-4 ml-4 shadow-sm bg-light border border-primary">
                            <h4>Credit Balance</h4>
                            <p class="lead mb-0">{{ money($credits_sum) }}</p>
                        </div>
                        <div class="col p-4 mx-2 shadow-sm bg-light border border-primary">
                            <h4>Debit Balance</h4>
                            <p class="lead mb-0">{{ money($debits_sum) }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('account.edit', $account) }}" class="btn btn-warning">
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
        <div class="col-lg-10">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">
                        Transactions
                    </h3>
                </div>
                @component('transaction.transaction-table', ['transactions' => $transactions])

                @endcomponent

                <div class="card-footer">
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
