<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DashboardController extends Controller
{
	public function index() {
		if(Auth::check()) {
			return view('dashboard');
		}else{
			return Redirect::to('/admin');
		}
    }
}
