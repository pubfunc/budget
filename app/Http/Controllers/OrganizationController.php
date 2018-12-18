<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Account;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = $this->user()->organizations;


        return view('organization.organization-index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organization.organization-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:32',
        ]);

        $user = $this->user();

        $org = new Organization();
        $org->label = $request->label;
        $org->slug = str_slug($request->label);

        while(Organization::where('slug', $org->slug)->count()){
            $rand = str_random(3);
            $org->slug = sprintf('%s-%s', str_slug($request->label), $rand);
        }

        $org->save();
    
        $org->users()->attach($user);

        $base_accounts = [];

        // create base personal accounts
        foreach(config('accounts.personal') as $type => $accounts){
            foreach($accounts as $account){

                $account = new Account($account);
                $account->type = $type;
                $account->currency = 'ZAR';

                $base_accounts[] = $account;
            }
        }

        $org->accounts()->saveMany($base_accounts);

        return redirect()->route('organization.show', $org->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $context = $organization;

        return view('organization.organization-detail', compact('organization', 'context'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
