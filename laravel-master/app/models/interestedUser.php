<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class interestedUser extends Model
{
    public function events() {
    	return $this->hasOne('App\models\Events', 'id', 'event_id');

    }
}
