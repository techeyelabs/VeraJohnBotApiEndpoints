<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositWithdrawHistory extends Model
{
    protected $table = "deposit-withdraw-history";
    protected $primaryKey = 'id';

    public function get_deposit_withdraw_history()
    {
        return $this->belongsTo('App\Client', 'id');
    }
}
