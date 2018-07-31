@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">Home</div>

                <div class="card-body text-center">
                    <a href="{{ route('organization.index') }}" class="btn btn-primary">Organizations</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
