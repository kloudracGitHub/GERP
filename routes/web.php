<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// SuperAdmin Routes //

Route::match(['get', 'post'], '/login','SuperAdminController@superadmin_login');
Route::match(['get', 'post'], '/change-password','SuperAdminController@changepass');
Route::match(['get', 'post'], '/email-verify','SuperAdminController@email_verification');

Route::get('/sendMonthlyReportReport','CronController@send_monthly_report');
Route::get('/sendSixMonthlyReportReport','CronController@sendSixMonthlyReportReport');
Route::match(['get', 'post'], '/new-password/{title}','SuperAdminController@new_password');
Route::match(['get', 'post'], '/forget-password','SuperAdminController@superadmin_forget_pass');


Route::group(['middleware' => 'guest'], function () {
Route::match(['get', 'post'], '/dashboard','SuperAdminController@superadmin_dashboard');

Route::match(['get', 'post'], '/logout','SuperAdminController@superadmin_logout');


Route::match(['get', 'post'], '/circular','SuperAdminController@circulars');
Route::match(['get', 'post'], '/circular-delete/{id}','SuperAdminController@circulars_delete');
/*Organization Routes*/
Route::match(['get', 'post'], '/Organization-list','SuperAdminController@organizationlist');
Route::match(['get', 'post'], '/Organization-add','SuperAdminController@organizationadd');
Route::match(['get', 'post'], '/Organization-view/{id?}','SuperAdminController@superadmin_orgview');
Route::match(['get', 'post'], '/Organization-status/{id}','SuperAdminController@orgstatus');
Route::match(['get', 'post'], '/org-status-email/{id}','SuperAdminController@org_status_email');
Route::match(['get', 'post'], '/org_delele/{id}','SuperAdminController@org_delele');
Route::match(['get', 'post'], '/delete_currency/{id}','SuperAdminController@delete_currency');


/*End Organization Routes*/

/*Project Routes*/
Route::match(['get', 'post'], '/Project-list','SuperAdminController@projectlist');
Route::match(['get', 'post'], '/Project-add','SuperAdminController@projectadd');
Route::match(['get', 'post'], '/Project-status/{id}','SuperAdminController@project_status');
Route::match(['get', 'post'], '/project-status-email/{id}','SuperAdminController@project_status_email');
Route::match(['get', 'post'], '/Project-view/{id}','SuperAdminController@superadmin_proview');
Route::match(['get', 'post'], '/Project-document/{id}','SuperAdminController@project_document');
Route::match(['get', 'post'], '/project-doc-delete/{id}','SuperAdminController@project_document_delete');
Route::match(['get', 'post'], '/Project-detail/{id}','SuperAdminController@project_detail');
Route::match(['get', 'post'], '/add-condition/{id}','SuperAdminController@project_condition_add');
Route::match(['get', 'post'], '/project-type/{condidtion}/{project_id}','SuperAdminController@project_type');


Route::match(['get', 'post'], '/edit-condition/{id}','SuperAdminController@project_condition_edit');
Route::match(['get', 'post'], '/Project-assignuser/{id}','SuperAdminController@project_assignuser');
Route::match(['get', 'post'], '/delete-condition','SuperAdminController@project_condition_delete');
Route::match(['get', 'post'], '/Project-additional-condition/{id}','SuperAdminController@additional_projectstage');
Route::match(['get', 'post'], '/Project-edit/{id}','SuperAdminController@projectedit');

Route::match(['get', 'post'], '/userdata','SuperAdminController@userDatas');
Route::get( '/deleteproject/{id}','SuperAdminController@deleteproject');
Route::match(['get', 'post'], '/checktask/{id}','SuperAdminController@check_projectlastdate');

Route::match(['get', 'post'], '/projectmanageraction/{title}','SuperAdminController@projectmanager_activity');

Route::match(['get', 'post'], '/taskcannotbecompleted/{id}','SuperAdminController@taskcannotcompleted');

Route::match(['get', 'post'], '/pro_delele/{id}','SuperAdminController@pro_delele');

Route::match(['get', 'post'], '/task_delele/{id}','SuperAdminController@task_delele');
Route::match(['get', 'post'], '/user_delele/{id}','SuperAdminController@user_delele');
Route::match(['get', 'post'], '/delete_status/{id}','SuperAdminController@delete_status');
Route::match(['get', 'post'], '/delete_type/{id}','SuperAdminController@delete_type');
Route::match(['get', 'post'], '/delete_stage/{id}','SuperAdminController@delete_stage');
Route::match(['get', 'post'], '/delete_sector/{id}','SuperAdminController@delete_sector');



/*End Project Routes*/

/*Users Routes*/
Route::match(['get', 'post'], '/Users-list','SuperAdminController@userlist');
Route::match(['get', 'post'], '/Users-add','SuperAdminController@user_add');
Route::match(['get', 'post'], '/Users-status/{id}','SuperAdminController@userstatus');
Route::match(['get', 'post'], '/user-status-email/{id}','SuperAdminController@user_status_email');
Route::match(['get', 'post'], '/Users-view/{id}','SuperAdminController@userview');
/*End Users Routes*/

/*System wide setting Routes*/
Route::match(['get', 'post'], '/country','SuperAdminController@countryadd');
Route::match(['get', 'post'], '/country-delete/{id}','SuperAdminController@countrydelete');
Route::match(['get', 'post'], '/status-management','SuperAdminController@statusadd');
Route::match(['get', 'post'], '/stage-management','SuperAdminController@stageadd');
Route::match(['get', 'post'], '/type-management','SuperAdminController@typeadd');
Route::match(['get', 'post'], '/currency-management','SuperAdminController@currencyadd');
Route::match(['get', 'post'], '/sector-management','SuperAdminController@sectoradd');
/*End System wide setting Routes*/

/*Task Routes*/
Route::match(['get', 'post'], '/Task-list','SuperAdminController@tasklist');
Route::match(['get', 'post'], '/Task-add','SuperAdminController@taskadd');
Route::match(['get', 'post'], '/Task-detail/{id}','SuperAdminController@taskdetail');
Route::match(['get', 'post'], '/Task-edit-detail/{id}','SuperAdminController@task_editdetail');
Route::match(['get', 'post'], '/Task-documentdownload/{filename}','SuperAdminController@task_documentdownload');
Route::match(['get', 'post'], '/task-status/{id}','SuperAdminController@taskstatus');
Route::post('/attach-file/','SuperAdminController@attach_file');
Route::post('/update_task_data/','SuperAdminController@update_task_data');

Route::match(['get', 'post'], '/get_project/{id}/','SuperAdminController@get_project');
Route::post('/update_hint_data/','SuperAdminController@update_hint_data');
Route::post('/get_hint_id/','SuperAdminController@get_hint_id');
Route::get('/delete-task-file/{id}','SuperAdminController@delete_task_file');
Route::get('/delete-hint/{id}','SuperAdminController@delete_hint');
Route::get('/checkProjectDate/{date}/{project_id}','SuperAdminController@checkProjectDate');
Route::match(['get', 'post'],'/Project-assignuser-indiviable/{project_id}','SuperAdminController@project_assign_inviable');




/*End Task Routes*/

/*Profile Routes*/
Route::match(['get', 'post'], '/myProfile','SuperAdminController@profileadd');
Route::match(['get', 'post'], '/Profile-edit/{id}','SuperAdminController@profileedit');
/*Profile Routes*/


Route::match(['get', 'post'], '/Document','SuperAdminController@document');
Route::match(['get', 'post'], '/state-list/{id}','SuperAdminController@statelist');
Route::match(['get', 'post'], '/city-list/{id}','SuperAdminController@citylist');
Route::match(['get', 'post'], '/mng_list/{id}','SuperAdminController@mng_list');

//Route::match(['get', 'post'], '/system-wide-setting','AdminController@admin_systemsetting');

//Route::match(['get', 'post'], '/forget-password','AdminController@admin_forgetpass');
//Route::match(['get', 'post'], '/confirm-password','AdminController@admin_confirmpass');




// End SuperAdmin Routes //
/*Admin Login*/
Route::match(['get', 'post'], '/Adminlogin','AdminController@admin_login');
Route::match(['get', 'post'], '/Adminlogout','AdminController@admin_logout');
Route::match(['get', 'post'], '/Organization-view-editorggg/{id}','AdminController@admin_orgview_editorgname');
Route::match(['get', 'post'], '/Organization-view-editorgggUser/{id}','AdminController@admin_orgview_editorgUsername');
Route::match(['get', 'post'], '/Organization-view-editorgggmobile/{id}','AdminController@admin_orgview_editorgmobile');
Route::match(['get', 'post'], '/Organization-view-editorgggalternate/{id}','AdminController@admin_orgview_editorgalternate');
Route::match(['get', 'post'], '/Organization-view-editorgggpincode/{id}','AdminController@admin_orgview_editorgpincode');
Route::match(['get', 'post'], '/Organization-view-editorgggaddress/{id}','AdminController@admin_orgview_editorgaddress');
Route::match(['get', 'post'], '/Project-view-editprojectname/{id}','AdminController@admin_proviewedit_projectname');
Route::match(['get', 'post'], '/Project-view-editpincode/{id}','AdminController@admin_proviewedit_pincode');
Route::match(['get', 'post'], '/Project-view-editlandmark/{id}','AdminController@admin_proviewedit_landmark');
Route::match(['get', 'post'], '/Users-view-edit/{id}','AdminController@userview_editfirstname');
Route::match(['get', 'post'], '/Users-view-edit-lname/{id}','AdminController@userview_editlname');
Route::match(['get', 'post'], '/Users-view-edit-mobile/{id}','AdminController@userview_editmobile');
Route::match(['get', 'post'], '/Users-view-edit-pincode/{id}','AdminController@userview_editpincode');
Route::match(['get', 'post'], '/Users-view-edit-landmark/{id}','AdminController@userview_editlandmark');
/*End Admin Login*/

/*Project Manager Login*/
Route::match(['get', 'post'], '/projectmanager_login','AdminController@pm_login');
Route::match(['get', 'post'], '/pmlogout','AdminController@pm_logout');
/*End Project Manager Login*/

/*Employee Login*/
Route::match(['get', 'post'], '/employee-login','AdminController@employee_login');
Route::match(['get', 'post'], '/employeelogout','AdminController@employeelogout');
/*End Employee Login*/

Route::post( '/getdeails/','SuperAdminController@getdeails_user');

Route::match(['get', 'post'],'/report/','SuperAdminController@report_search');
Route::get('/pdf/','SuperAdminController@pdf');

Route::get('/export_csv/','SuperAdminController@export_csv');
Route::post('/import_csv_data','SuperAdminController@import_csv_data');

Route::match(['get', 'post'],'/getorganisation/{id}','SuperAdminController@getorganisationlist');
Route::match(['get', 'post'],'/getoproject/{role}/{org}','SuperAdminController@getoproject');
Route::match(['get', 'post'],'/getcondition/{id}','SuperAdminController@getcondition');
Route::match(['get', 'post'],'/view-noti/{id}','SuperAdminController@view_noti');

Route::match(['get', 'post'],'/testpage','SuperAdminController@testpage');


});

 // Start Api  //

 
Route::group(['namespace' => 'Api'], function () {
 	 
    Route::post('apilogin', 'UserController@authenticate');
      Route::post('forgot', 'DashboardController@forgot_password'); 
       Route::post('/changepassword','DashboardController@change_password'); 

        Route::group(['middleware' => ['allow.origin']], function() {
         Route::post('contact-us', 'DashboardController@contact_us'); 
         });
   

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', 'UserController@getAuthenticatedUser');
         Route::get('dashboardapi', 'DashboardController@dashboard_view');

######################################### ORG list ########################################

          Route::match(['get', 'post'],'organizationlist', 'DashboardController@organizationlist_view');
          Route::match(['get', 'post'],'organizationlist_pagination', 'DashboardController@organizationlist_pagination');
          Route::get('organization_view_app/{id}', 'DashboardController@organization_view_app');
          Route::match(['get', 'post'], 'organization_edit_app/{id}', 'DashboardController@organization_edit_app');
          Route::post('organizationadd', 'DashboardController@organization_add');
          Route::get('organization_delete/{id}', 'DashboardController@organization_delete');
           Route::get('orgstatus/{id}', 'DashboardController@org_status');
           Route::get('org_admin_app', 'DashboardController@org_admin_app');
           Route::get('org_delete_app/{id}', 'DashboardController@org_delete_app');
              Route::match(['get', 'post'], '/organizationlist_search','DashboardController@organizationlist_search');

              Route::get('org_export', 'DashboardController@org_export');
          
######################################### project list ########################################

            Route::match(['get', 'post'],'projectlist', 'DashboardController@project_list');

             Route::match(['get', 'post'],'projectlist_pagination', 'DashboardController@project_list_pagination');

            Route::match(['get', 'post'],'org_projectlist', 'DashboardController@org_projectlist');
              Route::match(['get', 'post'],'projectedit/{id}', 'DashboardController@project_edit');
               Route::post('project_add_app', 'DashboardController@project_add');
               Route::get('projectstatus/{id?}', 'DashboardController@project_status');
                Route::get('projectdetail/{id}', 'DashboardController@project_detail');
              Route::get('get_project_app/{id}', 'DashboardController@get_project_app');
               Route::get('delete_project_app/{id}', 'DashboardController@delete_project_app');
               Route::get('project_view_app/{id}', 'DashboardController@project_view_app');
               Route::match(['get', 'post'], 'project_document_app/{id}', 'DashboardController@project_document_app');
                Route::match(['get', 'post'], 'add_condition_app/{id}', 'DashboardController@add_condition_app');
                  Route::match(['get', 'post'], 'edit_condition_app/{id}', 'DashboardController@edit_condition_app');
                  Route::match(['get', 'post'], 'edit_condition_app/{id}', 'DashboardController@edit_condition_app');

                  Route::match(['get', 'post'], 'project_condition_delete_app/{id}', 'DashboardController@project_condition_delete_app');

                  Route::match(['get', 'post'], 'additional_projectstage_app/{id}', 'DashboardController@additional_projectstage_app');

                  Route::match(['get', 'post'], 'update_stage_app/{id}', 'DashboardController@update_stage_app');

                  

                    Route::match(['get', 'post'], '/project_assignuser_app/{id}','DashboardController@project_assignuser_app');
                   
                    Route::match(['get', 'post'], '/project_export','DashboardController@project_export');

                  
                  
                
               

               

      Route::get('superadmin_project_view/{id}', 'DashboardController@superadmin_project_view');
      Route::post('projectdocument', 'DashboardController@project_document');
       Route::post('document_export', 'DashboardController@document_export');
      Route::get('orgview/{id?}', 'DashboardController@org_view');

      Route::get('country_app', 'DashboardController@country_app');
      Route::post('state_app', 'DashboardController@state_app');
      Route::post('city_app', 'DashboardController@city_app');
       

        Route::get('project_org_list_app', 'DashboardController@project_org_list_app');
        Route::match(['get', 'post'], 'project_mng_list_app', 'DashboardController@project_mng_list_app');
         Route::get('project_type_app', 'DashboardController@project_type_app');
          Route::get('project_stage_app', 'DashboardController@project_stage_app');
          Route::get('project_sector_app', 'DashboardController@project_sector_app');
            Route::get('project_status_app', 'DashboardController@project_status_app');

           Route::get('project_currency_app', 'DashboardController@project_currency_app');


     Route::match(['get', 'post'], '/create_custome_condition_app/{id}','DashboardController@create_custome_condition_app');
           
           Route::match(['get', 'post'], '/add_project_condition_app/{id}','DashboardController@add_project_condition_app');
           Route::match(['get', 'post'], '/edit_project_condition_app/{id}','DashboardController@edit_project_condition_app');
         

           Route::post('/project_condition_delete_app','DashboardController@project_condition_delete_app');

           Route::match(['get', 'post'], '/project_additional_condition_app/{id}','DashboardController@project_additional_condition_app');

    Route::match(['get', 'post'], '/Project_edit_app/{id}','DashboardController@Project_edit_app');

             Route::match(['get', 'post'], 'project_form_list', 'DashboardController@project_form_list');
             Route::match(['get', 'post'], 'project_form_file_list/{id}', 'DashboardController@project_form_file_list');

              Route::match(['get', 'post'], 'project_form_file_delete/{id}', 'DashboardController@project_form_file_delete');
    

######################################### Task list ########################################


  Route::match(['get', 'post'], '/task_list_app','DashboardController@task_list_app');
  Route::match(['get', 'post'], '/task_list_pagination','DashboardController@task_list_pagination');
Route::match(['get', 'post'], '/task_export_app','DashboardController@task_export_app');

   Route::match(['get', 'post'], '/task_add_app','DashboardController@task_add_app');
   Route::match(['get', 'post'], '/task_edit_app/{id}','DashboardController@task_edit_app');
    Route::get('/task_details_app/{id}','DashboardController@task_details_app');
 Route::match(['get', 'post'], '/task_remark_update_app/{id}','DashboardController@task_remark_update_app');
 Route::match(['get', 'post'], '/task_user_list_app','DashboardController@task_user_list_app');
 Route::match(['get', 'post'], '/task_status_app/{id}','DashboardController@task_status_app');
 Route::match(['get', 'post'], '/attach_file_app','DashboardController@attach_file_app');

  Route::get( '/task_delele_app/{id}','DashboardController@task_delele_app');
  Route::post( '/update_figure_app/','DashboardController@update_figure_app');
  Route::post( '/update_actual_app/','DashboardController@update_actual_app');
  Route::post( '/add_hints/','DashboardController@add_hints');
  Route::post( '/edit_hints/','DashboardController@edit_hints');
  Route::post( '/add_fileattach_hints/','DashboardController@add_fileattach_hints');
  Route::get( '/delete_hints/{id}','DashboardController@delete_hints');
  Route::get( '/delete_fileattach/{id}','DashboardController@delete_fileattach');

######################################### User list ########################################

 Route::get( '/user_delele_app/{id}','DashboardController@user_delele_app');
 Route::match(['get', 'post'], '/delete_status_app/{id}','DashboardController@delete_status_app');
Route::match(['get', 'post'], '/delete_type_app/{id}','DashboardController@delete_type_app');
 Route::match(['get', 'post'], '/delete_stage_app/{id}','DashboardController@delete_stage_app');
   
   Route::match(['get', 'post'], '/delete_sector_app/{id}','DashboardController@delete_sector_app');
   Route::match(['get', 'post'], '/userlist_app','DashboardController@userlist_app');

    Route::match(['get', 'post'], '/userlist_pagination_app','DashboardController@userlist_pagination_app');

      Route::match(['get', 'post'], '/user_add_app','DashboardController@user_add_app');
      Route::match(['get', 'post'], '/user_edit_app','DashboardController@user_edit_app');
      Route::match(['get', 'post'], '/user_delete_app/{id}','DashboardController@user_delete_app');
    Route::match(['get', 'post'], '/user_status_app/{id}','DashboardController@user_status_app');
       Route::match(['get', 'post'], '/user_view_app/{id}','DashboardController@user_view_app');
        Route::match(['get', 'post'], '/user_role_list_app','DashboardController@user_role_list_app');



         Route::match(['get', 'post'], '/myprofile_app','DashboardController@myprofile_app');
       Route::match(['get', 'post'], '/myprofile_edit_app/{id}','DashboardController@myprofile_edit_app');
        Route::match(['get', 'post'], '/user_export','DashboardController@user_export');
    

       
        
     /*System wide setting Routes*/
   Route::match(['get', 'post'], '/country_add_app','DashboardController@country_add_app');
    Route::get('/country_delete_app/{id}','DashboardController@country_delete_app');
     Route::match(['get', 'post'], '/status_management_app/{id?}','DashboardController@status_management_app');
       Route::match(['get', 'post'], '/status_management_app/{id?}','DashboardController@status_management_app');
         Route::match(['get', 'post'], '/stage_management_app/{id?}','DashboardController@stage_management_app'); 
     Route::match(['get', 'post'], '/type_management_app/{id?}','DashboardController@type_management_app');
      Route::match(['get', 'post'], '/currency_management_app/{id?}','DashboardController@currency_management_app');

      Route::match(['get', 'post'], '/sector_management_app/{id?}','DashboardController@sector_management_app');
              


  /*Report Routes*/ 

   Route::match(['get', 'post'], '/report_app','DashboardController@report_app');
   Route::match(['get', 'post'], '/pdf_app','DashboardController@pdf_app');
   Route::get('/export_csv_app/','DashboardController@export_csv_app');
     Route::match(['get', 'post'], '/report_data_to_html_list','DashboardController@report_data_to_html_list');
     Route::match(['get', 'post'], '/report_org_project_list','DashboardController@report_org_project_list');

   
   
 
  Route::match(['get', 'post'], '/getorganisation_app/{role}','DashboardController@getorganisation_app');
  Route::match(['get', 'post'],'/getoproject_app','DashboardController@getoproject_app');
 
  Route::match(['get', 'post'],'/getcondition_app/{project_id}','DashboardController@getcondition_app');

   Route::get('/custome_condition_app/{id}','DashboardController@custome_getoproject_app'); 



  /*Notification Routes*/ 

   Route::match(['get', 'post'], '/notification_app','DashboardController@notification_app');


   Route::match(['get', 'post'], '/view_notification_app','DashboardController@view_notification_app');


/*  Document Module   */

   Route::match(['get', 'post'], '/document_app','DashboardController@document_app');
   Route::post('/import_csv_data_app','DashboardController@import_csv_data_app');


/*  Circular Module   */

   Route::match(['get', 'post'], '/circulars_app','DashboardController@circulars_app');
   Route::match(['get', 'post'], '/circulars_date_rage_app','DashboardController@circulars_date_rage_app');
   Route::get('/circulars_delete_app/{id}','DashboardController@circulars_delete_app');

/*  Chnage Passord Module   */


   Route::match(['get', 'post'], '/changepass_app','DashboardController@changepass_app');




    });

 });

 // End Api  //
