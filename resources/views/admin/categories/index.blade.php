@extends('layouts.app')

@section('content')

<div class="container">
    <a class="btn btn-lg btn-primary mb-3" href="{{ route('admin.categories.create') }}">{{ __('add new category') }}</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{$category->category_name}}</td>
                    <td class="row">
                        <a class="btn btn-info" href="{{ route('admin.categories.edit',$category) }}">{{ __('edit') }}</a>
                        {!! Form::open(['route'=>['admin.categories.destroy',$category],'method'=>'delete']) !!}
                            {!! Form::submit('Delete', ['class'=>"btn btn-warning ml-2"]) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>
      {{ $categories->links() }}
</div>

@endsection
