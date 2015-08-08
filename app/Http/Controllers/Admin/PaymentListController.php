<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UserBlog,App\Language,App\User,App\Setting,App\UserAssignment,Request;

class PaymentListController extends Controller {

	
	public function index()
	{
		$exportExcel = Request::input('exportExcel');
		$lang = Request::input('lang');
		$status = Request::input('status');
		$period = Request::input('period');
		$period_to = Request::input('period_to');

		$data = array();

		$data['langs'] = Language::all();

		$users = User::where('role','<>',1)->get(array('id','name','cpr','account_number'));

		$list_user_assigns = array();
		$list_users_lang = array();


		/// filter by langs
		if($lang && $lang=='all' || !$lang ){
			foreach ($users as $k => $u) {
				$num = UserBlog::where('user_id',$u->id)->first();
				if($num){
					$list_users_lang[$k] = $u;
					$list_users_lang[$k]['star'] = $num->star;
					$list_users_lang[$k]['lang_code'] = $num->lang_code;
					$star_value = Setting::where('lang_code',$num->lang_code)->where('name','star_value')->first()->value;
					if(!$star_value){
						$star_value = Setting::where('lang_code','en')->where('name','star_value')->first()->value;
					}
					$list_users_lang[$k]['star_value'] = $star_value;
					$list_users_lang[$k]['total_amount'] = 0;

				}
			}
		}
		elseif ($lang && $lang!='all') {
			foreach ($users as $k => $u) {
				$num = UserBlog::where('user_id',$u->id)->where('lang_code',$lang)->first();
				if($num){
					$list_users_lang[$k] = $u;
					$list_users_lang[$k]['star'] = $num->star;
					$list_users_lang[$k]['lang_code'] = $num->lang_code;
					$star_value = Setting::where('lang_code',$num->lang_code)->where('name','star_value')->first()->value;
					if(!$star_value){
						$star_value = Setting::where('lang_code','en')->where('name','star_value')->first()->value;
					}
					$list_users_lang[$k]['star_value'] = $star_value;
					$list_users_lang[$k]['total_amount'] = 0;
				}
			}
		}
		
		/// filter by status

			/// if status == all or dont isset status
		if($status && $status=='all' || !$status){
			foreach ($list_users_lang as $k_u_l => $v_u_l) {

				/// if period = null, dont query by date
				if($period=='' || !$period){
					$ua = UserAssignment::where('user_id',$v_u_l->id)->whereIn('status',array(3,5))->get(array('id','link','status','extra_star','approved_at','created_at'));
				}
				else{
					// if isset period and period != null
					$period = date('Y-m-d 00:00:00',strtotime($period));
					$period_to = date('Y-m-d 23:59:59',strtotime($period_to));
					$ua = UserAssignment::where('user_id',$v_u_l->id)->whereIn('status',array(3,5))->where('approved_at','>=',$period)->where('approved_at','<=',$period_to)->get(array('id','link','status','extra_star','approved_at','created_at'));
				}

				if(count($ua)){
					$list_user_assigns[$k_u_l] = $v_u_l;
					$list_user_assigns[$k_u_l]['user_assignment'] = $ua;
					foreach ($ua as $key_ua => $value_ua) {
							$list_user_assigns[$k_u_l]['user_assignment'][$key_ua]['amount'] = ($value_ua['extra_star'] + $v_u_l['star']) * $v_u_l['star_value'];
							$list_users_lang[$k_u_l]['total_amount'] += $list_user_assigns[$k_u_l]['user_assignment'][$key_ua]['amount'];

					}

				}
			}
		}
		elseif($status && $status!='all'){
			foreach ($list_users_lang as $k_u_l => $v_u_l) {
				if($period=='' || !$period){
					$ua = UserAssignment::where('user_id',$v_u_l->id)->where('status',$status)->get(array('id','link','status','extra_star','approved_at','created_at'));
				}
				else{
					$period = date('Y-m-d 00:00:00',strtotime($period));
					$period_to = date('Y-m-d 23:59:59',strtotime($period_to));
					$ua = UserAssignment::where('user_id',$v_u_l->id)->where('status',$status)->where('approved_at','>=',$period)->where('approved_at','<=',$period_to)->get(array('id','link','status','extra_star','approved_at','created_at'));
				}
				if(count($ua)){
					$list_user_assigns[$k_u_l] = $v_u_l;
					$list_user_assigns[$k_u_l]['user_assignment'] = $ua;
					foreach ($ua as $key_ua => $value_ua) {
						$list_user_assigns[$k_u_l]['user_assignment'][$key_ua]['amount'] = ($value_ua['extra_star'] + $v_u_l['star']) * $v_u_l['star_value'];
						$list_users_lang[$k_u_l]['total_amount'] += $list_user_assigns[$k_u_l]['user_assignment'][$key_ua]['amount'];
					}
				}
			}
		}
		/// export excel
		if($exportExcel){
			 return $this->exportExcel($list_user_assigns);

		}

		return view('admin.payment-list.index',array('users'=>$list_user_assigns,'langs'=>$data['langs']));
	}


	public function exportExcel($data){
			include(app_path().'/Helper/PHPExcel.php');

			$objPHPExcel = new \PHPExcel();

			$objPHPExcel->setActiveSheetIndex(0)
			            ->setCellValue('A1', 'Name')
			            ->setCellValue('B1', 'CPR')
			            ->setCellValue('C1', 'Reg. Account')
			            ->setCellValue('D1', 'Country Code')
			            ->setCellValue('E1', 'Amount');

			for($col = 'A'; $col !== 'F'; $col++) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getRowDimension()->setRowHeight(23);
			}

			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0961AD');
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setRGB('FFFFFF');
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$set_value = $objPHPExcel->setActiveSheetIndex(0);
			$i = 2;
			foreach ($data as $key_date => $value_data) {
				$next = $i+1;
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$set_value->setCellValue('A'.$i, $value_data['name']);
				$set_value->setCellValue('B'.$i, $value_data['cpr']);
				$set_value->setCellValue('C'.$i, $value_data['account_number']);
				$set_value->setCellValue('D'.$i, $value_data['lang_code']);
				$set_value->setCellValue('E'.$i, $value_data['total_amount']);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$next.':E'.$next)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('37AD09');
				$set_value->setCellValue('A'.$next, 'Status');
				$set_value->setCellValue('B'.$next, 'Link');
				$set_value->setCellValue('C'.$next, 'Created');
				$set_value->setCellValue('D'.$next, 'Approved');
				$set_value->setCellValue('E'.$next, 'Amount');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$next.':E'.$next)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$assign_i = $next+1;
				foreach ($value_data['user_assignment'] as $key_assignment => $value_assignment) {
					if($value_assignment['status']==3){
						$assign_status = 'Approved';
					}
					else{
						$assign_status = 'Completed';
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$assign_i.':E'.$assign_i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$set_value->setCellValue('A'.$assign_i, $assign_status);
					$set_value->setCellValue('B'.$assign_i, $value_assignment['link']);
					$set_value->setCellValue('C'.$assign_i, date('Y-m-d',strtotime($value_assignment['created_at'])));
					$set_value->setCellValue('D'.$assign_i, date('Y-m-d',strtotime($value_assignment['approved_at'])));
					$set_value->setCellValue('E'.$assign_i, $value_assignment['amount']);
					$assign_i++;
				}

				$i = $assign_i+2;

			}


				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="TOPSHARE-PAYMENT-LIST-'.date('m-d-Y').'.xlsx"');

				$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save('php://output');

	}


} /// end class
