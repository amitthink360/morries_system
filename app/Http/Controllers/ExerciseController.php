<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;
use App\User;
use App\Exercise;
use App\Questions;
use App\Types;
use App\StudentExercise;
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
	
	public function addTest(Request $request)
	{
		try {
			
			$uid = Uuid::generate()->string;
			
			$exercise = new StudentExercise;
			$exercise->uid = $uid;
			$exercise->user_id = Auth::user()->id;
			$exercise->exercise_id = $request->input('exercise_id');
			$exercise->timing = $request->input('timing');
			$exercise->exercise_time = $request->input('exercise_time');
			$exercise->scored = $request->input('scored');
			$exercise->created_at = Carbon::now();
			$exercise->save();		
				
			return Response::json(array(
				'success'   =>  'true',
				'uid'   =>  $uid,
			), 200);
			
		} catch (ModelNotFoundException $exception) {
			return Response::json(array(
				'error'   =>  $exception->getMessage()
			), 200);
		}
	}
	
	public function startExercise(Request $request,$uuid)
    {		
		if(Auth::check() && Auth::user()->role == "student") {
			$testinfo = StudentExercise::where("uid",$uuid)->first();
			$question = Questions::where("exercise_id",$testinfo->exercise_id)->first();
			
			return View('pages.exercise.startexercise', compact('testinfo','question'));
		}else{
			return Redirect::to('/');
		}
	}
	
	public function checkQuestionAnswer(Request $request)
    {
		$exercise_id = $request->input('exercise_id');
		$question_id = $request->input('question_id');
		$answer = $request->input('student_anwser');
		
		$question = Questions::where('id', $question_id)->where('exercise_id', $exercise_id)->first();
		
		if($this->removeSpecial($question->answer) == $this->removeSpecial($answer)){
			$nextQuestion = Questions::where('id', '>', $question_id)->first();
			return Response::json(array(
				'success'   =>  'true',
				'nextquestion'   =>  $nextQuestion
			), 200);
		}else{
			$aa = 0;
			$answer_hint = array();
			$uquestions = explode(" ",$answer);
			foreach(explode(" ",$question->answer) as $useranwser){
				
				$qqqq = mb_strlen($useranwser);
				$uanswers = $uquestions[$aa];
				//echo"<pre/>";print_r($useranwser);
				for ($k = 0; $k < $qqqq; $k++) 
				{					
					$char = mb_substr($useranwser, $k, 1);
					$qchar = mb_substr($uanswers, $k, 1);
					
					if(strlen($useranwser) > strlen($uanswers)){
						if($char !== $qchar){
							$answer_hint[] = "<span style='color:green;'>".substr_replace( $uanswers, "<span style='color:red;'>_</span>", $k, 0 )."</span>";
							break;
						}
					}elseif(strlen($useranwser) < strlen($uanswers)){
						if($useranwser !== $uanswers){
							$answer_hint[] = "<span style='color:red;'>".substr_replace( $uanswers, $qchar, $k, 1 )."</span>";
							break;
						}
					}elseif($this->removeSpecial($uanswers) !== $this->removeSpecial($useranwser)){
						$answer_hint[] = "<span style='color:red;'>".substr_replace( $uanswers, $qchar, $k, 1 )."</span>";
						break;
					}elseif($this->removeSpecial($qchar) == $this->removeSpecial($char)){
						$answer_hint[] = "<span style='color:green;'>".substr_replace( $uanswers, $qchar, $k, 1 )."</span>";
						break;
					}else{
						$answer_hint[] = "<span style='color:red;'>".substr_replace( $uanswers, $qchar, $k, 1 )."</span>";
						break;
					}
				}
				
				$aa++;
			}
			
			return Response::json(array(
				'error'   =>  'true',
				'msg'   =>  implode(" ",$answer_hint),
				'ss'   =>  $uanswers
			), 200);
			//echo"<pre/>";print_r($var_arr); die;
		}
    }
	
	public function Progress(Request $request)
    {		
		if(Auth::check() && Auth::user()->role == "student") {
			return View('pages.exercise.progress');
		}else{
			return Redirect::to('/');
		}
	}
	
	public function removeSpecial($string){
		$string = str_replace(array('[\', \']'), '', $string);
		$string = preg_replace('/\[.*\]/U', '', $string);
		$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
		$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '', $string);
		return strtolower(trim($string, ''));
	}
}	