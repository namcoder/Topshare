<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	public function language(){
			return $this->hasOne('App\Language','id','lang_id');
	}

}
