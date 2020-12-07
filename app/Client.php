<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "client";
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email'];

    public function Betstartlog()
    {
        return $this->hasMany('App\Betstartlog', 'userid');
    }
    public function Betendlog()
    {
        return $this->hasMany('App\Betstartlog', 'userid');
    }

}
