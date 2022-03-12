<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exercise;
use App\Types;

class Questions extends Model
{
    protected $table = "exercise_questions";
	
	public function questionTypes()
    {
        return $this->hasOne(Types::class,'id');
    }
}
