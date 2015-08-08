<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User,Hash,Auth,App\BlogCategory,Request,App\Language,App\BlogCategoryLang;
class AdminController extends Controller {

	
	public function index()
	{
		$users = User::count();
		$cats = BlogCategory::count();
		return view('admin.dashboard',array('num_users'=>$users,'cats'=>$cats));
	}

	

	public function login()
	{
		$email = Request::input('email');
		$password = Request::input('password');
		if (Request::isMethod('get'))
		{
		    return view('admin.login');
		}

		//// POST request
		if (Auth::attempt(['email' => $email, 'password' => $password,'role'=>1]))
        {
            return redirect('admin');
        }
        else{
        	return redirect('admin-login')->with('error','Login failed. Please try again');
        }
		


	}

	public function logout()
	{
		Auth::logout();
		return redirect('admin-login');
	}


	

	public function profile()
	{
		if (Request::isMethod('get')){
			return view('admin.profile');
		}

		parse_str(Request::input('data'));
		$u = User::find(Auth::user()->id);
		$u->name = $name;
		if($password!=null || $password!=''){
			$u->password = Hash::make($password);
		}
		$u->save();
		

	}

}
