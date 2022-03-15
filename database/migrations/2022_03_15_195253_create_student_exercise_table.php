<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exercise', function (Blueprint $table) {
            $table->increments('id');
			$table->string('uid'); 
			$table->integer('user_id'); 
			$table->integer('exercise_id'); 
			$table->string('timing');
			$table->string('exercise_time')->nullable();
			$table->string('scored');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_exercise');
    }
}
