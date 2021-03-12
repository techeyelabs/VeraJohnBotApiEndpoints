<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = "groups";
    protected $primaryKey = 'id';

    public function setDaysAttribute($value)
    {
        $this->attributes['days'] = json_encode($value);
    }

    public function getDaysAttribute($value)
    {
        return $this->attributes['days'] = json_decode($value);
    }
}
