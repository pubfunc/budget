<table class="table table-striped table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <!-- <th>Amount</th> -->
            <th>Debit</th>
            <th>Credit</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $trans)
        <tr>
            <td>{{ $trans->date->format('Y-m-d') }}</td>
            <td><small>{{ $trans->description }}</small></td>
            <!-- <td>{{ $trans->amount }}</td> -->
            <td>
                @if($trans->debitAccount)
                {{ $trans->debitAccount->title }}<br>
                <small class="{{ $trans->debit_amount < 0 ? 'text-danger' : 'text-success' }}">{{ money($trans->debit_amount) }}</small>
                @endif
            </td>
            <td>
                @if($trans->creditAccount)
                {{ $trans->creditAccount->title }}<br>
                <small class="{{ $trans->credit_amount < 0 ? 'text-danger' : 'text-success' }}">{{ money($trans->credit_amount) }}</small>
                @endif
            </td>
            <td class="text-right">
                <div class="btn-group" role="group">
                    <a class="btn btn-warning btn-sm" href="{{ route('transaction.edit', $trans) }}">
                        <i class="far fa-edit"></i>
                    </a>
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>