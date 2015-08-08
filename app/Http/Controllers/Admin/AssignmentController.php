<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request,App\BlogCategory,App\Assignment,App\Language,App\Setting;
use App\BlogCategoryLang,App\AssignmentCategory,App\UserAssignment;
class AssignmentController extends Controller {

	
	public function index()
	{
		if(Request::isMethod('get')){
			/// if select filter
			if(Request::input('status')){
				$status = Request::input('status');
				if($status=='open'){
					$lists = Assignment::where('status',1)->orderBy('id','desc')->paginate(50);
				}
				elseif ($status=='closed') {
					$lists = Assignment::where('status',0)->orderBy('id','desc')->paginate(50);
				}
				else{
					$lists = Assignment::orderBy('id','desc')->paginate(50);
				}
			}
			else{
				/// default - when load the page, only get Open 
				$lists = Assignment::where('status',1)->orderBy('id','desc')->paginate(50);
			}
			return view('admin.assignment.list',array('lists'=>$lists));
		}

		/// Ajax Delete
		$id = Request::input('data');

		/// find user assignment applied this assignment
		$html_exist = '<ul>';
		$e = array();
		foreach ($id as $key => $value) {
			$ua = UserAssignment::where('assignment_id',$value)->count();
			if($ua){
				$a = Assignment::find($value);
				$e[] = $value;
				$html_exist .= '<li>'.$a->customer_name.'</li>';
			}
			
		}
		$html_exist .= '</ul>';

		if(count($e)){
			return array('error'=>'user_applied','name'=>$html_exist);
		}
		Assignment::destroy($id);
			return array('error'=>'no','name'=>'');

	}

	public function create()
	{
		if(Request::isMethod('get')){
			$customerAPI =  json_decode($this->curlGet());
			$langs = Language::all();
			return view('admin.assignment.create',array('langs'=>$langs,'customerAPI'=>$customerAPI));
		}

		/*
			POST link is link id in riversystem DB, bf_links
		*/
		$data = Request::all();

		$release_date = $data['release_date'];
		
		$customer = $data['customer'];

		$customerName = $data['customerName'];

		$max_blogger = $data['max_blogger'];

		$lang_code = $data['lang_code'];

		$keyword = $data['keyword'];

		$minimum_wordcount = $data['minimum_wordcount'];
		
		if(isset($data['img'])){
			$img = $data['img'];
		}
		else{
			$img = null;
		}
		

		$categories = implode(',', $data['category']);

		if(isset($data['link'])){
			$link = $data['link'];
		}
		else{
			$link = null;
		}
		
		if(isset($data['anchor_text'])){
			$anchor_text = $data['anchor_text'];
		}
		
		if($link){
			foreach ($link as $key => $value) {
				$listUploadedImg_Link[$key]['img'] = $img[$key];
				$listUploadedImg_Link[$key]['link'] = $link[$key];
				$listUploadedImg_Link[$key]['anchor_text'] = $anchor_text[$key];
			}
			$imgLink_store = json_encode($listUploadedImg_Link);
		}
		else{
			$imgLink_store = null;
		}
		
		
		
		foreach ($release_date as $key => $release_date_val) {
			$a = new Assignment;
			$a->customer_id = $customer;
			$a->customer_name = $customerName;
			$a->keyword = $keyword;
			$a->minimum_wordcount = $minimum_wordcount;
			$a->max_blogger = $max_blogger;
			$a->blog_categories = $categories;
			$a->lang_code = $lang_code;
			$a->img_link = $imgLink_store;
			$a->release_date = $release_date_val;
			$a->save();
		}
		
		
		return redirect('admin/assignments')->with('ok','Create Assignment Successful');

	}
	
	public function edit($id){
		if(Request::isMethod('get')){
			$customerAPI =  json_decode($this->curlGet());
			$in = Assignment::find($id);
			$cats = BlogCategory::where('lang_code',$in->lang_code)->get();
			$langs = Language::all();
			return view('admin.assignment.edit',array('langs'=>$langs,'cats'=>$cats,'in'=>$in,'customerAPI'=>$customerAPI));
		}

		/// POST

		$data = Request::all();
		$customer = $data['customer'];
		$release_date = $data['release_date'];

		$customerName = $data['customerName'];

		$max_blogger = $data['max_blogger'];

		$lang_code = $data['lang_code'];

		$keyword = $data['keyword'];

		$minimum_wordcount = $data['minimum_wordcount'];

		if(isset($data['img'])){
			$img = $data['img'];
		}
		else{
			$img = null;
		}

		$categories = implode(',', $data['category']);


		if(isset($data['link'])){
			$link = $data['link'];
		}
		else{
			$link = null;
		}

		if(isset($data['anchor_text'])){
			$anchor_text = $data['anchor_text'];
		}
		
		if($link){
			
			foreach ($link as $key => $value) {
				$listUploadedImg_Link[$key]['img'] = $img[$key];
				$listUploadedImg_Link[$key]['link'] = $link[$key];
				$listUploadedImg_Link[$key]['anchor_text'] = $anchor_text[$key];
			}
			$imgLink_store = json_encode($listUploadedImg_Link);
		}
		else{
			$imgLink_store = null;
		}
		
		
		$a = Assignment::find($id);
		$a->customer_id = $customer;
		$a->customer_name = $customerName;
		$a->keyword = $keyword;
		$a->minimum_wordcount = $minimum_wordcount;
		$a->max_blogger = $max_blogger;
		$a->blog_categories = $categories;
		$a->lang_code = $lang_code;
		$a->img_link = $imgLink_store;
		$a->release_date = $release_date;
		$a->save();
		return redirect('admin/assignments')->with('ok','Edit Successful');
	}



	public function ajaxChangeStatus(){

		/// first is for change userassignment in paymentlist page
		if(Request::input('userAssignment')){
			$val =  Request::input('val');
			$assignID =  Request::input('assignID');
			$a = UserAssignment::find($assignID);
			$a->status = $val;
			$a->save();
		}
		/// when change all assignment into 1 status in paymetn list page
		elseif(Request::input('complete_all_assignment')){
			$user_id = Request::input('data');
			foreach ($user_id as $u) {
				UserAssignment::where('user_id',$u)->update(array('status'=>5));
			}
			

		}
		else{  /// for assignment page
			$val =  Request::input('val');
			$assignID =  Request::input('assignID');
			$a = Assignment::find($assignID);
			$a->status = $val;
			$a->save();
		}
		
	}

	public function ajaxChangeStatus_UserAssignment(){
		$val =  Request::input('val');
		$assignID =  Request::input('assignID');
		$a = UserAssignment::find($assignID);
		$a->status = $val;
		$a->save();
	}

	public function curlGet(){
		$url = 'http://api.riversystem.dk/getCustomer?key=OLE8hx3BCwRisEW1QYRhijn84izZyw';
   		$ch = curl_init();
   		curl_setopt($ch, CURLOPT_URL, $url);
   		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   		curl_setopt($ch, CURLOPT_TIMEOUT, 400);
   		$data = curl_exec($ch);
   		curl_close($ch);
   		return $data;
   }

   public function ajax_get_setting_variable_by_customer_language(){
   		$lang_code = Request::input('country_iso');
	   	return Setting::where('type','var')->get();
   }



   ///  Integration call - List assignments for given customer number (riveronline internal system call)
   public function get_customer_assignment(){
	   	if(Request::input('key') && Request::input('key')=='8855a5gp2C6577'){

	   		$customernr = Request::input('customernr');
	   		$list = Assignment::where('customer_id',$customernr)->get();
	   		if($list->count()){

	   			foreach ($list as $key => $value) {
	   				$result[$key]['created_at'] = $value->created_at;
	   				$result[$key]['minimum_wordcount'] = $value->minimum_wordcount;
	   				$result[$key]['img_link'] = json_decode($value->img_link);
	   				$result[$key]['status'] = $value->status;
	   				$result[$key]['total_user'] = UserAssignment::where('assignment_id',$value->id)->count();
	   			}

	   			return $result;

	   		}
	   		else{
	   			return 'Assignments for this customer does not exist';
	   		}

	   	}
	   	else{
	   		return 'You do not have permission to view this page';
	   	}
   }

   ///  Integration call - List assignments for given customer number (riveronline internal system call)
   public function get_customer_assignment_status(){
	   	if(Request::input('key') && Request::input('key')=='8855a5gp2C6577'){

	   		 $a = Assignment::groupBy('customer_id')->get();
	   		 foreach ($a as $key => $value) {
	   		 	$cusID = $value->customer_id;
	   		 	$customer[$key]['customer_id'] = $cusID;
	   		 	$customer[$key]['open'] = Assignment::where('customer_id',$cusID)->where('status',1)->count();
	   		 	$customer[$key]['closed'] = Assignment::where('customer_id',$cusID)->where('status',0)->count();

	   		 }
	   		return $customer;
	   	}
	   	else{
	   		return 'You do not have permission to view this page';
	   	}
   }



   /// create assignment without login
   public function quick_create_assignment(){
	   	if(Request::isMethod('get')){
	   		if(Request::input('key') && Request::input('key')=='8855a5gp2C6577'){
	   			$customerAPI =  json_decode($this->curlGet());
	   			$langs = Language::all();
	   			return view('admin.assignment.quick-create',array('langs'=>$langs,'customerAPI'=>$customerAPI));
	   		}
	   		else{
	   			return 'You do not have permission to view this page';
	   		}
	   		
	   	}

	   	/*
	   		POST link is link id in riversystem DB, bf_links
	   	*/

	   	$data = Request::all();

	   	$customer = $data['customer'];
		
		$release_date = $data['release_date'];

	   	$customerName = $data['customerName'];

	   	$max_blogger = $data['max_blogger'];

	   	$lang_code = $data['lang_code'];

	   	$keyword = $data['keyword'];

	   	$minimum_wordcount = $data['minimum_wordcount'];
	   	
	   	if(isset($data['img'])){
	   		$img = $data['img'];
	   	}
	   	else{
	   		$img = null;
	   	}
	   	

	   	$categories = implode(',', $data['category']);

	   	if(isset($data['link'])){
	   		$link = $data['link'];
	   	}
	   	else{
	   		$link = null;
	   	}
	   	
	   	if(isset($data['anchor_text'])){
	   		$anchor_text = $data['anchor_text'];
	   	}
	   	
	   	if($link){
	   		foreach ($link as $key => $value) {
	   			$listUploadedImg_Link[$key]['img'] = $img[$key];
	   			$listUploadedImg_Link[$key]['link'] = $link[$key];
	   			$listUploadedImg_Link[$key]['anchor_text'] = $anchor_text[$key];
	   		}
	   		$imgLink_store = json_encode($listUploadedImg_Link);
	   	}
	   	else{
	   		$imgLink_store = null;
	   	}
	   	
	   	
	   	
		foreach ($release_date as $key => $release_date_val) {
			$a = new Assignment;
			$a->customer_id = $customer;
			$a->customer_name = $customerName;
			$a->keyword = $keyword;
			$a->minimum_wordcount = $minimum_wordcount;
			$a->max_blogger = $max_blogger;
			$a->blog_categories = $categories;
			$a->lang_code = $lang_code;
			$a->img_link = $imgLink_store;
			$a->release_date = $release_date_val;
			$a->save();
	   	}
	   	
	   	
	   	return redirect('admin/quick-create-assignment?key=8855a5gp2C6577')->with('ok','Create Assignment Successful');
   }




}
