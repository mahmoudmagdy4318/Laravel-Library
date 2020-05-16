<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(9);

        return view('admin.books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.books.create", ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'book_title' => 'required | string | max:255    ',
            'author_name' => 'required | string | max:255 ',
            'book_description' => 'required | string | max:255 ',
            'quantity' => 'required | integer | min:1 | max:255 ',
            'book_img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $name = null;
        if ($files = $request->file('book_img')) {
            $name = $files->getClientOriginalName();
            $files->move('storage/images', $name);
        }
        $book = Book::create([
            'book_title' => $request->book_title,
            'author_name' => $request->author_name,
            'cat_id' => $request->cat_id,
            'quantity' => $request->quantity,
            'book_description' => $request->book_description,
            "book_img" => $name
        ]);

        return redirect()->route('admin.books');
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
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view("admin.books.edit", ["book" => $book, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $this->validate($request, [
            'book_title' => 'required | string | max:255    ',
            'author_name' => 'required | string | max:255 ',
            'book_description' => 'required | string | max:255 ',
            'quantity' => 'required | integer | min:1 | max:255 ',
            'book_img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $name = null;
        if ($files = $request->file('book_img')) {
            $name = $files->getClientOriginalName();
            $files->move('storage/images', $name);
        }
        $book->update([
            'book_title' => $request->book_title,
            'author_name' => $request->author_name,
            'cat_id' => $request->cat_id,
            'quantity' => $request->quantity,
            'book_description' => $request->book_description,
            "book_img" => $name
        ]);

        return redirect()->route('admin.books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books');
    }
}
