<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserLeasedBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_leased_books', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("book_id");
            $table->unsignedBigInteger("user_id");
            $table->foreign("book_id")->references("id")->on("books");
            $table->foreign("user_id")->references("id")->on("users");
            $table->integer("payed");
            $table->integer("days");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
