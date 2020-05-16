@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-lg btn-primary mb-3" href="{{ route('admin.books.create') }}">{{ __('add new book') }}</a>
        <div class="row">
        @forelse ($books as $book)
        <div class="card col-4 mb-3">
            <img src="/storage/images/{{$book->book_img}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h2 class="card-title">{{$book->book_title}}</h2>
                <p class="card-text">{{$book->book_description}}</p>
                <h3>author:{{$book->author_name}}</h3>
                <div><strong>quantity:{{$book->quantity}}</strong></div>
                <div class="container row">
                    <a class="btn btn-info mr-3" href="{{ route('admin.books.edit',$book) }}">{{ __('edit') }}</a>
                    {!! Form::open(['route'=>['admin.books.destroy',$book],'method'=>'delete']) !!}
                        {!! Form::submit('Delete', ['class'=>"btn btn-warning ml-2"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
          </div>
        @empty
            <div class="card text-left">
              <div class="card-body">
                <h4 class="card-title">no books yet</h4>
              </div>
            </div>
        @endforelse
        </div>

        {{ $books->links() }}
    </div>
@endsection
