<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bethistory extends Model
{
    protected $table = "bet-history";
    protected $primaryKey = 'id';

    public function get_bet_history()
    {
        return $this->belongsTo('App\Client', 'id');
    }
   
}
