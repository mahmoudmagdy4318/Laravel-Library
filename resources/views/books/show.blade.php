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
                <span class="review-stars bookRateContainer" style="color: #1e88e5;">
                @for ($i = 0; $i < 5; ++$i)
                    <i class="fa fa-star{{ $book->rate>$i?'':'-o' }}" aria-hidden="true"></i>
                @endfor
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
                <br/><br/>
                <p class="BoldFont ratePara">Rate This Book</p>
                <span class="review-stars bookStars" style="color: #1e88e5;">
                    @for($i = 0; $i < 5; ++$i)
                        <i class="bookRate fa fa-star{{ $user_rate > $i ? '' : '-o' }}" aria-hidden="true"></i>
                    @endfor
                </span>
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
                                <i class="fa fa-star commentRate" aria-hidden="true"></i>
                                <i class="fa fa-star commentRate" aria-hidden="true"></i>
                                <i class="fa fa-star commentRate" aria-hidden="true"></i>
                                <i class="fa fa-star commentRate" aria-hidden="true"></i>
                                <i class="fa fa-star commentRate" aria-hidden="true"></i>
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
<script type="text/javascript">
$(document).ready(function () {
    $(".bookRate").on("click", function(e){
        $(this).siblings().removeClass("fa-star fa-star-o").addClass("fa-star-o");
        $(this).removeClass("fa-star-o").addClass("fa fa-star");
        $(this).prevAll().removeClass("fa-star-o").addClass("fa fa-star");
        let book_rate = $(this).prevAll().length+1;
        let book_id = <?php echo $book->id; ?>;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url:'/bookrate',
            type: 'POST',
            data: {_token: CSRF_TOKEN, book_rate: book_rate, book_id: book_id},
            dataType: 'JSON',
            success: function (data) { 
                console.log(data.avgBookRate);
                $(".bookRateContainer").html = "";
                for(var i=0; i<5; ++i){
                    $(".bookRateContainer").append('<i class="fa fa-star',(data.avgBookRate > i?'':'-o'),'" aria-hidden="true"></i>');
                }
            }
        });
    });
});
</script>

@endsection
