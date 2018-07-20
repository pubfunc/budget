@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        @if($editing)
                        Edit Account
                        @else
                        Add Account
                        @endif
                    </h2>

                    @isset($errors)
                    <ul class="list-unstyled text-danger">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endisset

                    <form 
                        id="form_account"
                        action="{{ $editing ? route('accounts.update', [$account->id]) : route('accounts.store') }}" 
                        method="POST">
                        {{ csrf_field() }}

                        @if($editing)
                        @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="">Parent</label>
                            <select class="custom-select" name="parent_account_id" id="select_parent_account_id">
                                @foreach($parentAccounts as $account)
                                <option value="{{ $account->id }}" {{ old('parent_account_id', isset($account) ? $account->parent_id : null) === $account->id ? 'selected' : '' }}>{{ $account->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', isset($account) ? $account->title : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control">{{ old('description', isset($account) ? $account->description : '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <select class="custom-select" name="type" id="select_type">
                                @foreach(trans('account.types') as $id=>$type)
                                <option value="{{ $id }}" {{ old('type', isset($account) ? $account->type : null) === $id ? 'selected' : '' }}>{{ $type['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-default" href="{{ url()->previous() }}">Cancel</a>
                    <button type="submit" form="form_account" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
