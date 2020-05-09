<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_rates', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer("book_rate");
            $table->unsignedBigInteger("book_id");
            $table->unsignedBigInteger("user_id");
            $table->foreign("book_id")->references("id")->on("books");
            $table->foreign("user_id")->references("id")->on("users");
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
        Schema::dropIfExists('book_rates');
    }
}
