<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use DB;
use Response;
use DateTime;
use Carbon\Carbon;

class StudentController extends Controller
{
	public function index(Request $request)
    {		
		if(Auth::check()) {
			$students = User::where('role', '=', 'student')->get();
			return View('pages.student.lists', compact('students'));
		}else{
			return Redirect::to('/admin');
		}
	}
	
	public function deleteStudent(Request $request,$id)
    {
		User::where('id', '=', $id)->delete();
		
		return redirect('/admin/students');
	}
	
	public function addNew(Request $request)
	{
		$user = User::where('email', '=', $request->input('student_email'))->first();
		if ($user === null) {
			try {
				$user = new User;
				$user->role = 'student';
				$user->name = $request->input('student_name');
				$user->email = $request->input('student_email');
				$user->password = bcrypt($request->input('student_password'));
				$user->membership = $request->input('membership');
				$user->created_at = Carbon::now();
				$user->save();		
					
				return Response::json(array(
					'success'   =>  'true'
				), 200);
				
			} catch (ModelNotFoundException $exception) {
				return Response::json(array(
					'error'   =>  $exception->getMessage()
				), 200);
			}
		}else{
			return Response::json(array(
				'error'   =>  "Email is already exist."
			), 200);
		}
	}
	
	public function getStudentInfo($id)
    {
		$student = User::where('id', $id)->first();
		$student_info = array(
			'name' => $student['name'],
			'email' => $student['email'],
			'membership' => $student['membership'],
		);
		
        return $student_info;
    }
	
	public function updateStudent(Request $request)
	{
		try {
			$user = User::find($request->input('student_id'));
			$user->name = $request->input('student_name');
			$user->email = $request->input('student_email');
			if(!empty($request->input('student_password'))){
				$user->password = bcrypt($request->input('student_password'));
			}
			$user->membership = $request->input('membership');
			$user->updated_at = Carbon::now();
			$user->save();		
				
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