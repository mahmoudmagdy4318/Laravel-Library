<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment_body', 'book_id', 'user_id', 'created_at', 'updated_at'];
    // Book OneToMany Inverse
    public function book()
    {
        return $this->belongsToMany('App\User', 'book_id');
    }
    // User OneToMany Inverse
    public function user()
    {
        return $this->belongsToMany('App\User', 'user_id');
    }
}
