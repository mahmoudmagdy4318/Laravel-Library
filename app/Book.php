<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['rate', 'book_title', 'book_description', 'author_name',
        'quantity', 'book_img', 'cat_id', 'created_at', 'updated_at'];
    // Book Comments
    public function comments()
    {
        return $this->hasMany('App\Comment','book_id');
    }
    // Book Ratings
    public function rates()
    {
        return $this->hasMany("App\BookRate", 'book_id');
    }
}
