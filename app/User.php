<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'isAdmin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Comments OneToMany Relationship
    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }
    // Book Rates OneToMany Relationship
    public function bookRates()
    {
        return $this->hasMany('App\BookRate', 'user_id');
    }
    public function favouriteBooks()
    {
        return $this->belongsToMany('App\Book', 'user_faviourite_books')->withTimestamps();
    }
    public function leasedBooks()
    {
        return $this->belongsToMany('App\Book', 'user_leased_books')->using('App\LeasedBooks')->withTimestamps();
    }
}
