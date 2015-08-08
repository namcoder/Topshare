<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request,App\Language,App\BlogCategory;

class BlogCategoryController extends Controller {

	public function index()
	{
		if (Request::isMethod('get')){
			$cats = BlogCategory::all();
			return view('admin.blogcategories.index',array('cats'=>$cats));
		}

		/// DELETE CATEGORY
		if (Request::isMethod('delete')){
			$data = Request::input('data');
			BlogCategory::destroy($data);
			return;
		}
		
	}

	public function create(){
		if (Request::isMethod('get')){
			$lang = Language::all();
			return view('admin.blogcategories.create',array('lang'=>$lang));
		}

		// SAVE
		$data = Request::all();
		$c = new BlogCategory;
		$c->name = $data['name'];
		$c->lang_code = $data['lang_code'];
		$c->save();
		return redirect('admin/blog-categories')->with('ok','Add new successful');
	}

	public function edit($id){
		if (Request::isMethod('get')){
			$lang = Language::all();
			$info = BlogCategory::find($id);
			return view('admin.blogcategories.edit',array('lang'=>$lang,'info'=>$info));
		}


		$data = Request::all();
		$c = BlogCategory::find($id);
		$c->name = $data['name'];
		$c->lang_code = $data['lang_code'];
		$c->save();
		return redirect('admin/blog-categories')->with('ok','Saved');
	}

	
}
