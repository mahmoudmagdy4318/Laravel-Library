@extends('layouts.app')
@section('content')
<link href="{{ asset('css/showBook.css') }}" rel="stylesheet">
<div class="container">
    <div class="row headerDiv">
        <!-- Book Section -->
            <div class="col-3">
                <img src="{{ URL::to('/') }}/images/1.png">
            </div>
            <div class="col-6">
                <h3>{{ $book->book_title }}</h3>
                <p class="bookFonts">******</p>
                <div class="col-9 bookDesc">
                    <p class="bookFonts"> {{ $book->book_description }}</p>
                </div>
                <p class="bookFonts">{{ $book->quantity }} Copies Available</p>
                <button class="btn btn-success" >Lease</button>
            </div>
            <div class="col-3">
                Fav This Book
            </div>
        </div>
        <!-- Comments Section -->
        <div class="row headerDiv">
            <div class="col-8">
                {!! Form::open(['route' => 'comment.store']) !!}
                    <div class="form-group formTextArea">
                        {!! Form::textArea('comment_body', null, ['class' => 'form-control textAreaField', 'placeholder' => 'Write Your Comment...']) !!}  
                    </div>
                    {!! Form::submit('Comment', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
                <br/>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div >

@endsection
