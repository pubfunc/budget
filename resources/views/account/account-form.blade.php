@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card my-2">
                <div class="card-body">
                    <h2 class="card-title">
                        @isset($account)
                        Edit Account
                        @else
                        Add Account
                        @endisset
                    </h2>

                    <form 
                        id="form_account"
                        action="{{ isset($account) ? route('account.update', [$account->id]) : route('account.store') }}"
                        method="POST">
                        {{ csrf_field() }}

                        @isset($account)
                        @method('PUT')
                        @endif

                        @component('ui.form.form-group', [
                            'label' => 'Title',
                            'name' => 'title',
                            'value' => isset($account) ? $account->title : ''
                        ])
                        @endcomponent
                        @component('ui.form.form-group', [
                            'type' => 'textarea',
                            'label' => 'Description',
                            'name' => 'description',
                            'value' => isset($account) ? $account->description : ''
                        ])
                        @endcomponent
                        @component('ui.form.form-group', [
                            'type' => 'select',
                            'label' => 'Type',
                            'name' => 'type',
                            'value' => isset($account) ? $account->type : App\Accounting\AccountTypes::EXPENSE,
                            'map' => App\Accounting\AccountTypes::map(),
                        ])
                        @endcomponent
                        @component('ui.form.form-group', [
                            'type' => 'select',
                            'label' => 'Currency',
                            'name' => 'currency',
                            'value' => isset($account) ? $account->currency : 'ZAR',
                            'map' => App\Accounting\Currencies::map(),
                        ])
                        @endcomponent
                    </form>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-default" href="{{ route('account.index') }}">Cancel</a>
                    <button type="submit" form="form_account" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
