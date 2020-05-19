<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LeasedBooks extends Pivot
{
    // public $incrementing = true;
    protected $table = 'user_leased_books';
}
