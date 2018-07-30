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
                            <td>{{ $statement_data->attributes['account_title'] }}</td>
                            <th>Account #</th>
                            <td>{{ $statement_data->attributes['account_number'] }}</td>
                        </tr>
                        <tr>
                            <th>Period Start</th>
                            <td>{{ carbon($statement_data->attributes['period_start'])->toFormattedDateString() }}</td>
                            <th># Transactions</th>
                            <td>{{ count($statement_data->transactions) }}</td>
                        </tr>
                        <tr>
                            <th>Period End</th>
                            <td>{{ carbon($statement_data->attributes['period_end'])->toFormattedDateString() }} ({{ carbon($statement_data->attributes['period_end'])->diffForHumans() }})</td>
                            <th>Currency</th>
                            <td>{{ $statement_data->attributes['currency'] }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer text-right">
                    <button class="btn btn-danger">Delete</button>
                    <button class="btn btn-primary">Import</button>
                </div>
            </div>

            <ul id="statement_tabs" class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" role="tab" href="#preview_transactions_tab">Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab" href="#preview_text_tab">Text</a>
                </li>
            </ul>
            <div class="tab-content" id="statement_tab_content">
                <div class="card tab-pane active" id="preview_transactions_tab">


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
                            @if($statement_data->attributes['open_balance'])
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Opening Balance</td>
                                <td></td>
                                <td class="{{ $statement_data->attributes['open_balance']->getAmount()->isPositive() ? 'text-success' : 'text-danger' }}">{{ $statement_data->attributes['open_balance'] }}</td>
                            </tr>
                            @endif
                            @foreach($statement_data->transactions as $transaction)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" value="option1">
                                </td>
                                <td class="text-nowrap">{{ $transaction['date']->toDateString() }}</td>
                                <td><samp>{{ $transaction['description'] }}</samp></td>
                                <td class="{{ $transaction['side'] === 'credit' ? 'text-success' : 'text-danger' }}">{{ $transaction['amount'] }}</td>
                                <td>{{ $transaction['balance'] }}</td>
                            </tr>
                            @endforeach
                            @if($statement_data->attributes['close_balance'])
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Closing Balance</td>
                                <td></td>
                                <td class="{{ $statement_data->attributes['close_side'] === 'credit' ? 'text-success' : 'text-danger' }}">{{ $statement_data->attributes['close_balance'] }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>


                </div>
                <div class="card tab-pane" id="preview_text_tab">
                    <pre class="card-body">
                        <samp class="small">{{ $statement_data->text }}</samp>
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection