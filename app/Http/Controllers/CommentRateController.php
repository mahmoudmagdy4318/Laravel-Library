<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use App\CommentRate;
use Auth;
use App\Comment;
class CommentRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rate = CommentRate::where('user_id', Auth::id())->where('comment_id', $request->comment_id)->first();
        $myRequest = $request->all();
        $myRequest['user_id'] = Auth::id();
        // Validation
        if($myRequest['comment_rate'] > 5 || $myRequest['comment_rate'] < 0)
            $myRequest['comment_rate'] = 0;
        if($rate)
            $rate->update($request->all());
        else
            CommentRate::create($myRequest);
        
        $commentRates = Comment::find($myRequest['comment_id']);
        $commentRates->update(['rate' => floor($commentRates->rates()->avg('comment_rate'))]);
        $response = array('avgCommentRate' => floor($commentRates->rates()->avg('comment_rate')),);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
