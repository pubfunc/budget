@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6">

            <div class="card">

                <form
                    id="form_statement_upload"
                    action="{{ route('statement.upload') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    novalidate
                    class="card-body">

                    <h2 class="card-title">
                        Upload Statement
                    </h2>

                    @isset($errors)
                    <ul class="list-unstyled text-danger">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endisset

                    {{ csrf_field() }}

                    <div class="form-group">
                        <select name="format" class="form-control" id="select_format">
                            <option>Select Statement Format</option>
                            <option value="fnb" {{ old('format') === 'fnb' ? 'selected' : '' }}>FNB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" name="file" id="input_file" accept="application/pdf">
                    </div>
                </form>
                <div class="card-footer text-right">
                    <button type="submit" form="form_statement_upload" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection