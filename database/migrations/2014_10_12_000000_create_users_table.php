<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('extract')->nullable();
            $table->string('active')->default(1);
            $table->string('meshok')->nullable();
            $table->string('login')->nullable();
            $table->string('phone_veryfi_code')->nullable();
            $table->string('company_name')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('role_id')->nullable();
            $table->string('individual_number')->nullable();
            $table->string('watsap_phone')->nullable();
            $table->string('made_in')->nullable();
            $table->string('price_of_metr')->nullable();
            $table->string('saite')->nullable();
            $table->string('show_room')->nullable();
            $table->string('diplom_photo')->nullable();
            $table->string('selfi_photo')->nullable();
            $table->string('logo')->nullable();
            $table->string('password');
            $table->string('forgot_password_code')->nullable();
            $table->string('bag')->nullable();
            $table->string('telegram')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
