<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use App\BookRate;
use Auth;
use App\Book;
class BookRateController extends Controller
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
        $rate = BookRate::where('user_id', Auth::id())->first();
        $myRequest = $request->all();
        $myRequest['user_id'] = Auth::id();
        // Validation
        if($myRequest['book_rate'] > 5 || $myRequest['book_rate'] )
            $myRequest['book_rate'] = 0;
        if($rate)
            $rate->update($request->all());
        else
            BookRate::create($myRequest);
        
        $bookRates = Book::find($myRequest['book_id']);
        $bookRates->update(['rate' => floor($bookRates->rates()->avg('book_rate'))]);
        $response = array('avgBookRate' => floor($bookRates->rates()->avg('book_rate')));
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
