<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldRecordAttributeLineValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_record_attribute_line_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text("value");
            $table->unsignedBigInteger("custom_field_record_id");
            $table->unsignedBigInteger("custom_field_attribute_line_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_field_record_attribute_line_values');
    }
}
