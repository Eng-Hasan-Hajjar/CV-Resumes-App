<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileAttributeLine extends Model
{
    use SoftDeletes;

    protected $fillable = ["name", "value", "order", "profile_id", "cv_id"];

    public function Profile()
    {
        return $this->belongsTo("App\Profile");
    }
    public function CV()
    {
        return $this->belongsTo("App\Cv");
    }
}
