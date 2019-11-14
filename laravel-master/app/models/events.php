<?php

namespace App\models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
