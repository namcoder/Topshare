<?php namespace App\Http\Controllers;
use Request,App\BlogCategory,App\User,App\UserBlog,Hash,Auth,App\Language,App\UserBlogCategory;
class HomeController extends Controller {


	public function __construct()
	{
		//$this->middleware('auth');
		
	}

	public function set_locale()
	{
		$lang = Request::input('locale');
		\Session::put('locale', $lang);
	}
	
	public function index()
	{
		
		return view('frontend.home');
	}
	
	public function login()
	{
		if (Request::isMethod('get')){
			return view('frontend.login');
		}
		parse_str(Request::input('data'));

		if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            if(Auth::user()->role==1){
            	Auth::logout();
            	return 'false';
            }
            else{
            	return 'ok';
            }
        }
        else{
        	return 'false';
        }

	}
	
}
