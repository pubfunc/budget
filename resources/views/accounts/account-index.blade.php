@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Accounts</h2>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>ID</th>
                            <th>DEB</th>
                            <th>CRE</th>
                            <th>BAL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td class="text-center">
                                <i class="icon-2 {{ trans('account.types.' . $account->type . '.icon') }}"></i>
                            </td>
                            <td>{{ $account->title }}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary btn-block text-left" href="{{ route('accounts.show', [$account->id]) }}">{{ $account->id }}</a>
                            </td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-warning btn-sm" href="{{ route('accounts.edit', $account->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                                <form id="form_delete_{{ snake_case($account->id) }}" action="{{ route('accounts.destroy', $account->id) }}">
                                    @method('DELETE')
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-footer text-right">
                    <a href="{{ route('accounts.create') }}" class="btn btn-primary">Add Account</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
