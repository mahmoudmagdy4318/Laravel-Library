@extends('layouts.app')

@section('content')

<div class="container">
    <a class="btn btn-lg btn-primary mb-3" href="{{ route('admins.create') }}">{{ __('add new') }}</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <th scope="row">{{$admin->id}}</th>
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    <td class="row">
                        <a class="btn btn-info" href="{{ route('admins.edit',$admin) }}">{{ __('edit') }}</a>
                        {!! Form::open(['route'=>['admins.destroy',$admin],'method'=>'delete']) !!}
                            {!! Form::submit('Delete', ['class'=>"btn btn-warning ml-2"]) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>
</div>

@endsection
