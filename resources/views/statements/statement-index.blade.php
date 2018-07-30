@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Statements</h2>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>File</th>
                            <th>From</th>
                            <th>To</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statements as $statement)
                        <tr>
                            <td>
                                <a class="btn btn-sm btn-outline-primary btn-block text-left" href="{{ route('statement.preview', $statement->id) }}">{{ $statement->id }}</a>
                            </td>
                            <td>{{ $statement->title }}</td>
                            <td>{{ $statement->filename }}</td>
                            <td class="text-nowrap">{{ $statement->period_start }}</td>
                            <td class="text-nowrap">{{ $statement->period_end }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <a class="btn btn-info btn-sm" href="{{ route('statement.download', $statement->id) }}">
                                        <i class="fas fa-file-download"></i>
                                    </a>
                                </div>
                                <form id="form_delete_{{ snake_case($statement->id) }}" action="{{ route('statement.destroy', $statement->id) }}">
                                    @method('DELETE')
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-footer text-right">
                    <a href="{{ route('statement.uploader') }}" class="btn btn-primary">Upload Statement</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
