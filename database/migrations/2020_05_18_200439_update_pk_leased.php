<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePkLeased extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_leased_books', function (Blueprint $table) {
            // $table->dropPrimary('user_leased_books_id_primary');
            $table->dropColumn('id');
            $table->primary(['book_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_leased_books', function (Blueprint $table) {
            //
        });
    }
}
