<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomFieldRecord extends Model
{
    use SoftDeletes;

    protected $fillable = ["order", "custom_field_category_id"];

    public function CustomFieldCategory()
    {
        return $this->belongsTo('App\CustomFieldCategory');
    }

    public function CustomFieldRecordAttributeLineValues()
    {
        return $this->hasMany("App\CustomFieldRecordAttributeLineValue")->orderBy("custom_field_attribute_line_id");
    }
}
