<?php

namespace App;
use App\Questions;
use App\Types;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = "exercise_set";
	
	public function questions()
    {
        return $this->hasMany(Questions::class);
    }
}
