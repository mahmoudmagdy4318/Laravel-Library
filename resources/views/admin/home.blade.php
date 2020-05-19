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
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>profit per week</b></div>
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: '/leasedBooks',
                type: 'GET',

                success: function(data) {
                    const myData = data.data.reverse();
                    const weekNumbers = data.weekNum.reverse().map(ele => 'week' + ele);
                    var options = {
                        type: 'line',
                        data: {
                            labels: weekNumbers,
                            datasets: [{
                                    label: "profit per week",
                                    data: myData,
                                    borderWidth: 3,
                                    lineTension: 0,
                                    backgroundColor: "rgba(70,172,172,0.2)",
                                    borderColor: "rgba(70,172,172,0.2)"
    
                                },



                            ]
                        },
                        options: {
                            bezierCurve: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        reverse: false
                                    }
                                }]
                            }
                        }
                    }

                    var ctx = document.getElementById('canvas').getContext('2d');
                    new Chart(ctx, options);
                }
            });





        });
    </script>
    @endsection