<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Exercise;
use DB;
use Response;
use DateTime;
use Carbon\Carbon;

class ExerciseController extends Controller
{
	public function index(Request $request)
    {		
		if(Auth::check()) {
			$exercises = Exercise::all();
			return View('pages.exercise.lists', compact('exercises'));
		}else{
			return Redirect::to('/admin');
		}
	}
	
	public function deleteExercise(Request $request,$id)
    {
		Exercise::where('id', '=', $id)->delete();
		
		return redirect('/admin/exercise');
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
}	