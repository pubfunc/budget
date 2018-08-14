@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card my-4">
                <div class="card-body">
                    <h2 class="card-title">{{ isset($transaction) ? 'Update' : 'Add' }} Transaction</h2>
                    <form id="form_transaction" method="POST">
                        @csrf
                        @isset($transaction)
                        @method('PUT')
                        @endisset
                        @component('ui.form.form-group', [
                            'label' => 'Description',
                            'name' => 'description',
                            'value' => isset($transaction) ? $transaction->description : ''
                        ])
                        @endcomponent
                        @component('ui.form.form-group', [
                            'label' => 'Amount',
                            'name' => 'amount',
                            'value' => isset($transaction) ? $transaction->amount : ''
                        ])
                        @endcomponent
                        @component('ui.form.form-group', [
                            'label' => 'Date',
                            'name' => 'date',
                            'type' => 'date',
                            'value' => isset($transaction) ? $transaction->date : ''
                        ])
                        @endcomponent
                        @component('account.account-form-group-select', [
                            'label' => 'Debit Account',
                            'name' => 'debit_account_id',
                            'value' => isset($transaction) ? $transaction->debit_account_id : '',
                            'accountOptions' => $accountOptions
                        ])
                        @endcomponent
                        @component('account.account-form-group-select', [
                            'label' => 'Credit Account',
                            'name' => 'credit_account_id',
                            'value' => isset($transaction) ? $transaction->credit_account_id : '',
                            'accountOptions' => $accountOptions
                        ])
                        @endcomponent
                        @component('ui.form.form-group', [
                            'label' => 'Import ID',
                            'name' => 'import_id',
                            'value' => isset($transaction) ? $transaction->import_id : ''
                        ])
                        @endcomponent
                    </form>
                </div>
                <div class="card-footer text-right">
                    @isset($transaction)
                    <button type="submit" form="form_transaction" formaction="{{ route('transaction.update', $transaction) }}" class="btn btn-secondary">Save</button>
                    @else
                    <button type="submit" form="form_transaction" formaction="{{ route('transaction.store') }}" class="btn btn-primary">Create</button>
                    @endisset
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
