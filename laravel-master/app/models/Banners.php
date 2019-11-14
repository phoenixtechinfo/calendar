<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banners extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
