<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request,App\UserBlog,Auth;

class BlogEvaluationController extends Controller {

	public function evaluation(){
		// ensure user has logged in
		if(Auth::check()){
			/// if user has no evaluation completed
			if(Auth::user()->userblog->status==0){
				$this->get_completed_blog_info(null,null,null,true);   /// last is for auto get
			}
			return view('display-star',array('full'=>Request::input('full')));
		}
		else{
			return 'You do not have permission to view this page';
		}
		
	}

	public function check_domain(){

		$category = Request::input('category');
		$category_save = implode(',',$category);
		$blogname = Request::input('blogname');
		$lang_code = Request::input('lang_code');
		$domain = strtolower (Request::input('domain'));
		$domain =  preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $domain);
		$domain =  preg_replace('/\//i', '$1', $domain);

		$regex_domain = preg_match('/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/', $domain);
		if(!$regex_domain){
			echo 'error_cantget';
			exit;
		}

		if(Request::input('signup')){
			$ub = UserBlog::where('domain',$domain)->count();
			if($ub){
				return 'domain_exist';
			}
		}

		// Default star is 3
		$star = 3;


		// 2. check by domain name (blogspot)

		$domain_type = preg_match('/([a-z0-9])([.])blogspot([.])([a-z])/is', $domain);
		
		///// domain_type == 0 : private domain
		///// domain_type == 1 : blogspot domain


		// 3. check by domain age
		//// if is blogspot domain, set domain_age = 1
		if($domain_type==0){  /// personal domain
			
			$content_domain =  $this->curl_whois($domain);
			$get_first_time = preg_match_all('/(<span data-bind-domain="expiration_date" style="visibility: visible;">)(.*?)(<\/span>)/is', $content_domain,$real_date);

			if($get_first_time==0){
				$get_2nd_time = preg_match('/(Registered:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )(.*?)(<br>)/is', $content_domain,$real_date);
				if($get_2nd_time==0){
					echo 'error_cantget';
					exit;
				}
				$year_created = date('Y',strtotime($real_date[2]));
				$month_created = date('m',strtotime($real_date[2]));
			}
			else{
				$year_created = date('Y',strtotime($real_date[2][1]));
				$month_created = date('m',strtotime($real_date[2][1]));
			}

			$year_now = date('Y');
			$month_now = date('m');

			if($month_now>$month_created){
				$num_of_month = (($year_now - $year_created) * 12) + abs($month_now-$month_created);
			}
			else{
				$num_of_month = (($year_now - $year_created) * 12) - abs($month_now-$month_created);
			}

			/*
				new change:
				0 years 5 months = 1 star, 3 years 1 month = 4 stars, 6 years 1 month = 7 stars)

			*/

			$result_of_year = $year_now - $year_created;
			$calculate_year_to_plus_star =  explode('.', round($num_of_month/12,1));
			$real_year = $calculate_year_to_plus_star[0];
			if(isset($calculate_year_to_plus_star[1])){
				$real_month = $calculate_year_to_plus_star[1];
			}
			else{
				$real_month = 0;
			}
			

			if($real_year==0){
				if($real_month>=4){
					$star += 1;
				}
			} 
			else{
				if($real_month>=1){
					$star += $real_year;
					$star += 1;
				}
				else{
					$star += $real_year;
				}
			}

		}
		/// if using blogspot domain
		else{
			$star += 1;
		}
		///// end check domain age

		/*
		* ///////// check by new or old IP. if new IP, plus 1 star
		*/
		/*$isNewIP = UserBlog::where('domain_ip',gethostbyname($domain))->count();
		if($isNewIP==0){
			$star += 1;
		}*/
		


		/// if request by sign up
		if(Request::input('signup')){
			// 4. Get report ID from linkresearchtools
			$result_curl_backlink =  json_decode($this->curl_get_report_id($domain));
			$report_id = $result_curl_backlink->report->report_id;

			$final_data_return['star'] = $star;
			$final_data_return['domain_age'] = $real_year.','.$real_month;
			$final_data_return['domain_type'] = $domain_type;
			$final_data_return['category'] = $category_save;
			$final_data_return['blogname'] = $blogname;
			$final_data_return['domain'] = $domain;
			$final_data_return['lang_code'] = $lang_code;
			$final_data_return['report_id'] = $report_id;
			return view('ajax-result-check-domain',array('data'=>$final_data_return)) ;
		}


		/// request by update blog 
		else{
			$this->get_completed_blog_info($category_save,$lang_code,$blogname,false);

			return view('display-star',array('full'=>'full'));
		}
		
	}

	public function get_completed_blog_info($category_save,$lang_code,$blogname,$autoget){
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
					$status_update = 0 . not evaluation yet
					$status_update = 1 . normal
					$status_update = 2 . over 500
				*/
				if(!$autoget){
					$arg_update = array('star'=>$star,'inbound_link'=>$num_of_inbound_link,'status'=>$status_update,'blogname'=>$blogname,'blog_categories'=>$category_save,'lang_code'=>$lang_code);
				}
				else{
					$arg_update = array('star'=>$star,'inbound_link'=>$num_of_inbound_link,'status'=>$status_update);
				}

				$update_user_blog = UserBlog::where('user_id',Auth::user()->id)->update($arg_update);
			}


			/// else do nothing	
		
	}


	public function curl_whois($domain){
		// $url = 'http://www.reg.ca/whois.cgi?domain=';
		// $url = 'http://whois.domaintools.com/';
		$url = 'https://who.is/whois/';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url.$domain);
		curl_setopt ($ch, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 400);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public function curl_get_report_id($domain)
	{
		$url = 'http://www.linkresearchtools.com/toolkit/api.php?api_key=b4dd549ec1a18fc3d901409cb54577cb&action=start_report&urls[0]='.$domain.'&values[0]=BL&title='.$domain;
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

}
