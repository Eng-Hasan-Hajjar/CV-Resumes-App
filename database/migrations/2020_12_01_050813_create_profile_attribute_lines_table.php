<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileAttributeLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_attribute_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("value");
            $table->integer("order");
            $table->unsignedBigInteger("profile_id")->nullable();
            $table->unsignedBigInteger("cv_id")->nullable();
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
        Schema::dropIfExists('profile_attribute_lines');
    }
}
