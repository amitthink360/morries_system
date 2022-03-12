<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Exercise;
use App\Questions;
use App\Types;
use DB;
use Response;
use DateTime;
use Carbon\Carbon;

class ExerciseController extends Controller
{
	public function index(Request $request)
    {		
		if(Auth::check() && Auth::user()->role == "admin") {
			$exercises = Exercise::withCount('questions')->get();
			return View('pages.exercise.lists', compact('exercises'));
		}elseif(Auth::check() && Auth::user()->role == "student") {
			$exercises = Exercise::withCount('questions')->get();
			return View('pages.exercise.slists', compact('exercises'));
		}else{
			return Redirect::to('/');
		}
	}
	
	public function showQuestions(Request $request, Exercise $exercise)
    {
		if(Auth::check() && Auth::user()->role == "admin") {
			$questiondata = array();
			$equestions = $exercise->questions()->get();
			$exercise_id = $exercise->id;
			
			foreach($equestions as $question){
				$type = Types::where('id','=', $question->type_id)->first();
				
				$questiondata[] = array(
					'id' => $question->id,
					'type' => $type->name,
					'type_id' => $question->type_id,
					'question' => strip_tags($question->question),
					'answer' => $question->answer,
					'created_at' => $question->created_at
				);
			}
			
			return View('pages.exercise.qlists', compact('questiondata','exercise_id'));
		}else{
			return Redirect::to('/');
		}
    }
	
	public function deleteExercise(Request $request,$id)
    {
		if(Auth::check() && Auth::user()->role == "admin") {
			Exercise::where('id', '=', $id)->delete();
			
			return redirect('/exercise');
		}else{
			return Redirect::to('/');
		}
	}
	
	public function addNew(Request $request)
	{
		try {
			$exercise = new Exercise;
			$exercise->name = $request->input('set_name');
			$exercise->created_at = Carbon::now();
			$exercise->save();		
				
			return Response::json(array(
				'success'   =>  'true'
			), 200);
			
		} catch (ModelNotFoundException $exception) {
			return Response::json(array(
				'error'   =>  $exception->getMessage()
			), 200);
		}
	}
	
	public function getExerciseInfo($id)
    {
		$exercise = Exercise::where('id', $id)->first();
		$exercise_info = array(
			'name' => $exercise['name']
		);
		
        return $exercise_info;
    }
	
	public function updateExercise(Request $request)
	{
		try {
			$exercise = Exercise::find($request->input('exercise_id'));
			$exercise->name = $request->input('set_name');
			$exercise->updated_at = Carbon::now();
			$exercise->save();		
				
			return Response::json(array(
				'success'   =>  'true'
			), 200);
			
		} catch (ModelNotFoundException $exception) {
			return Response::json(array(
				'error'   =>  $exception->getMessage()
			), 200);
		}
	}	
	
	public function addNewQuestion(Request $request)
	{
		$question_type = $request->input('question_type');
		$exercise_id = $request->input('exercise_id');
		
		$question = new Questions;
		$question->exercise_id = $request->input('exercise_id');
		$question->type_id = $request->input('question_type');
		
		if($question_type == 1){
			$question->question = $request->input('question');				
			$question->answer = $request->input('answer');		
		}elseif($question_type == 2){
			$random_question = explode(" ", $request->input('answer'));
			shuffle($random_question);
			$question->question = implode(" ",$random_question);				
			$question->answer = $request->input('answer');	
						
		}elseif($question_type == 3){
			if($file = $request->file('mp3_file')){  
				$name = $file->getClientOriginalName();  
				$file->move('images',$name); 
				$question->mp3_file = $name;
			}

			$question->question = $request->input('question');				
			$question->answer = $request->input('answer');	
		}
		
		
		$question->created_at = Carbon::now();
		$question->save();		
			
		return Redirect::to('/exercise/view/'.$exercise_id);
	}
	
	public function getQuestionInfo($id)
    {
		$question = Questions::where('id', $id)->first();
		$question_info = array(
			'question_id' => $question['id'],
			'type_id' => $question['type_id'],
			'mp3_file' => $question['mp3_file'],
			'question' => $question['question'],
			'answer' => $question['answer']
		);
		
        return $question_info;
    }
	
	public function updateQuestion(Request $request)
	{
		$question_type = $request->input('question_type');
		$exercise_id = $request->input('exercise_id');
		
		$question = Questions::find($request->input('question_id'));
		$question->exercise_id = $request->input('exercise_id');
		$question->type_id = $request->input('question_type');
		
		if($question_type == 1){
			$question->question = $request->input('question');				
			$question->answer = $request->input('answer');		
		}elseif($question_type == 2){
			$random_question = explode(" ", $request->input('answer'));
			shuffle($random_question);
			$question->question = implode(" ",$random_question);				
			$question->answer = $request->input('answer');	
						
		}elseif($question_type == 3){
			if($file = $request->file('mp3_file')){  
				$name = $file->getClientOriginalName();  
				$file->move('images',$name); 
				$question->mp3_file = $name;
			}

			$question->question = $request->input('question');				
			$question->answer = $request->input('answer');	
		}
		
		
		$question->updated_at = Carbon::now();
		$question->save();		
			
		return Redirect::to('/exercise/view/'.$exercise_id);
	}	
	
	public function deleteQuestion(Request $request,$exercise_id,$id)
    {
		if(Auth::check() && Auth::user()->role == "admin") {
			Questions::where('id', '=', $id)->delete();
			
			return Redirect::to('/exercise/view/'.$exercise_id);
		}else{
			return Redirect::to('/');
		}
	}	
}	