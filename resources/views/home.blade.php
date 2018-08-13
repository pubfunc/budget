@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm my-4">

                <div class="card-body">
                    <h2 class="card-title">Home</h2>
                    <a href="{{ route('organization.index') }}" class="btn btn-primary">Organizations</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
