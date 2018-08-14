<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Organization;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Organization $organization)
    {

        $transactions = $organization->transactions()
                                    ->orderBy('date', 'desc')
                                    ->get();

        $transactions->load(['debitAccount', 'creditAccount']);

        return view('transaction.transaction-index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $organization)
    {

        $accountOptions = $organization->accounts()
                                        ->orderBy('title')
                                        ->get()
                                        ->groupBy('type');
        // dd($accountOptions);

        return view('transaction.transaction-form', compact('accountOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Organization $organization, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|min:3',
            'amount' => 'required|integer|min:0',
            'debit_account_id' => ['required', Rule::in($organization->accounts->pluck('id'))],
            'credit_account_id' => ['required', Rule::in($organization->accounts->pluck('id'))]
        ]);

        $transaction = new Transaction;
        $transaction->fill($request->all());
        $transaction->organization()->associate($organization);
        $transaction->save();

        return redirect()->route('transaction.index')->with('success_status', 'Transaction created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
