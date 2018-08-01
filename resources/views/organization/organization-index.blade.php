@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Organizations</h2>
                </div>
                <div class="list-group">
                    @foreach($organizations as $org)
                    <a href="{{ route('organization.show', $org) }}" class="list-group-item">{{ $org->label }}</a>
                    @endforeach
                    <a href="{{ route('organization.create') }}" class="list-group-item list-group-item-light">Create Organization</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
