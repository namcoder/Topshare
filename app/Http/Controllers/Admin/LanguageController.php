<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request,App\Language;

class LanguageController extends Controller {

	public function index()
	{
		if(Request::isMethod('get')){
			$lang = Language::orderBy('id','desc')->get();
			return view('admin.language.list',array('langs'=>$lang));
		}

		/*
			When create a language. System will scan in English folder (default language)
			to get all files avaliable to translate. Then create all new file with same name
			in English folder
		*/

		$data = Request::all();

		$main_folder = base_path().'/resources/lang/';
		$exist_folder = file_exists($main_folder.$data['code']);
		if($exist_folder){
			return 'exist_folder';
		}
		else{
			mkdir($main_folder.$data['code']);
			// get all file in English and make a new copy same name in new language
			/*$list_files = array_diff(scandir($main_folder.'en'),array('..', '.'));
			foreach($list_files as $file){ 
			    fopen($main_folder.$data['code'].'/'.$file, "w");
			}
			*/
		}

		$l = new Language;
		$l->name = $data['name'];
		$l->code = $data['code'];
		$l->save();

	}
	public function delete(){
		$main_folder = base_path().'/resources/lang/';
		$data = Request::input('data');
		foreach ($data as $key => $value) {
			$item = Language::find($value);
			$code = $item->code;
			$files = glob($main_folder.$code.'/*'); 
			foreach($files as $file){ 
			    unlink($file); 
			}
			rmdir($main_folder.$code);
		}
		Language::destroy($data);
	}

	public function translate($code){ 
		$main_folder = base_path().'/resources/lang/en';
		$list_files = array_diff(scandir($main_folder),array('..', '.'));
		return view('admin.language.translate',array('lists'=>$list_files,'code'=>$code));
	}

	public function translate_file($code,$file){

		/*
			- This function will get all rows in English file
			- Compare with the language need to translate
		*/
		$folder = base_path().'/resources/lang/';
		$lang_folder = $folder.$code;
		if(Request::isMethod('get')){
			
			$lang_name = Language::where('code',$code)->first();

			$en_rows = file_get_contents($folder.'en/'.$file);
			$check_exist_new_file = file_exists($folder.$code.'/'.$file);
			
			if(!$check_exist_new_file){
				fopen($lang_folder.'/'.$file, "w");
			}

			$lang_rows = file_get_contents($folder.$code.'/'.$file);

			/// regex english
			preg_match('/\[(.*)\]/is', $en_rows,$en_each_row);


			$row = explode("\n", trim($en_each_row[1]));
			foreach ($row as $key => $value) {
				$remove_phay = str_replace("'", '', $value);
				$temp = str_replace(",", '', $remove_phay);
				$split_row[] = explode('=>', $temp);
			}

			// regex lang
			$regex_lang = preg_match('/\[(.*)\]/is', $lang_rows,$lang_each_row);
			if($regex_lang){
				$row_lang = explode("\n", trim($lang_each_row[1]));
				foreach ($row_lang as $key_lang => $value_lang) {
					$remove_phay_lang = str_replace("'",'',$value_lang);
					$temp_lang = str_replace(",",'',$remove_phay_lang);
					$split_row_lang[] = explode('=>',$temp_lang);
				}
			}
			else{
				$split_row_lang = null;
			}


			return view('admin.language.translate-file',
				array(
					'lang_name'=>$lang_name,
					'rows'=>$split_row,
					'rows_lang'=>$split_row_lang
					));

		}

		/// POST Method . Save the submit form

		$data = Request::all();
		$myfile = fopen($lang_folder.'/'.$file, "w");

		// begin of file
		$txt = "<?php return [\n";
		fwrite($myfile, $txt);

		foreach ($data['tranfield'] as $key => $value) {
			if($value!=null || $value!=''){
				$txt2 = "'".trim($data['key'][$key])."' => '".$value."',\n";
				fwrite($myfile, $txt2);
			}
			else{
				$txt2 = "'' => '".$value."',\n";
				fwrite($myfile, $txt2);
			}
		}
		
		/// end of file
		$txt = "\n];";
		fwrite($myfile, $txt);
		fclose($myfile);


		return redirect('admin/languages/translate/'.$code.'/'.$file)->with('ok','Save successful');
	}
	

}
