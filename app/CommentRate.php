<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentRate extends Model
{
    protected $fillable = ['comment_rate', 'comment_id', 'user_id', 'created_at', 'updated_at'];
    // Comments Rates OneToMany Inverse
    public function comment()
    {
        return $this->belongsTo('App\Comment', 'comment_id');
    }
}
