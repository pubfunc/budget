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
            <td>{{ $trans->debitAccount->title }}</td>
            <td>{{ $trans->creditAccount->title }}</td>
        </tr>
        @endforeach
    </tbody>
</table>