<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;
    public function events()
    {
        return $this->belongsToMany(events::class);
    }
    public function user()
    {
        return $this->belongsToMany(App\User::class, 'categories_users');
    }
}
