<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = ["first_name", "last_name", "profession", "photo", "address", "email", "birth_date", "phone", "gender", "user_id"];

    public function User()
    {
        return $this->belongsTo('App\Profile');
    }

    public function profileAttributeLine()
    {
        return $this->hasMany('App\ProfileAttributeLine')->orderBy("order");
    }

    public function Cvs()
    {
        return $this->hasMany("App\Cv");
    }
}
