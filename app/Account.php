<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = "accounts";
    protected $primaryKey = 'id';

    public function get_accounts()
    {
        return $this->belongsTo('App\Client', 'id');
    }
}
