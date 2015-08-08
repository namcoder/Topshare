<?php 
////////////////////////////////////////////////////////////////
/*                    Administrator Section                   */
////////////////////////////////////////////////////////////////
Route::match(['GET','POST'],'admin-login', 'Admin\AdminController@login');

// For quick create assignment - ajax for this and for admin as well
Route::match(['GET','POST'],'admin/quick-create-assignment', 'Admin\AssignmentController@quick_create_assignment');
Route::match(['GET','POST'],'admin/ajax-get-setting-variable-by-customer-language', 'Admin\AssignmentController@ajax_get_setting_variable_by_customer_language');
// For riveronline internal system
Route::match(['GET','POST'],'admin/get-customer-assignment', 'Admin\AssignmentController@get_customer_assignment');
Route::match(['GET','POST'],'admin/get-customer-assignment-status', 'Admin\AssignmentController@get_customer_assignment_status');







Route::group(['middleware' => ['adminauth'],'prefix' => 'admin'], function()
{

    Route::get('/', 'Admin\AdminController@index');
    Route::get('logout', 'Admin\AdminController@logout');
    Route::match(['GET','POST'],'profile', 'Admin\AdminController@profile');
    
    /// CATEGORIES
    Route::group(['prefix'=>'blog-categories'],function(){
     Route::match(['GET','DELETE',],'/', 'Admin\BlogCategoryController@index');
     Route::match(['GET','POST'],'create', 'Admin\BlogCategoryController@create');
     Route::match(['GET','POST'],'/{id}', 'Admin\BlogCategoryController@edit');
    });

    /// USERS
    Route::group(['prefix'=>'users'],function(){
    	Route::match(['GET','POST'],'add-new', 'Admin\UserController@create');
    	Route::match(['GET','POST'],'edit/{id}', 'Admin\UserController@edit');
        Route::match(['GET','POST'],'list', 'Admin\UserController@index');
    });

    /// SETTINGS
    Route::group(['prefix'=>'settings'],function(){
      Route::match(['GET','POST'],'/', 'Admin\SettingsController@index');
      Route::match(['GET','POST'],'ajax-variable', 'Admin\SettingsController@ajax_variable');
      Route::match(['GET','POST'],'ajax-delete-variable', 'Admin\SettingsController@ajax_delete_variable');
    });

    /// ASSIGNMENTS
    Route::group(['prefix'=>'assignments'],function(){
      Route::match(['GET','POST'],'/', 'Admin\AssignmentController@index');
      Route::match(['GET','POST'],'create', 'Admin\AssignmentController@create');


      Route::post('change-status', 'Admin\AssignmentController@ajaxChangeStatus');
      Route::post('change-status-user-assignment', 'Admin\AssignmentController@ajaxChangeStatus_UserAssignment');
      Route::match(['GET','POST'],'/{id}', 'Admin\AssignmentController@edit');

    });

    /// LANGUAGES
    Route::group(['prefix'=>'languages'],function(){
      Route::match(['GET','POST'],'/', 'Admin\LanguageController@index');
      Route::match(['GET','POST'],'delete', 'Admin\LanguageController@delete');
      Route::match(['GET','POST'],'translate/{code}', 'Admin\LanguageController@translate');
      Route::match(['GET','POST'],'translate/{code}/{file}', 'Admin\LanguageController@translate_file');
    });

    
    /// Payment list
    Route::match(['GET','POST'],'payment-list', 'Admin\PaymentListController@index');
    Route::match(['GET','POST'],'payment-list/export-excel', 'Admin\PaymentListController@export_excel');

    
});