<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model {

	public function language(){
		return $this->hasOne('App\Language','code','lang_code');
	}

}
