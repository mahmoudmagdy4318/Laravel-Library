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
        <!-- Add Comments Section -->
        <div class="row headerDiv">
            <div class="col-8">
                {!! Form::open(['route' => ['comment.store']]) !!}
                    <div class="form-group formTextArea">
                        {!! Form::textArea('comment_body', null, ['class' => 'form-control textAreaField', 'placeholder' => 'Write Your Comment...']) !!}  
                    </div>
                    {{ Form::hidden('book_id', $book->id) }}
                    {!! Form::submit('Comment', ['class' => 'btn btn-primary col-12']) !!}
                {!! Form::close() !!}
                <br/>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
                @endforeach
            </div>
        </div>
        <!-- List Comments Section -->
        <div class="row headerDiv">
            <div class="col-8">
                <h3 class="BoldFont">Comments</h3>
                <div class="card">
                    <h5 class="card-header">Featured
                        <div style="float:right;">
                            *******
                        </div>
                    </h5>
                    <div class="card-body">
                        <p class="card-text bookFonts">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div >

@endsection
