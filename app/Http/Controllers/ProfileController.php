<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request,App\BlogCategory,App\User,App\UserBlog,Hash,Auth,Session,App\Setting;
use App\Language,Mail,App\Assignment,App\UserBlogCategory,DB,App\UserAssignment;
class ProfileController extends Controller {


	public function __construct(){
		$this->minute_to_report_assignment = Setting::where('name','minute_to_report_assignment')->first()->value;	
	}

	public function index()
	{
		/// get list user's assignment by status, then echo number of assignment status in view
		$userAssignment = UserAssignment::where('user_id',Auth::user()->id)->get(array('status'));
		
		// if user has apply assignment
		if($userAssignment->count()){
			foreach ($userAssignment as $key => $value) {
				if($value->status==0){
					$status['applied'][] = $value->status;
				}
				elseif($value->status==1){
					$status['pending'][] = $value->status;
				}
				elseif($value->status==2){
					$status['written'][] = $value->status;
				}
				elseif($value->status==3){
					$status['approved'][] = $value->status;
				}
				elseif($value->status==4){
					$status['rejected'][] = $value->status;
				}
				elseif($value->status==5){
					$status['complete'][] = $value->status;
				}
			}
		}
		/// if no 
		else{
			$status = null;
		}
		return view('frontend.profile.index',array('status'=>$status));
	}

	public function ajax_get_categories(){
		$lang_code = Request::input('lang_code');
		$cats = BlogCategory::where('lang_code',$lang_code)->get();
		$html = '';
		foreach ($cats as $key => $value) {
			$html .= '<div class="col-sm-5">';
			$html .= '<label class="control-label">';
			$html .= '<input type="checkbox" class="category" name="category[]" value="'.$value['id'].'">'.$value['name'];
			$html .= '</label>';
			$html .= '</div>';
		}
		return $html;
	}

	public function signup()
	{
		if (Request::isMethod('get')){
			$lang = Language::all();
			return view('frontend.signup',array('langs'=>$lang));
		}

		///POST
		parse_str(Request::input('data'));
		$user_exist = User::where('email',$email)->count();
		if($user_exist){
			return 'email_exist';
		}
		else{
			$newUser = new User;
			$newUser->name = $name;
			$newUser->email = $email;
			$newUser->password = Hash::make($password);
			$newUser->role = 3;
			$newUser->address = $address;
			$newUser->city = $city;
			$newUser->zipcode = $zipcode;
			$newUser->phone = $phone;
			$newUser->cpr = $cpr;
			$newUser->save();

			$userid = $newUser->id;
			$newUserBlog = new UserBlog;
			$newUserBlog->user_id = $userid;
			$newUserBlog->domain_age = $domain_age;
			$newUserBlog->domain_ip = gethostbyname($domain);
			$newUserBlog->blogname = $blogname;
			$newUserBlog->domain = $domain;
			$newUserBlog->blog_categories = $blog_categories;
			$newUserBlog->star = $star;
			$newUserBlog->lang_code = $lang_code;
			$newUserBlog->report_id = $report_id;
			$newUserBlog->save();
			echo 'done';
		}
	}

	public function logout()
	{
		Auth::logout();
		return redirect('/');
	}

	public function myprofile(){
		if (Request::isMethod('get')){
			$langs = Language::all();
			$cats = BlogCategory::where('lang_code',Auth::user()->userblog->lang_code)->get();
			return view('frontend.profile.myprofile',array('cats'=>$cats,'langs'=>$langs));
		}

		parse_str(Request::input('data'));
		$u = User::find(Auth::user()->id);
		$u->name = $name;
		if($password!=null || $password!=''){
			$u->password = Hash::make($password);
		}
		$u->address = $address;
		$u->city = $city;
		$u->zipcode = $zipcode;
		$u->phone = $phone;
		$u->cpr = $cpr;
		$u->save();
		echo 'done';
	}
	

	public function get_completed_blog_info(){
			$completed_data = json_decode($this->curl_backlink(Auth::user()->userblog->report_id));
			//// if done in linkresearchtools
			if($completed_data->report->status=='Done'){
				$num_of_inbound_link = $completed_data->report->pages->data[0][2];
				$num_of_star = round($num_of_inbound_link/5);
				$total_star = $num_of_star + Auth::user()->userblog->star;
				if($total_star>18){
					$star = 18;
				}
				else{
					$star = $total_star;
				}


				/// check if inbound link over - equal 500. email and marking in user list
				if($num_of_inbound_link>=500){

					/// mail to user (under asking Tommy)
					$status_update = 2;

				}
				else{
					$status_update = 1;
				}

				/*
					$status_update = 1 . normal
					$status_update = 2 . over 500
				*/

				$arg_update = array('star'=>$star,'inbound_link'=>$num_of_inbound_link,'status'=>$status_update);

				$update_user_blog = UserBlog::where('user_id',Auth::user()->id)->update($arg_update);
				
			}
			/// else do nothing	
		
	}

	public function forgot_password(){
		if(Request::isMethod('get')){
			return view('frontend.profile.forgot-password');
		}

		/// POST
		parse_str(Request::input('data'));
		$e = User::where('email',$email)->count();
		if(!$e){
			return 'not_exist';
		}
		else{
			ini_set('max_execution_time', 120);
			$rand = str_random(99);
			User::where('email',$email)->update(array('forgot_string'=>$rand));
			/// larave mail function
			/*Mail::send('frontend.email.forgot', array('key' => $rand,'email'=>$email), function($message) use ($email)
			{
				$message->from('admin@topshare.dk', 'TopShare.Dk' );
			    $message->to($email, 'John Smith')->subject('Reset Password from TopShare.Dk');
			});*/

			// hosting mail function
			$msg = view('frontend.email.forgot',array('email'=>$email,'key'=>$rand));
			mail($email,"Reset Password from TopShare.Dk",$msg);
		}
	}
	
	public function reset_password($email,$key){
		$r = User::where('email',$email)->where('forgot_string',$key)->first();
		if($r){
			return view('frontend.profile.enter-new-password');
		}
		else{
			return 'Failed. Email or reset key does not exist';
		}
	}

	public function update_password(){
		parse_str(Request::input('data'));
		$u = User::where('email',$email)->where('forgot_string',$key);
		if($u->first()){
			$u->update(array('password'=>Hash::make($password),'forgot_string'=>null));
		}
		else{
			return 'Failed. Email or reset key does not exist';
		}
	}


	/* 
		ASSIGNMENT
		
		Status ID:
			 - 0 : Applied  // removed
			 - 1 : Pending  // default now
			 - 2 : Written  // (not used now)
			 - 3 : Approved 
			 - 4 : Rejected
			 - 5 : Complete
	*/

	public function open_assignments(){

		if(Request::isMethod('get')){
			
			$lang_code = Auth::user()->userblog->lang_code;
			$star_value = Setting::where('name','star_value')->where('lang_code',$lang_code)->first();
			
			if($star_value){
				$star_value = $star_value->value;
			}
			else{
				$star_value = Setting::where('name','star_value')->where('lang_code','en')->first()->value;
			}
			
			$dateSqlNow = date('m/d/Y',time());
			
			$list_assignments = Assignment::where('lang_code',$lang_code)->where('status',1)->where('release_date','<=',$dateSqlNow)->paginate(50);
			
			$data_final_return = array();

			$extra_star = 0;

			$list_approved_user_assignment = UserAssignment::whereIn('status',array(3,5))->get(array('link'));

			$list_ip = array();

			foreach ($list_approved_user_assignment as  $laua) {
				$domain = strtolower($laua->link);
				$domain =  preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $domain);
				//$domain =  preg_replace('/\//i', '$1', $domain);
				$domain =  explode('/', $domain);
				$list_ip[] = gethostbyname($domain[0]);
			}
			
			if(!in_array(Auth::user()->userblog->domain_ip,$list_ip)){
				$extra_star += 1;
			}

			$list_same_c_class = array();
			foreach ($list_ip as $lip) {
			  if(substr($lip,0,-2) == substr(Auth::user()->userblog->domain_ip,0,-2)){
			    $list_same_c_class[] = $lip;
			  }
			}

			if(count($list_same_c_class)==0){
				$extra_star += 1;
			}

			foreach ($list_assignments as $key => $value) {
				// check time to report of each user_assignment, if one over time, delete it before show new
				$list_user_applied_this_assignment = UserAssignment::where('assignment_id',$value->id)->get();
				
				

				if($list_user_applied_this_assignment->count()){
					$this->check_time_report($list_user_applied_this_assignment);
				}
				/**************************/

				$num_applied = UserAssignment::where('assignment_id',$value->id)->count();
				$max_blogger = $value->max_blogger;

				if($max_blogger > $num_applied){

					$customer_ip = gethostbyname(strtolower($value->customer_domain));
					
					//$is_first_apply = UserAssignment::where('status',3)->where('link','like','%'.$customer_domain.'%')->count();
					
					/*if($is_first_apply==0){
						$extra_star += 1;
					}*/

					$data_final_return[] = $value;
				}

			}
			 // return $extra_star;
			/// array list assignment user have applied
			$userAssignment = UserAssignment::where('user_id',Auth::user()->id)->get(array('assignment_id'))->toArray();
			if(count($userAssignment)){
				foreach ($userAssignment as $key => $value) {
					foreach ($value as $value2) {
						$ku[] = $value2;
					}
				}
			}
			else{
				$ku = array();
			}


			$data_to_view = array(
				'lists'=>$data_final_return,
				'userAssignment'=>$ku,
				'star_value'=>$star_value,
				'extra_star'=>$extra_star,
				);

			return view('frontend.profile.open-assignment',$data_to_view);
		}
	}

	public function assignment_detail($id){
		$info = Assignment::find($id);
		$applied = UserAssignment::where('user_id',Auth::user()->id)->where('assignment_id',$id)->first();

		if(!$info){
			return $this->show_error('This assignment does not exist');
		}
		
		return view('frontend.profile.assignment-detail',array('info'=>$info,'applied'=>$applied));
	}

	public function apply_assignment($id){

		$time_to_repost = Setting::where('name','time_to_repost')->first()->value;

		$info = Assignment::find($id);

		/// check assignment exist
		if(!$info){
			return $this->show_error('This assignment does not exist');
		}


		/// check user already applied this assignment 
		$find = UserAssignment::where('user_id',Auth::user()->id)->where('assignment_id',$id)->count();
		if($find){
			return redirect('profile/my-assignments/'.$id);
		}


		/// check if this assignment is full
		$max_blogger = $info->max_blogger;
		$num_applied = UserAssignment::where('assignment_id',$id)->count();
		if($max_blogger<=$num_applied){
			return $this->show_error('This assignment had full'); 
		}




		$extra_star = 0;

		$list_approved_user_assignment = UserAssignment::where('status',3)->get(array('link'));

		$list_ip = array();
		
		foreach ($list_approved_user_assignment as  $laua) {
			$domain = strtolower($laua->link);
			$domain =  preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $domain);
			$domain =  preg_replace('/\//i', '$1', $domain);
			$list_ip[] = gethostbyname($domain);
		}

		if(!in_array(Auth::user()->userblog->domain_ip,$list_ip)){
			$extra_star += 1;
		}

		$list_same_c_class = array();
		foreach ($list_ip as $lip) {
		  if(substr($lip,0,-2) == substr(Auth::user()->userblog->domain_ip,0,-2)){
		    $list_same_c_class[] = $lip;
		  }
		}

		if(count($list_same_c_class)==0){
			$extra_star += 1;
		}

		

		// everything ok
		$user = new UserAssignment;
		$user->user_id = Auth::user()->id;
		$user->assignment_id = $id;
		$user->time_to_repost = $time_to_repost;
		$user->extra_star = $extra_star;
		$user->minute_to_report_assignment = $this->minute_to_report_assignment;
		$user->save();
		
		return redirect('profile/my-assignments/'.$user->id)->with('ok');
	}

	public function my_assignment_detail($id){
		
		
		$info = UserAssignment::find($id);

		if(!$info){
			return $this->show_error('You did not apply this assignment');
		}

		
		$isTimerOver = $this->check_time_report(null,$id);
		if($isTimerOver){
			 return redirect('profile/my-assignments');
		}

		$data_to_view = array(
			'info'=>$info,
			'time_to_report' =>$this->minute_to_report_assignment
			);
		return view('frontend.profile.my-assignment-detail',$data_to_view);
	}



	public function completed_assignments($id){
		if(Request::isMethod('get')){
			$info = UserAssignment::find($id);
			if(!$info){
				return 'Your Assignment ID is not exist. Please check again';
			}
			$true_apply = UserAssignment::where('user_id',Auth::user()->id)->where('id',$id)->first();
			if(!$true_apply){
				return ' You did not apply this assignment !';
			}
			return view('frontend.profile.completed-assignment',array('info'=>$info));
		}

		
	}

	public function re_completed_assignments($id){
		if(Request::isMethod('get')){
			$info = UserAssignment::find($id);
			if(!$info){
				return 'Your Assignment ID is not exist. Please check again';
			}
			$true_apply = UserAssignment::where('user_id',Auth::user()->id)->where('id',$id)->first();
			if(!$true_apply){
				return ' You did not apply this assignment !';
			}
			return view('frontend.profile.re-completed-assignment',array('info'=>$info));
		}

		/// POST save user link assignment and completed 
		$link = Request::input('link');
		$message = Request::input('message');

		$ua= UserAssignment::find($id);
		if(!$ua){
			return 'Your Assignment ID is not exist. Please check again';
		}
		$true_apply = UserAssignment::where('user_id',Auth::user()->id)->where('id',$id)->first();
		if(!$true_apply){
			return  ' You did not apply this assignment !';
		}
		UserAssignment::where('user_id',Auth::user()->id)->where('id',$id)->update(array('status'=>2,'link'=>$link,'message_update'=>$message));  /// 2 is Written
		return redirect('profile/completed-assignment/'.$id)->with('ok','message');
	}

	public function my_assignments(){
		$list = UserAssignment::where('user_id',Auth::user()->id)->get();
		$list_check_time_report = $this->check_time_report($list);
		$data_to_view = array(
			'list'=>$list_check_time_report,
			'time_to_report'=>$this->minute_to_report_assignment
			);
		return view('frontend.profile.my-assignment',$data_to_view);
	}

	public function curl_backlink($report_id)
	{
		$url = 'http://www.linkresearchtools.com/toolkit/api.php?api_key=b4dd549ec1a18fc3d901409cb54577cb&action=get_data&report_id='.$report_id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 400);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public function check_time_report($list=null,$id_assign_current=null){
		$time_now = time();
		
		//// check a list of assignment
		if($list!=null && count($list)){
			
			$list_ok = array();
			
			foreach ($list as $key => $value) {
				/// not delete if it has status >= 3 (approved)
				if($value->status<3){
					$time_applied = strtotime($value->created_at)+(60*$value->minute_to_report_assignment);
					if($time_now >= $time_applied){
						/// time over
						$ua = UserAssignment::find($value->id);
						$ua->delete();
					}
					else{
						$list_ok[] = $value;
					}
				}
				else{
					$list_ok[] = $value;
				}

			}
			return $list_ok;
		}
		/// check current assignment detail
		if($id_assign_current!=null){
			$current = UserAssignment::find($id_assign_current);
			if($current->status<3){
				$time_applied = strtotime($current->created_at)+(60*$current->minute_to_report_assignment);
				if($time_now >= $time_applied){
						/// time over
						$ua = UserAssignment::find($id_assign_current);
						$ua->delete();
						return true;
				}
			}
		}
				
		
	}

	public function show_error($message){
		return view('frontend.error',array('message'=>$message));
	}

	public function account_number(){
		if (Request::isMethod('get')){
			return view('frontend.profile.account-number');
		}
		parse_str(Request::input('data'));
		User::where('id',Auth::user()->id)->update(array('account_number'=>$bank_account_number));

		
	}

	public function validate_user_assignment_link(){


		$link = Request::input('data');   /// user report link

		$id = Request::input('user_assignment_id');

		$ua= UserAssignment::find($id);  // user assignment
		/// used for (maybe) when user reached of max time to repost, then remove and return not exist to move
		if(!$ua){
			return array('statusCode'=>500,'content'=>'not_exist');
		}

		$current_allow = Setting::where('name','time_to_repost')->first()->value;
		
		/// reached of allow time to repost
		if($ua->time_to_repost==1){
			//// remove current user assignment - return to available
			/// message to user this assignment is Canceled
			$ua->delete();
			return array('statusCode'=>500,'content'=>'You have tried <strong>'.$current_allow.'</strong> times to repost but '.$link.' is not enough of quality. Your assignment is Canceled','overtime'=>'yes');

		}
		$ua->time_to_repost = $ua->time_to_repost-1;
		$ua->save();
		/////*********************************

		$true_apply = UserAssignment::where('user_id',Auth::user()->id)->where('id',$id)->first();
		if(!$true_apply){
			return array('statusCode'=>500,'content'=>'not_exist');
		}


		$domain = strtolower ($link);
		$domain = parse_url($domain, PHP_URL_HOST);
		$domain =  preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $domain);
		$domain =  preg_replace('/\//i', '$1', $domain);

		/*
		*
		*	BEGIN TO VALIDATE AND MINUS TIME TO TRY AND PLUS MORE TIME IF FAILED
		*	If plus more time (minute_to_repost_time) , just get from Setting then plus with: created_at of this UA
		**/

		//// check link domain same with user blog domain
		if($domain!=Auth::user()->userblog->domain){
			$this->plus_time_repost($ua);
			return array('statusCode'=>500,'content'=> '<strong>'.$link.'</strong> is not match with your blog domain you have registered. You have <strong>'.$ua->time_to_repost.'</strong> times to try again');
		}

		/************************************************/
		/// ALL OK
		
		$assignment = Assignment::find($ua->assignment_id);
		$required_link = json_decode($assignment->img_link);
		$required_keyword = explode(',', $assignment->keyword);
		$wordcount = $assignment->minimum_wordcount;

		$curl = curl_init($link);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		$result = curl_exec($curl);
		$headerStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
		if($headerStatusCode=='404'){

			$this->plus_time_repost($ua);
			
			return array('statusCode'=>500,'content'=>'<strong>'.$link.'</strong> does not exist. You have <strong>'.$ua->time_to_repost.'</strong> times to try again');
		}
		elseif($headerStatusCode=='301'){
			return array('statusCode'=>500,'content'=>'<strong>'.$link.'</strong> is redirected, please use direct link. You have <strong>'.$ua->time_to_repost.'</strong> times to try again');
		}
		elseif($headerStatusCode=='200'){
			
			$result_complete_validate = $this->complete_validate_blog($required_link,$link,$required_keyword,$wordcount);
			
			if(isset($result_complete_validate['error']) && $result_complete_validate['error']=='not-enough'){  /// not enough link
				
				$this->plus_time_repost($ua);

				$list_notfollow = '';
				if(count($result_complete_validate['list_notfollow'])){
					$list_notfollow .= '<ul>';
					foreach ($result_complete_validate['list_notfollow'] as  $ln) {
						$list_notfollow .= ' <li><strong> '.$ln.'</strong> rel="nofollow" is not allowed</li> ';
					}
					$list_notfollow .= '</ul>';

				}
				return array('statusCode'=>500,'content'=>'Number of links required: <strong>'.$result_complete_validate['num'].'</strong><br>'.$list_notfollow.'  . You have <strong>'.$ua->time_to_repost.'</strong> times to try again');
			}
			
			if(isset($result_complete_validate['error']) && $result_complete_validate['error']=='not-enough-keyword'){
				$this->plus_time_repost($ua);

				$list_notOK_keyword = '';
				
				if(count($result_complete_validate['list_notOK_keyword'])){
					$list_notOK_keyword .= '<ul>';
					foreach ($result_complete_validate['list_notOK_keyword'] as  $ln) {
						$list_notOK_keyword .= ' <li>Keyword: <strong> '.$ln.'</strong>  not found</li> ';
					}
					$list_notOK_keyword .= '</ul>';

				}
				return array('statusCode'=>500,'content'=>'Number of keyword required: <strong>'.$result_complete_validate['num'].'</strong><br>'.$list_notOK_keyword.'. You have <strong>'.$ua->time_to_repost.'</strong> times to try again');
			}
			
			if(isset($result_complete_validate['error']) && $result_complete_validate['error']=='not-enough-wordcount'){
				$this->plus_time_repost($ua);
				return array('statusCode'=>500,'content'=>'Number of words required: <strong>'.$result_complete_validate['num'].'</strong>. You have <strong>'.$ua->time_to_repost.'</strong> times to try again');
			}
			

			/// ALl OKKKKKKKKKKKKKKK. Count user_assignment by assignment_id, if full with status 3, close this assignment
			UserAssignment::where('user_id',Auth::user()->id)->where('id',$id)->update(array('status'=>3,'link'=>$link,'approved_at'=>date('Y-m-d H:i:s',time())));  /// 2 is Written
			$total = UserAssignment::where('assignment_id',$ua->assignment_id)->where('status',3)->count();
			if($total==$assignment->max_blogger){
				$assignment->status = 0;
				$assignment->save();
			}	
			return array('statusCode'=>200);
		}
		else{
			$this->plus_time_repost($ua);
			return array('statusCode'=>500,'content'=>'<strong>'.$link.'</strong> is not valid. You have <strong>'.$ua->time_to_repost.'</strong> times to try again');

		}
		
		
	}


	public function curl_validate_user_blog($link)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt ($ch, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 400);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		/// remove iframe
		$string = preg_replace('#<iframe[^>]+>.*?</iframe>#is','', $data);
		return $string;
	}

	public function complete_validate_blog($required_link,$link,$required_keyword,$wordcount){
		
		/******************************************************/
			/// parse html to find anchors tag with attribute rel=dofollow
			include(app_path().'/Helper/simple_html_dom.php');
			
			$blog_content = str_get_html($this->curl_validate_user_blog($link));
			
			$list_ok_link = array();
			$list_notOK_link = array();
			foreach ($required_link as $key => $value) {
					$link_split = rtrim($value->link, "/");
					foreach($blog_content->find('a[href='.$link_split.']') as $element) {
				       if($element->rel!='nofollow'){
	   						$list_ok_link[] = $element->href;
	   					}
	   					else{
	   						$list_notOK_link[] = $element->href;
	   					}

					}
			}

			// if num of result smaller than required link
			if(count($list_ok_link)<count($required_link)){
				return array('error'=>'not-enough','list_notfollow'=>$list_notOK_link,'num'=>count($list_ok_link).'/'.count($required_link));
			}
		/******************************************************/



		/******************************************************
		*	check keyword
		******************************************************/
		$list_ok_keyword =array();
		foreach ($required_keyword as $key_k => $value_k) {
			
			/// find exactly keyword in blog content
			if (strpos($blog_content,$value_k) !== false) {
			    $list_ok_keyword[] = $value_k;
			}
			else{
				$list_notOK_keyword[] = $value_k;
			}
		}

		// if num of result smaller than required keyword
		if(count($list_ok_keyword)<count($required_keyword)){
			return array('error'=>'not-enough-keyword','list_notOK_keyword'=>$list_notOK_keyword,'num'=>count($list_ok_keyword).'/'.count($required_keyword));
		}




		/******************************************************
		*	check minimum wordcount
		******************************************************/
		$num_of_word_of_blogger_link =  str_word_count($blog_content->find('body',0)->plaintext);

		/// if not smaller than wordcount
		if($num_of_word_of_blogger_link<$wordcount){
			return array('error'=>'not-enough-wordcount','num'=>$num_of_word_of_blogger_link.'/'.$wordcount);
		}





	} /// end func

	public function plus_time_repost($ua){
		
		$minute_to_repost_time = Setting::where('name','minute_to_repost_time')->first()->value;	

		$rest_time = round(((($ua->minute_to_report_assignment*60) + strtotime($ua->created_at))-time())/60);

		if(($rest_time + $minute_to_repost_time) < $this->minute_to_report_assignment){
			$new_time = $ua->minute_to_report_assignment + $minute_to_repost_time;
		}
		else{
			$yeah = $this->minute_to_report_assignment - $rest_time;
			$new_time = $ua->minute_to_report_assignment + $yeah;
		}

		$ua->minute_to_report_assignment =  $new_time;
		$ua->save();



	}



}
