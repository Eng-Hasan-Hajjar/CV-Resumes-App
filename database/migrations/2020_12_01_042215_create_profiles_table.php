<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("first_name");
            $table->string("last_name");
            $table->string("profession");
            $table->text("photo")->nullable();
            $table->text("address")->nullable();
            $table->string("email")->nullable();
            $table->date("birth_date")->nullable();
            $table->string("phone")->nullable();
            $table->integer("gender")->nullable();
            $table->unsignedInteger("user_id");
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
        Schema::dropIfExists('profiles');
    }
}
