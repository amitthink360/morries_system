<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_questions', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('exercise_id'); 
			$table->integer('type_id'); 
			$table->longText('mp3_file')->nullable();
			$table->longText('question');
			$table->longText('answer');
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
        Schema::dropIfExists('exercise_questions');
    }
}
