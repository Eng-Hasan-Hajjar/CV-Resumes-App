<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("custom_field_attribute_lines", function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table("custom_field_categories", function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table("custom_field_records", function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table("custom_field_record_attribute_line_values", function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table("cvs", function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table("profiles", function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table("profile_attribute_lines", function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("custom_field_attribute_lines", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table("custom_field_categories", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table("custom_field_records", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table("custom_field_record_attribute_line_values", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table("cvs", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table("profiles", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table("profile_attribute_lines", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
