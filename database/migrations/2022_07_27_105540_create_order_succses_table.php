<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSuccsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_succses', function (Blueprint $table) {
            $table->id();
            $table->string('books_id')->nullable();
            $table->string('designer_id')->nullable();
            $table->string('designer_name')->nullable();
            $table->string('designer_surname')->nullable();
            $table->string('proizvoditel_id')->nullable();
            $table->string('category_name')->nullable();
            $table->string('city')->nullable();
            $table->string('name')->nullable();
            $table->string('dubl_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('dubl_phone')->nullable();
            $table->string('price')->nullable();
            $table->string('price_pracient')->nullable();
            $table->string('pracient_price')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('order_succses');
    }
}
