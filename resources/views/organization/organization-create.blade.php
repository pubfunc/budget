@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Add Organization</h2>

                    @component('organization.organization-form', ['action' => route('organization.store'), 'method' => 'POST'])
                    @endcomponent
                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary" form="organization_form">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
