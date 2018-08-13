@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">

            <div class="card my-4">
                <div class="card-body">
                    <a href="{{ route('account.create') }}" class="btn btn-primary float-right">Add Account</a>
                    <h2 class="card-title">Accounts</h2>
                </div>

                @foreach($accounts->groupBy('type') as $type=>$grouped_accounts)
                <div class="card-body mt-3">
                    <h3 class="card-title">{{ trans('account.types.' . $type . '.label') }}</h3>
                </div>
                <table class="table table-striped table-hover m-0 table-sm">
                    <tbody>
                        @foreach($grouped_accounts as $account)
                        <tr>
                            <td width="300"><a class="btn btn-sm btn-primary btn-block text-left" href="{{ route('account.show', [$account->id]) }}">{{ $account->title }}</a></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td class="text-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-warning btn-sm" href="{{ route('account.edit', $account->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                                <form id="form_delete_{{ $account->id }}" action="{{ route('account.destroy', $account->id) }}">
                                    @method('DELETE')
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
                <div class="card-footer text-right">
                    
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
