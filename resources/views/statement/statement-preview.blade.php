@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <h1>Statement Preview</h1>

            <div class="card my-2">
                <div class="card-body">
                    <h5 class="card-title">{{ $statement->title }}</h5>
                </div>
                <table class="table table-borderless table-striped mb-0">
                    <tbody>
                        <tr>
                            <th>Account Title</th>
                            <td>{{ $data->account_title }}</td>
                            <th>Account #</th>
                            <td>{{ $data->account_number }}</td>
                        </tr>
                        <tr>
                            <th>Account Type</th>
                            <td>{{ $data->account_type }}</td>
                            <th>Balance Side</th>
                            <td>{{ $data->balance_side }}</td>
                        </tr>
                        <tr>
                            <th>Period Start</th>
                            <td>{{ carbon($data->period_start)->toFormattedDateString() }}</td>
                            <th># Transactions</th>
                            <td>{{ count($data->records) }}</td>
                        </tr>
                        <tr>
                            <th>Period End</th>
                            <td>{{ carbon($data->period_end)->toFormattedDateString() }} ({{ carbon($data->period_end)->diffForHumans() }})</td>
                            <th>Currency</th>
                            <td>{{ $data->currency }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer text-right">
                    <form action="{{ route('statement.import', ['statement' => $statement]) }}" method="POST">
                        {{ csrf_field() }}
                        <select name="account_id" id="">
                            @foreach($importAccounts as $account)
                            <option value="{{ $account->id }}">{{ $account->title }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>

            <ul id="statement_tabs" class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" role="tab" href="#preview_transaction_tab">Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab" href="#preview_text_tab">Text</a>
                </li>
            </ul>
            <div class="tab-content" id="statement_tab_content">
                <div class="card tab-pane active" id="preview_transaction_tab">


                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                        <label class="form-check-label" for="inlineCheckbox1">All</label>
                                    </div>
                                </th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->open_balance)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Opening Balance</td>
                                <td></td>
                                <td>{{ money($data->open_balance, $data->currency) }}</td>
                            </tr>
                            @endif
                            @foreach($data->records as $record)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" value="option1">
                                </td>
                                <td class="text-nowrap">{{ $record->date->toDateString() }}</td>
                                <td class="text-monospace small">{{ $record->description }}</td>
                                <td class="text-nowrap {{ $record->amount >= 0 ? 'text-success' : 'text-danger' }}">{{ money($record->amount, $data->currency) }}</td>
                                <td class="text-nowrap">{{ money($record->balance, $data->currency) }}</td>
                            </tr>
                            @endforeach
                            @if($data->close_balance)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Closing Balance</td>
                                <td></td>
                                <td>{{ money($data->close_balance, $data->currency) }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>


                </div>
                <div class="card tab-pane" id="preview_text_tab">
                    <pre class="card-body">
                        <samp class="small">{{ $data->text }}</samp>
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection