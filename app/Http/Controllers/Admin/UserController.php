<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request,App\UserBlog;
use App\UserAssignment;
use App\User,Hash,Response,App\UserRole,App\Language,App\BlogCategory,App\UserBlogCategory;
class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if (Request::isMethod('get')){
			$users = User::orderBy('id','desc')->paginate(50);
			return view('admin.users.list',array('users'=>$users));
		}
		$idUser = Request::input('data');
		User::destroy($idUser);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Request::isMethod('get')){
			$roles = UserRole::orderBy('id','desc')->get();
			return view('admin.users.create',array('roles'=>$roles));
		}
		
		parse_str(Request::input('data'));

		
		$exist_email = User::where('email',$email)->first();
		if($exist_email){
			return 'exist_email';
		}

		$user = new User;
		$user->name = $name;
		$user->password = Hash::make($password);
		$user->email = $email;
		$user->role = $role;
		$user->save();
		return redirect('admin/users/add-new')->with('createOk','Create new user successful');

	}

	
	public function edit($id)
	{
		if (Request::isMethod('get')){	
			$roles = UserRole::orderBy('id','desc')->get();
			$info  = User::find($id);
			$cats  = BlogCategory::where('lang_code',$info->userblog->lang_code)->get();
			$langs = Language::all();
			return view('admin.users.edit',array('cats'=>$cats,'langs'=>$langs,'info'=>$info,'roles'=>$roles));
		}

		// POST

		parse_str(Request::input('data'));
		$category_save = implode(',', $category);
		$u = User::find($id);
		$u->name = $name;
		$u->address = $address;
		$u->zipcode = $zipcode;
		$u->city = $city;
		$u->phone = $phone;
		$u->cpr = $cpr;
		$u->role = $role;
		$u->account_number = $account_number;
		if($password!=null || $password!=''){
			$u->password = Hash::make($password);
		}
		$u->save();

		$info_update = array(
			'blogname'=>$blogname,
			'domain'=>$blogurl,
			'lang_code'=>$lang_code,
			'blog_categories'=>$category_save,
			);
		UserBlog::where('user_id',$id)->update($info_update);
		
	}

	public function user_assignments(){
		if(Request::isMethod('get')){
			$list = UserAssignment::orderBy('id','desc')->paginate(50);
			// return $list;
			return view('admin.users.user-assignments',['list'=>$list]);
		}

		/// Method POST via Ajax - Action
		$id = Request::input('data');
		$action = Request::input('action');
		if($action==1){  /// assign
			foreach ($id as $key => $value) {
				$ua = UserAssignment::find($value);
				$ua->status = 1; // set Pending
				$ua->save();
			}
		}
		elseif($action==2){  // delete this user's assignment
			foreach ($id as $key => $value) {
				UserAssignment::destroy($value);
			}
		}
		
	}

	public function user_assignment_detail($id){
		if(Request::isMethod('get')){
			$info = UserAssignment::find($id);
			return view('admin.users.user-assignment-detail',['info'=>$info]);
		}

		
	}
	

	public function aprrove_assignment($id){
		$u = UserAssignment::find($id);
		$u->status = 3;
		$u->save();
		return redirect('admin/user-assignments')->with('ok','Approved');
	}

	public function reject_assignment($id){
		if(Request::isMethod('get')){
			return view('admin.users.user-assignment-reject');
		}

		/// POST - save reject
		$u = UserAssignment::find($id);
		$u->status = 4;
		$u->reason = Request::input('reason');
		$u->save();
		return redirect('admin/user-assignments')->with('ok','Rejected');
	}

	public function complete_assignment($id){
		$u = UserAssignment::find($id);
		$u->status = 5;
		$u->save();
		return redirect('admin/user-assignments')->with('ok','Completed');
	}
}
