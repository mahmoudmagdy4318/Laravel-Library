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
                        دا شغال
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
                            <span class="review-stars commentRateContainer" id="{{$comment->id}}" style="color: #1e88e5;">
                            <!-- Comment Average Rate -->
                            @for($i = 0; $i < 5; ++$i)
                                <i class="fa fa-star{{ $comment->rate > $i ? '' : '-o' }}" aria-hidden="true"></i>
                            @endfor
                            </span>
                            <div style="float:right;">
                            <!-- User Comments Rates -->
                            <span class="review-stars" id="{{$comment->id}}" style="color: #1e88e5;">
                            @php
                            $flag = 0
                            @endphp
                            @foreach($comment->rates as $commentRate)
                                @if($commentRate->user_id == Auth::id())
                                    @for($i = 0; $i < 5; ++$i)
                                        <i class="commentRate fa fa-star{{ $commentRate->comment_rate > $i ? '' : '-o' }}" aria-hidden="true"></i>
                                    @endfor
                                    @php
                                    $flag = 1
                                    @endphp
                                    @break
                                @endif
                            @endforeach
                            @if($flag != 1)
                                @for($i = 0; $i < 5; ++$i)
                                    <i class="commentRate fa fa-star-o" aria-hidden="true"></i>
                                @endfor
                                @php
                                $flag = 0;
                                @endphp
                            @endif

                            </span>
                            </div><br>
                            <span>{{date('m/d/Y h:i', strtotime($comment->created_at))}}</span>
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
    // Book Rate
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
                let bookRate = data.avgBookRate;
                console.log(bookRate);
                $(".bookRateContainer").html("");
                for(var i=0; i<5; ++i){
                    if(bookRate > i)
                        $(".bookRateContainer").append('<i class="fa fa-star" aria-hidden="true"></i>');
                    else
                        $(".bookRateContainer").append('<i class="fa fa-star-o" aria-hidden="true"></i>');
                }
            }
        });
    });
    // Comment Rate
    $(".commentRate").on("click", function(e){
        let average_comment_rate_container = $(this).parent().parent().prev();
        $(this).siblings().removeClass("fa-star fa-star-o").addClass("fa-star-o");
        $(this).removeClass("fa-star-o").addClass("fa fa-star");
        $(this).prevAll().removeClass("fa-star-o").addClass("fa fa-star");
        let comment_rate = $(this).prevAll().length+1;
        let comment_id = $(this).parent().attr("id");
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url:'/commentrate',
            type: 'POST',
            data: {_token: CSRF_TOKEN, comment_rate: comment_rate, comment_id: comment_id},
            dataType: 'JSON',
            success: function (data) {
                let commentRate = data.avgCommentRate;
                console.log(average_comment_rate_container);
                average_comment_rate_container.html("");
                for(var i=0; i<5; ++i){
                    if(commentRate > i)
                        average_comment_rate_container.append('<i class="fa fa-star" aria-hidden="true"></i>');
                    else
                        average_comment_rate_container.append('<i class="fa fa-star-o" aria-hidden="true"></i>');
                }
            }
        });
    });

});
</script>

@endsection
