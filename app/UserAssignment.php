<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssignment extends Model {

	public function assignment(){
		return $this->hasOne('App\Assignment','id','assignment_id');
	}

	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}
}
