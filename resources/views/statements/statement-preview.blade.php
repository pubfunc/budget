@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 position-sticky">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active"
                    data-toggle="list" href="#preview_transactions" role="tab">Transactions</a>
                <a class="list-group-item list-group-item-action"
                    data-toggle="list" href="#preview_text" role="tab">Text</a>
            </div>
        </div>
        <div class="col-8 tab-content">

            <div class="card tab-pane active" id="preview_transactions">

                <div class="card-body">
                    <h2 class="card-title">
                        Statement Preview
                    </h2>
                </div>

                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statement_data['transactions'] as $transaction)
                        <tr>
                            <td>{{ $transaction['date'] }}</td>
                            <td><samp>{{ $transaction['description'] }}</samp></td>
                            <td>{{ $transaction['amount'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
            <div class="card tab-pane" id="preview_text">
                <pre class="card-body">
                    <samp>{{ $statement_data['text'] }}</samp>
                </pre>
            </div>
        </div>
    </div>
</div>

@endsection