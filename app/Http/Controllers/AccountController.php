<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();

        return view('account.account-index', compact('accounts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $editing = false;

        $user = Auth::user();

        $parentAccounts = Account::where('user_id', $user->id)
                                ->get();

        return view('account.account-form', compact('editing', 'parentAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'parent_account_id' => 'nullable|string',
            'title' => 'required|string|min:3',
            'description' => 'nullable|string'
        ]);

        $account = new Account();

        $account->id = str_slug($request->title);
        $account->title = $request->title;
        $account->user_id = Auth::user()->id;
        $account->save();

        return redirect()
                    ->route('account.index')
                    ->with(
                        'success_status', 
                        sprintf("Account '%s' added", $account->title)
                    );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {

        $transactions = $account->transactions()
                                ->orderBy('date')
                                ->paginate(20);


        $debits_sum = $account->debitTransactions()->sum('amount');
        $credits_sum = $account->creditTransactions()->sum('amount');
        $balance = $debits_sum - $credits_sum;

        return view('account.account-detail', compact(
                        'account',
                        'transactions',
                        'debits_sum',
                        'credits_sum',
                        'balance'
                    ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $editing = true;

        $user = Auth::user();

        $parentAccounts = Account::where('user_id', $user->id)
                                ->where('id', '!=', $account->id)
                                ->get();

        return view('account.account-form', compact('editing', 'account', 'parentAccounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
