<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookProizvoditelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_proizvoditels', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('books_id')->nullable();
            $table->string('proizvoditel_id')->nullable();
            $table->string('proizvoditel_name')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('book_proizvoditels');
    }
}
