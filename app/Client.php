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
    public function Bethistory()
    {
        return $this->hasMany('App\Bethistory', 'user_id');
    }
    public function DepositWithdrawhistory()
    {
        return $this->hasMany('App\DepositWithdrawHistory', 'user_id');
    }
    public function account()
    {
        return $this->hasMany('App\Account', 'user_id');
    }
    public function groups()
    {
        return $this->hasMany('App\Groups', 'users');
    }
    public function individual_list()
    {
        return $this->hasOne('App\Individual_list', 'user_id');
    }

}
