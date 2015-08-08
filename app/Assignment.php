<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model {

	public function userassignment(){
		return $this->hasMany('App\UserAssignment','assignment_id','id');
	}

	public function getUserInfo($user_id){
		return User::find($user_id);
	}

	public function getUserBlog($user_id){
		return UserBlog::where('user_id',$user_id)->first();
	}

}
