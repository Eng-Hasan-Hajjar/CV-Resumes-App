<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldAttributeLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_attribute_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("nama");
            $table->integer('order');
            $table->boolean("is_active");
            $table->unsignedBigInteger("custom_field_category_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_field_attribute_lines');
    }
}
