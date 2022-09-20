<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomFieldAttributeLine extends Model
{
    use SoftDeletes;

    protected $fillable = ["nama", "order", "is_active", "custom_field_category_id"];

    public function CustomFieldCategory()
    {
        return $this->belongsTo("App\CustomFieldCategory");
    }

    public function CustomFieldAttributeLineValues()
    {
        return $this->hasMany("App\CustomFieldAttributeLineValue");
    }
}
