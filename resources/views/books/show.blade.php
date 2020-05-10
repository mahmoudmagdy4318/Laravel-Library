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
                <span class="review-stars" style="color: #1e88e5;">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                </span>
                <div class="col-9 bookDesc">
                    <p class="bookFonts"> {{ $book->book_description }}</p>
                </div>
                <p class="bookFonts">{{ $book->quantity }} Copies Available</p>
                <button class="btn btn-success" >Lease</button>
            </div>
            <div class="col-3">
                <p class="BoldFont">Fav This Book</p>
                <i class="fa fa-heart fa-3x heart" aria-hidden="true"></i>
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
                @forelse($comments as $comment)
                    <div class="card">
                        <div class="card-header">
                            <span class="bookFonts BoldFont">{{$comment->user->name}}</span>
                            <div style="float:right;">
                            <span class="review-stars" style="color: #1e88e5;">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </span>
                            </div><br>
                            <span>{{$comment->created_at}}</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text bookFonts">{{$comment->comment_body}}</p>
                        </div>
                    </div>
                @empty
                    <div class="card-body">
                        <p class="card-text bookFonts">There isn't Any Comment on This Book</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div >

@endsection
