<?php
Route::get('test', function(){
    $domain = strtolower('http://sparesvinet.dk/index.php/2015/07/21/test/');
        $domain =  preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $domain);
        $domain =  explode('/', $domain);
       echo  gethostbyname($domain[0]);

});

/// CHANGE LANGUAGE
Route::post('set-locale', 'HomeController@set_locale');
Route::get('reset-password/{email}/{key}', 'ProfileController@reset_password');
Route::post('update-password', 'ProfileController@update_password');
Route::get('ajax-get-categories', 'ProfileController@ajax_get_categories');

////////////////////////////////////////////////////////////////
/*                    Home Section                            */
////////////////////////////////////////////////////////////////

Route::group(['middleware'=>['langversion']],function(){

       Route::get('/', 'HomeController@index');

       Route::group(['middleware'=>['guest']],function(){
           Route::match(['GET','POST'],'login', 'HomeController@login');
           Route::match(['GET','POST'],'sign-up', 'ProfileController@signup');
           Route::match(['GET','POST'],'forgot-password', 'ProfileController@forgot_password');

       });

       /////////////////// LOGGED 
                   //// profile
       Route::group(['middleware'=>['auth'],'prefix' => 'profile'],function(){
           Route::get('/', 'ProfileController@index');
           Route::get('logout', 'ProfileController@logout');
           Route::match(['GET','POST'],'my-profile', 'ProfileController@myprofile');
           Route::post('update-blog-domain','BlogEvaluationController@check_domain');
           Route::match(['GET','POST'],'account-number', 'ProfileController@account_number');

           
           /// Open assignments
           Route::match(['GET','POST'],'open-assignments', 'ProfileController@open_assignments');
           Route::match(['GET','POST'],'open-assignments/{id}', 'ProfileController@assignment_detail');
           Route::match(['GET','POST'],'my-assignments/{id}', 'ProfileController@my_assignment_detail');
           Route::match(['GET','POST'],'completed-assignment/{id}', 'ProfileController@completed_assignments');
           Route::match(['GET','POST'],'re-completed-assignment/{id}', 'ProfileController@re_completed_assignments');
           Route::match(['GET','POST'],'apply-assignment/{id}', 'ProfileController@apply_assignment');
           Route::match(['GET','POST'],'my-assignments', 'ProfileController@my_assignments');
           



           Route::match(['GET','POST'],'validate-user-assignment-link', 'ProfileController@validate_user_assignment_link');




       });

       Route::match(['GET','POST'],'check-domain', 'BlogEvaluationController@check_domain');
       Route::get('ajax-blog-evaluation', 'BlogEvaluationController@evaluation');

       /////////////////// LOGGED 

});

////////////////////////////////////////////////////////////////
/*                    Administrator Section                   */
////////////////////////////////////////////////////////////////
include 'admin-routes.php';










Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
