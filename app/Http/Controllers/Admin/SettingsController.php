<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Language,App\Setting;
class SettingsController extends Controller {

	
	public function index()
	{
		if(Request::isMethod('get')){
			$lang = Language::all();
			$settings = Setting::all();
			return view('admin.settings.index',array('langs'=>$lang,'settings'=>$settings));
		}

		/// POST
		$data = Request::all();
		$s = new Setting;
		$s->name = $data['name'];
		$s->lang_code = $data['lang_code'];
		$s->value = $data['value'];
		$s->type = 'var';
		$s->save();
		return redirect('admin/settings');
	}



	public function ajax_variable()
	{
		$data = Request::all();
		$s = Setting::find($data['pk']);

		// change name and value variable
		if($data['name']=='name'){
			$s->name = $data['value'];
		}
		elseif($data['name']=='value'){
			$s->value = $data['value'];
		}
		/// change variable language
		else{
			$s->lang_code = $data['lang_code'];
		}
		$s->save();
	}

	public function ajax_delete_variable()
	{
		$id = Request::input('data');
		Setting::destroy($id);
	}


}
