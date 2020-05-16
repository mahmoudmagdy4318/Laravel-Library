@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Panel</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="row mb-5 ml-2">
                    <div class="card mr-3" style="width: 20rem;">
                        <div class="card-body">
                            <a class="editor-link" href="{{ route('admins.index') }}">{{ __('Admins') }}</a>

                        </div>
                    </div>
                    <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <a class="editor-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>

                        </div>
                    </div>
                </div>
                <div class="row ml-2">
                    <div class="card mr-3" style="width: 20rem;">
                        <div class="card-body">
                            <a class="editor-link" href="{{ route('admin.books') }}">{{ __('Books') }}</a>

                        </div>
                    </div>
                    <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <a class="editor-link" href="{{ route('admin.categories') }}">{{ __('Categories') }}</a>

                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
