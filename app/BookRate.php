<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookRate extends Model
{
    protected $fillable = ['book_rate', 'book_id', 'user_id', 'created_at', 'updated_at'];
    // User Rates OneToMany Inverse
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    // Book Rates OneToMany Inverse
    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id');
    }
}
