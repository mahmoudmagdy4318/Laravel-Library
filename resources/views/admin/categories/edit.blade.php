@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{$err}}<li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!!Form::model($category,['route'=>['admin.categories.update',$category],'method'=>'put'])!!}
        @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                {!! Form::text('category_name', null, ['class'=>'form-control col-6','id'=>"name"]) !!}
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        {!! Form::close() !!}
    </div>
@endsection
