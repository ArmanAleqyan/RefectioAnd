<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProizvoditelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_proizvoditels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->string('name')->nullable();
            $table->string('frame')->nullable();
            $table->string('facades')->nullable();
            $table->string('length')->nullable();
            $table->string('height')->nullable();
            $table->string('price')->nullable();
            $table->string('tabletop')->nullable();
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
        Schema::dropIfExists('product_proizvoditels');
    }
}
