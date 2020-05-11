<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment_body', 'book_id', 'user_id', 'created_at', 'updated_at', 'rate'];
    // Book OneToMany Inverse
    public function book()
    {
        return $this->belongsTo('App\User', 'book_id');
    }
    // User OneToMany Inverse
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    // Comment Rate OneToMany
    public function rates()
    {
        return $this->hasMany("App\CommentRate", "comment_id");
    }
}
