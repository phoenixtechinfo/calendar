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
    public function color()
    {
        return $this->hasOne('App\models\Colors', 'id', 'color_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Categories::class);
    }
}
