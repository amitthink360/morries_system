<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use DB;
use Carbon\Carbon;
use Response;

class UsersController extends Controller
{
	public function index(Request $request)
    {
		if(Auth::check() && Auth::user()->role == "admin") {
			return Redirect::to('/students');
		}else{
			return View('pages.user-pages.login');
		}
	}
	
	public function register(Request $request)
    {	
		$success = "";
		$error = "";
		$user = User::where('email', '=', $request->input('email'))->first();
		if ($user === null) {
			try {
				$user = new User;
				$user->role = 'User';
				$user->name = $request->input('fullname');
				$user->email = $request->input('email');
				$user->password = bcrypt($request->input('password'));
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
	
	public function setPassword(Request $request)
    {		
		$user = Auth::user();
		
		if(Auth::check() && $user->status == 0){
			return View('setpassword');
		}elseif(Auth::check()) {
			return Redirect::to('/students');
		}
    }
	
	public function createPassword(Request $request)
	{
		$user = Auth::user();
		
		$user = User::find($user->id);
		$user->password = bcrypt($request->input('password'));
		$user->status = 1;
		$user->save();
		
		return Redirect::to('/students');
	}
	
	public function doLogin(Request $request)
	{
		$userdata = array(
			'email'     => $request->input('email'),
			'password'  => $request->input('password')
		);
		
		if (Auth::attempt($userdata)) {
			
			$user = Auth::user();
			
			return Response::json(array(
				'success'   =>  'true',
				'role'		=>  Auth::user()->role
			), 200);
		} else {        
			return Response::json(array(
				'success'   =>  'false'
			), 200);
		}
	}
	
	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
	
	public function contactUs(Request $request)
    {
		return View('pages.contactus');
	}
}
