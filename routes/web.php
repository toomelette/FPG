<?php

/** Auth **/

use App\Swep\Helpers\Helper;
use Rats\Zkteco\Lib\ZKTeco;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\HRU\Employees\ServiceRecordController;



//PUBLIC ROUTES
Route::group(['as' => 'auth.'], function () {
	
	Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLogin');
	Route::post('/', 'Auth\LoginController@login')->name('login');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/username_lookup','Auth\AccountRecoveryController@username_lookup')->name('username_lookup');
    Route::post('/reset_password','Auth\AccountRecoveryController@reset_password')->name('reset_password');
    Route::post('/verify_email','Auth\AccountRecoveryController@verify_email')->name('verify_email');
    Route::get('/reset_password_via_email','Auth\AccountRecoveryController@reset_password_via_email')->name('reset_password_via_email');
});

Route::get('document/received/{slug}',\App\Http\Controllers\DocumentController::class.'@received')->name('dashboard.document.received');


/** HOME **/
Route::get('dashboard/home', 'HomeController@index')->name('dashboard.home')->middleware(['check.user_status','verify.email']);


Route::get('/dashboard/plantilla/print','PlantillaController@print')->name('plantilla.print');


//USER LEVEL ROUTES
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.',
    'middleware' => ['check.user_status', 'last_activity','sidenav_mw', 'verify.email']
], function () {
    Route::get('/employee/{slug}/qr','EmployeeController@generateQr')->name('employee.generate_qr');


    Route::get('/dtr/my_dtr', 'DTRController@myDtr')->name('dtr.my_dtr');
    Route::get('/dtr/download','DTRController@download')->name('dtr.download');
    Route::get('/dtr/fetch_by_user_and_month', 'DTRController@fetchByUserAndMonth')->name('dtr.fetch_by_user_and_month');
    Route::post('dashboard/changePass','UserController@changePassword')->name('all.changePass');
    Route::post('/change_side_nav','SidenavController@change')->name('sidenav.change');
    Route::post('/dtr/update_time_record','DTRController@updateTimeRecord')->name('dtr.update_time_record');
    Route::post('/dtr/update_remarks','DTRController@updateRemarks')->name('dtr.update_remarks');
    Route::post('/dtr/update_lt_ut','DTRController@updateLateUndertime')->name('dtr.update_lt_ut');

    /** MIS REQUESTS **/
    Route::get('/mis_requests/my_requests','MisRequestsController@myRequests')->name('mis_requests.my_requests');
    Route::post('/mis_requests/store','MisRequestsController@store')->name('mis_requests.store');
    Route::post('/mis_requests/cancel_request','MisRequestsController@cancelRequest')->name('mis_requests.cancel_request');
    Route::get('/mis_requests/{slug}/print','MisRequestsController@printRequestForm')->name('mis_requests.print_request_form');
    Route::post('/mis_requests/store_img','MisRequestsController@storeImg')->name('mis_requests.store_img');
    Route::get('/mis_requests_status/index_open','MisRequestsStatusController@indexOpen')->name('mis_requests_status.index_open');

    /** PROFILE **/
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class,'index'])->name('profile');
    Route::get('/profile/payslip', [\App\Http\Controllers\ProfileController::class,'payslipShow'])->name('profile.payslip');
    Route::post('/profile/payslip', [\App\Http\Controllers\ProfileController::class,'payslipVerifyPassword'])->name('profile.payslip');
    Route::get('/profile_details', [\App\Http\Controllers\ProfileController::class,'index'])->name('profile.details');
    Route::patch('/profile/update_password', [\App\Http\Controllers\ProfileController::class,'updatePassword'])->name('profile.update_password');
    Route::delete('/profile/signOutDevice', [\App\Http\Controllers\ProfileController::class,'signOutDevice'])->name('profile.sign_out_device');



    Route::get('/ajax/{for}','AjaxController@get')->name('ajax.get');
    Route::post('/ajaxPost/{for}','AjaxPostController@post')->name('ajax.post');


    Route::get('/view_doc/{id}','NewsController@viewDoc')->name('news.view_doc');
    Route::get('/view_document/{id}/{type}','ViewDocument@index')->name('view_document.index');
    Route::get('/news/{id}',[\App\Http\Controllers\NewsController::class,'show'])->name('news.show');

    /** PERMISSION SLIPS **/
    Route::get('/permission_slips/my_permission_slips','PermissionSlipController@myPermissionSlips')->name('permission_slip.my_permission_slips');
    Route::get('/permission_slip/{slug}/batch_print', [\App\Http\Controllers\PermissionSlipController::class,'batchPrint'])->name('permission_slip.batch_print');
    Route::get('/permission_slip/my', [\App\Http\Controllers\PermissionSlipController::class,'my'])->name('permission_slip.my');
    Route::get('/permission_slip/{slug}/print', [\App\Http\Controllers\PermissionSlipController::class,'print'])->name('permission_slip.print');
    Route::resource('permission_slip', 'PermissionSlipController')->only(['create','store','destroy','edit','update']);


    Route::resource('time_keeping', \App\Http\Controllers\HRU\TImeKeepingController::class);

    Route::resource('employee_time_logs', \App\Http\Controllers\HRU\EmployeeTimeLogsController::class);


    Route::get('/showLogs/{tableName}/{subjectId}',function ($tableName,$subjectId){

        $activities = \Spatie\Activitylog\Models\Activity::query()
            ->where('log_name','=',$tableName)
            ->where('subject_id','=',$subjectId)
            ->orderBy('created_at','desc')
            ->get();
        $first = $activities->first();
        if(!empty($first)){
            $subject = new $first->subject_type();
            $subject = $subject->query()->where('id',$subjectId)->first();
        }else{
            $subject = null;
        }

        return view('dashboard.public.activity_log_single')->with([
            'activities' => $activities,
            'subject' => $subject,
        ]);
    })->name('show_activity');

    Route::get('/document_request/{slug}/print',[\App\Http\Controllers\RECORDS\DocumentRequestsController::class,'print'])->name('document_request.print');
    Route::get('/leave_application/{slug}/print', 'LeaveApplicationController@print')->name('leave_application.print');
    Route::resource('leave_application', 'LeaveApplicationController')->only(['edit','update','store','create','destroy']);
    Route::get('hr_requests/my',[\App\Http\Controllers\HRU\HRRequestsController::class,'myIndex'])->name('hr_requests.my_index');
    Route::get('hr_requests/{slug}/showTimeline',[\App\Http\Controllers\HRU\HRRequestsController::class,'showTimeline'])->name('hr_requests.show_timeline');
    Route::get('hr_requests/{slug}/download',[\App\Http\Controllers\HRU\HRRequestsController::class,'download'])->name('hr_requests.download');
    Route::get('hr_requests/{slug}/file',[\App\Http\Controllers\HRU\HRRequestsController::class,'uploadFileForm'])->name('hr_requests.file');
    Route::get('/cos_employees/{slug}/myIndex',[\App\Http\Controllers\HRU\COSEmployeesController::class,'myIndex'])->name('my_cos.index');
    Route::post('/cos_employees/{slug}/uploadEvaluation',[\App\Http\Controllers\HRU\COSEmployeesController::class,'uploadEvaluation'])->name('my_cos.uploadEvaluation');
    Route::patch('/cos_employees/{slug}/updateData',[\App\Http\Controllers\HRU\COSEmployeesController::class,'updateData'])->name('my_cos.updateData');

});


//ADMIN LEVEL ROUTES
/** Dashboard **/
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.',
    'middleware' => ['check.user_status', 'check.user_route', 'last_activity','verify.email']
], function () {

	/** USER **/

	Route::post('/user/activate/{slug}', 'UserController@activate')->name('user.activate');
	Route::post('/user/deactivate/{slug}', 'UserController@deactivate')->name('user.deactivate');
	Route::get('/user/{slug}/reset_password', 'UserController@resetPassword')->name('user.reset_password');
	Route::patch('/user/reset_password/{slug}', 'UserController@resetPasswordPost')->name('user.reset_password_post');
	Route::get('/user/{slug}/sync_employee', 'UserController@syncEmployee')->name('user.sync_employee');
	Route::patch('/user/sync_employee/{slug}', 'UserController@syncEmployeePost')->name('user.sync_employee_post');
	Route::post('/user/unsync_employee/{slug}', 'UserController@unsyncEmployee')->name('user.unsync_employee');

	Route::resource('user', 'UserController');


	/** DISBURSEMENT VOUCHERS **/
	Route::get('/disbursement_voucher/user_index', 'DisbursementVoucherController@userIndex')->name('disbursement_voucher.user_index');
	Route::get('/disbursement_voucher/print/{slug}/{type}', 'DisbursementVoucherController@print')->name('disbursement_voucher.print');
    Route::get('/disbursement_voucher/print_preview/{slug}', 'DisbursementVoucherController@printPreview')->name('disbursement_voucher.print_preview');
	Route::patch('/disbursement_voucher/set_no/{slug}', 'DisbursementVoucherController@setNo')->name('disbursement_voucher.set_no_post');
	Route::post('/disbursement_voucher/confirm_check/{slug}', 'DisbursementVoucherController@confirmCheck')->name('disbursement_voucher.confirm_check');
	Route::get('/disbursement_voucher/{slug}/save_as', 'DisbursementVoucherController@saveAs')->name('disbursement_voucher.save_as');
	Route::resource('disbursement_voucher', 'DisbursementVoucherController');





	/** MENU **/
	Route::resource('menu', 'MenuController');

    /** MENU **/
    Route::get('/submenu/fetch','SubmenuController@fetch')->name('submenu.fetch');
    Route::get('submenu/{slug}',[\App\Http\Controllers\SubmenuController::class,'index'])->name('submenu.index');
    Route::get('submenu/{slug}/show',[\App\Http\Controllers\SubmenuController::class,'show'])->name('submenu.show');
    Route::post('submenu/{slug}',[\App\Http\Controllers\SubmenuController::class,'store'])->name('submenu.store');
    Route::delete('submenu/{slug}/revoke',[\App\Http\Controllers\SubmenuController::class,'revoke'])->name('submenu.revoke_permission');
	Route::resource('submenu','SubmenuController')->except(['index','store','show']);

	/** SIGNATORIES **/
	Route::resource('signatory', 'SignatoryController');


	/** DEPARTMENTS **/
	Route::resource('department', 'DepartmentController');


	/** DEPARTMENT UNITS **/
	Route::resource('department_unit', 'DepartmentUnitController');


	/** PROJECT CODES **/
	Route::resource('project_code', 'ProjectCodeController');


	/** FUND SOURCE **/
	Route::resource('fund_source', 'FundSourceController');


	/** LEAVE APPLICATION **/
	Route::get('/leave_application/user_index', 'LeaveApplicationController@userIndex')->name('leave_application.user_index');

	Route::get('/leave_application/{slug}/save_as', 'LeaveApplicationController@saveAs')->name('leave_application.save_as');
	Route::resource('leave_application', 'LeaveApplicationController')->except(['edit','update','store','create','destroy']);



	/** EMPLOYEE **/
    Route::get('/employee/edit_bm_uid','EmployeeController@edit_bm_uid')->name('employee.edit_bm_uid');
    Route::post('/employee/update_bm_uid','EmployeeController@update_bm_uid')->name('employee.update_bm_uid');
	Route::get('/employee/print_pds/{slug}/{page}', 'EmployeeController@printPds')->name('employee.print_pds');

    /*Service Records*/
	Route::get('/employee/{slug}/service_record', [ServiceRecordController::class,'index'])->name('employee.service_record');
	Route::post('/employee/{slug}/service_record', [ServiceRecordController::class,'store'])->name('employee.service_record');
    Route::put('/employee/{slug}/service_record', [ServiceRecordController::class,'update'])->name('employee.service_record');
    Route::delete('/employee/{slug}/service_record', [ServiceRecordController::class,'destroy'])->name('employee.service_record');

    /*Trainings*/
    Route::get('/employee/{slug}/training', [\App\Http\Controllers\HRU\Employees\TrainingsController::class,'index'])->name('employee.training');
    Route::post('/employee/{slug}/training', [\App\Http\Controllers\HRU\Employees\TrainingsController::class,'store'])->name('employee.training');
    Route::put('/employee/{slug}/training', [\App\Http\Controllers\HRU\Employees\TrainingsController::class,'update'])->name('employee.training');
    Route::delete('/employee/{slug}/training', [\App\Http\Controllers\HRU\Employees\TrainingsController::class,'destroy'])->name('employee.training');

    /*Education*/
    Route::get('/employee/{slug}/education', [\App\Http\Controllers\HRU\Employees\EducationController::class,'index'])->name('employee.education');
    Route::post('/employee/{slug}/education', [\App\Http\Controllers\HRU\Employees\EducationController::class,'store'])->name('employee.education');
    Route::put('/employee/{slug}/education', [\App\Http\Controllers\HRU\Employees\EducationController::class,'update'])->name('employee.education');
    Route::delete('/employee/{slug}/education', [\App\Http\Controllers\HRU\Employees\EducationController::class,'destroy'])->name('employee.education');

    /*Eligibility*/
    Route::get('/employee/{slug}/eligibility', [\App\Http\Controllers\HRU\Employees\EligibilityController::class,'index'])->name('employee.eligibility');
    Route::post('/employee/{slug}/eligibility', [\App\Http\Controllers\HRU\Employees\EligibilityController::class,'store'])->name('employee.eligibility');
    Route::put('/employee/{slug}/eligibility', [\App\Http\Controllers\HRU\Employees\EligibilityController::class,'update'])->name('employee.eligibility');
    Route::delete('/employee/{slug}/eligibility', [\App\Http\Controllers\HRU\Employees\EligibilityController::class,'destroy'])->name('employee.eligibility');

    /*Work */
    Route::get('/employee/{slug}/work', [\App\Http\Controllers\HRU\Employees\WorkController::class,'index'])->name('employee.work');
    Route::post('/employee/{slug}/work', [\App\Http\Controllers\HRU\Employees\WorkController::class,'store'])->name('employee.work');
    Route::put('/employee/{slug}/work', [\App\Http\Controllers\HRU\Employees\WorkController::class,'update'])->name('employee.work');
    Route::delete('/employee/{slug}/work', [\App\Http\Controllers\HRU\Employees\WorkController::class,'destroy'])->name('employee.work');

    /*201 Files */
    Route::get('/employee/{slug}/201', [\App\Http\Controllers\HRU\Employees\TwoZeroOneFilesController::class,'index'])->name('employee.201');
    Route::post('/employee/{slug}/201', [\App\Http\Controllers\HRU\Employees\TwoZeroOneFilesController::class,'store'])->name('employee.201');
    Route::put('/employee/{slug}/201', [\App\Http\Controllers\HRU\Employees\TwoZeroOneFilesController::class,'update'])->name('employee.201');
    Route::delete('/employee/{slug}/201', [\App\Http\Controllers\HRU\Employees\TwoZeroOneFilesController::class,'destroy'])->name('employee.201');


    /*Other HR Action */
    Route::get('/other_hr_actions_print/{slug}/{type}',[\App\Http\Controllers\HRU\Employees\OtherActionsController::class,'print'])->name('employee.other_hr_actions_print');
    Route::get('/other_hr_actions/{slug}',[\App\Http\Controllers\HRU\Employees\OtherActionsController::class,'index'])->name('employee.other_hr_actions');

    Route::get('/employee/{slug}/{type}/print', [\App\Http\Controllers\EmployeeController::class,'print'])->name('employee.print');

    Route::get('/employee/{slug}/201', [\App\Http\Controllers\HRU\Employees\TwoZeroOneFilesController::class,'index'])->name('employee.201');

    Route::get('/employee/credentials/{slug}', 'EmployeeCredentialsController@index')->name('employee.credentials');

//    Route::get('/employee/educ_bg/create/{slug}', 'Employee\EducationalBGController@create')->name('employee.educ_bg.create');
//    Route::get('/employee/educ_bg/edit/{slug}', 'Employee\EducationalBGController@edit')->name('employee.educ_bg.edit');
//    Route::patch('/employee/educ_bg/update/{slug}', 'Employee\EducationalBGController@update')->name('employee.educ_bg.update');
//    Route::delete('/employee/educ_bg/destroy/{slug}', 'Employee\EducationalBGController@destroy')->name('employee.educ_bg.destroy');
//    Route::post('/employee/educ_bg/store', 'Employee\EducationalBGController@store')->name('employee.educ_bg.store');

    Route::get('/employee/elig/create/{slug}', 'Employee\EligibilityController@create')->name('employee.elig.create');
    Route::get('/employee/elig/edit/{slug}', 'Employee\EligibilityController@edit')->name('employee.elig.edit');
    Route::patch('/employee/elig/update/{slug}', 'Employee\EligibilityController@update')->name('employee.elig.update');
    Route::delete('/employee/elig/destroy/{slug}', 'Employee\EligibilityController@destroy')->name('employee.elig.destroy');
    Route::post('/employee/elig/store', 'Employee\EligibilityController@store')->name('employee.elig.store');

    Route::get('/employee/work/create/{slug}', 'Employee\WorkExperienceController@create')->name('employee.work.create');
    Route::get('/employee/work/edit/{slug}', 'Employee\WorkExperienceController@edit')->name('employee.work.edit');
    Route::patch('/employee/work/update/{slug}', 'Employee\WorkExperienceController@update')->name('employee.work.update');
    Route::delete('/employee/work/destroy/{slug}', 'Employee\WorkExperienceController@destroy')->name('employee.work.destroy');
    Route::post('/employee/work/store', 'Employee\WorkExperienceController@store')->name('employee.work.store');

    Route::put('/employee/credentials/update/{slug}', 'EmployeeController@serviceRecordUpdate')->name('employee.credentials_update');
    Route::delete('/employee/credentials/destroy/{slug}', 'EmployeeController@serviceRecordDestroy')->name('employee.credentials_destroy');


//	Route::get('/employee/training/{slug}', 'EmployeeController@training')->name('employee.training');
//	Route::post('/employee/training/store/{slug}', 'EmployeeController@trainingStore')->name('employee.training_store');
//	Route::put('/employee/training/update/{slug}', 'EmployeeController@trainingUpdate')->name('employee.training_update');
//	Route::delete('/employee/training/destroy/{slug}', 'EmployeeController@trainingDestroy')->name('employee.training_destroy');
//	Route::get('/employee/training/print/{slug}', 'EmployeeController@trainingPrint')->name('employee.training_print');

	Route::get('/employee/matrix/{slug}', 'EmployeeController@matrix')->name('employee.matrix');
	Route::post('/employee/matrix/update/{slug}', 'EmployeeController@matrixUpdate')->name('employee.matrix_update');
	Route::get('/employee/matrix/show/{slug}', 'EmployeeController@matrixShow')->name('employee.matrix_show');
	Route::get('/employee/matrix/print/{slug}', 'EmployeeController@matrixPrint')->name('employee.matrix_print');

	Route::get('/employee/report', 'EmployeeController@report')->name('employee.report');
    Route::get('/employee/report_generate', 'EmployeeController@reportGenerate')->name('employee.report_generate');
    Route::get('/employee/index_cos', 'EmployeeController@indexCos')->name('employee.index_cos');


    Route::get('/employee/{slug}/{type}/print', \App\Http\Controllers\EmployeeController::class.'@print')->name('employee.print');

    Route::resource('employee', 'EmployeeController');


	Route::resource('file201','File201Controller');

    /** Employee Photo **/
    Route::post('/photo/{slug}','EmployeeController@updatePhoto')->name('employee.photo');
    Route::delete('/photo/{slug}','EmployeeController@deletePhoto')->name('employee.photo');
	/** DOCUMENTS **/
	Route::get('/document/print_qr/{slug}','DocumentController@printQr')->name('document.print_qr');
	Route::get('/document/report', 'DocumentController@report')->name('document.report');
	Route::get('/document/report_generate', 'DocumentController@report_generate')->name('document.report_generate');

	Route::get('/document/view_file/{slug}', 'DocumentController@viewFile')->name('document.view_file');

	Route::get('/document/download', 'DocumentController@download')->name('document.download');
    Route::post('/document/download', 'DocumentController@downloadPost')->name('document.download');
	Route::post('/document/download_direct/{slug}', 'DocumentController@downloadDirect')->name('document.download_direct');
	Route::get('/document/dissemination/{slug}', 'DocumentController@dissemination')->name('document.dissemination');
    Route::post('/document/dissemination/{slug}', \App\Http\Controllers\DocumentController::class.'@mailSingle')->name('document.dissemination');
	Route::post('/document/dissemination_post/{slug}', 'DocumentController@disseminationPost')->name('document.dissemination_post');
	Route::get('/document/rename_all', 'DocumentController@rename_all')->name('document.rename_all');
	Route::resource('document', 'DocumentController');
	Route::get('/document/dissemination/print/{slug}', 'DocumentController@print')->name('document.dissemination.print');

	/** Document Folder Codes **/
	Route::get('/document_folder/{folder_code}/browse', 'DocumentFolderController@browse')->name('document_folder.browse');
    Route::get('/document_folder/{folder_code}/download', 'DocumentFolderController@download')->name('document_folder.download');
	Route::resource('document_folder', 'DocumentFolderController');

    /** Document Request **/

    Route::get('/document_request/{slug}/signatories',[\App\Http\Controllers\RECORDS\DocumentRequestsController::class,'editSignatories'])->name('document_request.signatories');
    Route::patch('/document_request/{slug}/signatories',[\App\Http\Controllers\RECORDS\DocumentRequestsController::class,'updateSignatories'])->name('document_request.signatories');
    Route::get('/document_request/my',[\App\Http\Controllers\RECORDS\DocumentRequestsController::class,'my'])->name('document_request.my');
    Route::resource('document_request', \App\Http\Controllers\RECORDS\DocumentRequestsController::class);

    /** DMS Documents **/
    Route::resource('dms_document', \App\Http\Controllers\RECORDS\DMSDocumentsController::class);
    Route::get('/dms_document/{slug}/add',[\App\Http\Controllers\RECORDS\DMSDocumentsController::class,'addDmsDocument'])->name('dms_document.add');
    Route::get('/dms_document/{slug}/attachment',[\App\Http\Controllers\RECORDS\DMSDocumentsController::class,'showAttachment'])->name('dms_document.showAttachment');



    /** Email Contacts **/
	Route::resource('email_contact', 'EmailContactController');


	/** Permission Slip **/
    Route::patch('/permission_slip/{slug}/update_time_via_scan', 'PermissionSlipController@updateTimeOutViaScan')->name('permission_slip.update-time-via-scan');
    Route::get('/permission_slip/log', 'PermissionSlipController@scan')->name('permission_slip.log');
    Route::get('/permission_slip/report', 'PermissionSlipController@report')->name('permission_slip.report');
	Route::get('/permission_slip/report_generate', 'PermissionSlipController@reportGenerate')->name('permission_slip.report_generate');
    Route::get('/permission_slip/{slug}/update_time',[\App\Http\Controllers\PermissionSlipController::class,'editTime'])->name('permission_slip.update_time');
    Route::patch('/permission_slip/{slug}/update_time',[\App\Http\Controllers\PermissionSlipController::class,'updateTime'])->name('permission_slip.update_time');
    Route::resource('permission_slip', 'PermissionSlipController')->only(['index']);


	/** Leave Card **/
	Route::get('/leave_card/report', 'LeaveCardController@report')->name('leave_card.report');

    Route::get('/leave_card/{employeeSlug}/{leaveType}/view_per_leave_type', 'LeaveCardController@viewPerLeaveType')->name('leave_card.view_per_leave_type');
//    Route::post('/leave_card/{employeeSlug}/{leaveType}/view_per_leave_type', 'LeaveCardController@storeLeaveCredit')->name('leave_card.view_per_leave_type');

    Route::get('/leave_card/report_generate', 'LeaveCardController@reportGenerate')->name('leave_card.report_generate');
    Route::get('/leave_card/{slug}/print', 'LeaveCardController@print')->name('leave_card.print');

    Route::post('/leave_card/{employeeSlug}/{leaveType}/view_per_leave_type', [\App\Http\Controllers\LeaveCardController::class,'store'])->name('leave_card.store');
    Route::get('/leave_card/{slug}/beginning_balance', [\App\Http\Controllers\LeaveCardController::class,'editBeginningBalance'])->name('leave_card.beginning_balance');
    Route::match(['patch','put'],'/leave_card/{slug}/beginning_balance', [\App\Http\Controllers\LeaveCardController::class,'updateBeginningBalance'])->name('leave_card.beginning_balance');
    Route::resource('leave_card', 'LeaveCardController')->except(['store']);


	/** Applicant **/
	Route::post('/applicant/addToShortList/{slug}', 'ApplicantController@addToShortList')->name('applicant.add_to_shortlist');
	Route::post('/applicant/removeToShortList/{slug}', 'ApplicantController@removeToShortList')->name('applicant.remove_to_shortlist');
	Route::get('/applicant/report', 'ApplicantController@report')->name('applicant.report');
	Route::get('/applicant/report_generate', 'ApplicantController@reportGenerate')->name('applicant.report_generate');
	Route::resource('applicant', 'ApplicantController');


	/** Course **/
	Route::resource('course', 'CourseController');


	/** Plantilla **/
    Route::get('/plantilla/report', 'PlantillaController@report')->name('plantilla.report');
    Route::get('/plantilla/report_generate', 'PlantillaController@reportGenerate')->name('plantilla.report_generate');
	Route::resource('plantilla', 'PlantillaController');
    Route::resource('plantilla_employees', 'HrPayPlantillaEmployeesController');

    /** Activity Logs **/
    Route::get('/activity_logs/fetch_properties', 'ActivityLogsController@fetch_properties')->name('activity_logs_fetch_properties');

    /** PAP **/
    Route::resource('pap', 'PapController');

    /** PAP  Parents**/
    Route::resource('pap_parent', 'PapParentController');

    Route::resource('ppmp', 'PPMPController');

    /** DTR **/
    Route::get('/dtr/extract', 'DTRController@extract2')->name('dtr.extract');
    Route::get('/dtr/reconstruct', 'DTRController@reconstruct')->name('dtr.reconstruct');
//    Route::get('/dtr/my_dtr', 'DTRController@myDtr')->name('dtr.my_dtr');
//    Route::post('/dtr/download','DTRController@download')->name('dtr.download');

    Route::resource('dtr', 'DTRController');

    /** DTR **/
    Route::resource('jo_employees','JOEmployeesController');

    /** DTR **/
    Route::resource('news','NewsController')->except(['show']);

    /** DTR **/
    Route::get('holidays/fetch_google','HolidayController@fetchGoogleApi')->name('holidays.fetch_google');
    Route::resource('holidays','HolidayController');

    /** Biometric Devices **/
    Route::get('biometric_devices','BiometricDevicesController@index')->name('biometric_devices.index');
    Route::post('biometric_devices/extract','BiometricDevicesController@extract')->name('biometric_devices.extract');
    Route::post('biometric_devices/restart','BiometricDevicesController@restart')->name('biometric_devices.restart');
    Route::get('biometric_devices/attendances','BiometricDevicesController@attendances')->name('biometric_devices.attendances');
    Route::post('biometric_devices/clear_attendance','BiometricDevicesController@clear_attendance')->name('biometric_devices.clear_attendance');
    Route::get('biometric_device/admin','BiometricDevicesController@admin')->name('biometric_devices.admin');
    Route::post('biometric_device/admin_change_password','BiometricDevicesController@adminChangePassword')->name('biometric_devices.admin_change_password');
    Route::post('biometric_device/clear_admin','BiometricDevicesController@clearAdmin')->name('biometric_devices.clear_admin');

    Route::get('mis_requests','MisRequestsController@index')->name('mis_requests.index');
    Route::get('mis_requests/{slug}/edit','MisRequestsController@edit')->name('mis_requests.edit');
    Route::put('mis_requests/{request_slug}/update','MisRequestsController@update')->name('mis_requests.update');
    Route::resource('ip_address','IpAddressController');


    Route::resource('mis_requests_status','MisRequestsStatusController');

    /** Budget Proposal**/
    Route::resource('budget_proposal', 'BudgetProposalController');

    /** PPMP **/
    Route::resource('ppmp', 'PPMPController');







    /** Publication **/
    Route::get('publication/{slug}/print', 'HRU\PublicationController@print')->name('publication.print');
    Route::post('publication/{slug}/add_item','HRU\PublicationController@addItem')->name('publication.add_item');
    Route::get('publication/{itemSlug}/edit_item','HRU\PublicationController@editItem')->name('publication.edit_item');
    Route::patch('publication/{itemSlug}/update_item','HRU\PublicationController@updateItem')->name('publication.update_item');
    Route::delete('publication/{itemSlug}/destroy_item','HRU\PublicationController@destroyItem')->name('publication.destroy_item');

    Route::get('publication/{slug}/print_item', 'HRU\PublicationController@printItem')->name('publication.print_item');
    Route::post('publication/{slug}/add_item','HRU\PublicationController@addItem')->name('publication.add_item');


    Route::resource('publication',\App\Http\Controllers\HRU\PublicationController::class);

    /** Publication Applicants **/

    Route::get('publication_applicants/{slug}/assess', 'HRU\PublicationApplicantsController@assess')->name('publication_applicants.assess');
    Route::post('publication_applicants/{slug}/assess', 'HRU\PublicationApplicantsController@assessPost')->name('publication_applicants.assess');
    Route::delete('publication_applicants/{slug}/assess', 'HRU\PublicationApplicantsController@assessDisqualify')->name('publication_applicants.assess');
    Route::patch('publication_applicants/{slug}/assess', 'HRU\PublicationApplicantsController@assessFinalize')->name('publication_applicants.assess');
    Route::get('publication_applicants/{publication_detail_slug}', 'HRU\PublicationApplicantsController@index')->name('publication_applicants.index');
//    Route::resource('publication_applicants/{publication_detail_slug}');

    /** Payroll Template **/
    Route::resource('payroll_template',\App\Http\Controllers\HRU\PayrollTemplateController::class);
    /** Payroll Preparation **/
    Route::post('/payroll_preparation/{slug}/{status}/updateLockStatus',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@updateLockStatus')->name('payroll_preparation.updateLockStatus');
    Route::get('/payroll_preparation/{slug}/{type}/print',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@print')->name('payroll_preparation.print');
    Route::get('/payroll_preparation/{slug}/printRT',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@printRT')->name('payroll_preparation.printRT');
    Route::post('/payroll_preparation/{slug}/update',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@update')->name('payroll_preparation.update');
    Route::post('/payroll_preparation/{slug}/updateRataDed',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@updateRataDed')->name('payroll_preparation.updateRataDed');
    Route::resource('payroll_preparation',\App\Http\Controllers\HRU\PayrollPreparationController::class)->except(['update']);
    /* Payroll Refund */
    Route::get('payroll_refund/{payroll_slug}/show', [\App\Http\Controllers\HRU\PayrollRefundController::class,'show'])->name('payroll_refund.show');
    Route::get('payroll_refund/{payroll_slug}', [\App\Http\Controllers\HRU\PayrollRefundController::class,'index'])->name('payroll_refund.index');
    Route::resource('payroll_refund',\App\Http\Controllers\HRU\PayrollRefundController::class)->except(['index']);

    Route::get('rbac_evaluation/{slug}/print',[\App\Http\Controllers\RBAC\TWGEvaluation::class,'print'])->name('rbac_evaluation.print');
    Route::resource('rbac_evaluation',\App\Http\Controllers\RBAC\TWGEvaluation::class);

    Route::get('hr_requests/{slug}/print',[\App\Http\Controllers\HRU\HRRequestsController::class,'printDocument'])->name('hr_requests.print');
    Route::get('hr_requests/{slug}/printRequest',[\App\Http\Controllers\HRU\HRRequestsController::class,'printRequest'])->name('hr_requests.print_request');
    Route::get('hr_requests/{slug}/createDocument',[\App\Http\Controllers\HRU\HRRequestsController::class,'createDocument'])->name('hr_requests.create_document');Route::delete('hr_requests/{slug}/file',[\App\Http\Controllers\HRU\HRRequestsController::class,'deleteFile'])->name('hr_requests.file');
    Route::post('hr_requests/{slug}/file',[\App\Http\Controllers\HRU\HRRequestsController::class,'uploadFile'])->name('hr_requests.file');
    Route::post('hr_requests/{slug}/createDocument',[\App\Http\Controllers\HRU\HRRequestsController::class,'saveCreatedDocument'])->name('hr_requests.create_document');
    Route::put('hr_requests/{slug}/update',[\App\Http\Controllers\HRU\HRRequestsController::class,'update'])->name('hr_requests.update');
    Route::patch('hr_requests/{slug}/update',[\App\Http\Controllers\HRU\HRRequestsController::class,'patch'])->name('hr_requests.update');

    Route::resource('hr_requests',\App\Http\Controllers\HRU\HRRequestsController::class)->except(['update']);

    Route::resource('deduction_registry',\App\Http\Controllers\HRU\DeductionRegistryController::class)->only(['edit','update','index']);
    Route::resource('deduction_sudemupco',\App\Http\Controllers\HRU\DeductionSudemupcoController::class);

    Route::get('flight_booking/my',[\App\Http\Controllers\HRU\FlightBookingController::class,'my'])->name('flight_booking.my');
    Route::resource('flight_booking',\App\Http\Controllers\HRU\FlightBookingController::class);


    Route::resource('cos',\App\Http\Controllers\HRU\COSController::class);
    Route::get('cos_employees/{slug}/index',[\App\Http\Controllers\HRU\COSEmployeesController::class,'index'])->name('cos_employees.index');
    Route::post('cos_employees/{slug}/store',[\App\Http\Controllers\HRU\COSEmployeesController::class,'store'])->name('cos_employees.store');

    Route::resource('cos_employees',\App\Http\Controllers\HRU\COSEmployeesController::class)->except(['index','store']);
});

/** ADMIN LEVEL ROUTES REQUIRING PROJECT ID **/
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.',
    'middleware' => ['check.user_status', 'check.user_route', 'last_activity','verify.email','ensureUserHasProjectId']
], function () {

});


Route::group(['as' => 'public.',
], function () {
    Route::get('applicant_form/get_qs','Public\ApplicantFormController@getQs')->name('applicant_form.get_qs');
    Route::get('applicant_form','Public\ApplicantFormController@index');
    Route::post('applicant_form/submit','Public\ApplicantFormController@submit')->name('applicant_form.submit');
    Route::get('verify/document',[\App\Http\Controllers\Public\VerifierController::class,'verifyDocument'])->name('verify.document');
});

Route::get('display_qr/{slug}',function ($slug, \App\Http\Controllers\DocumentController $documentController){
    $document = \App\Models\Document::query()->where('slug','=',$slug)->first();
    $documentController->makeQR($document,$document->document_id);

    if(Auth::user()->project_id == 1){
        $storage =  \Illuminate\Support\Facades\Storage::disk('local');
    }else{
        $storage =  \Illuminate\Support\Facades\Storage::disk('qc_records');
    }
    return response()->file($storage->path('/QRCODE_TEMP/'.$document->document_id.'.png'));
})->name('display_qr');



Route::get('/dtr', function (){
    return redirect('/dashboard/dtr/my_dtr');
});

Route::get('/dashboard/compute', function (\App\Swep\Services\DTRService $service){

    return $service->compute();


});

/** Test Route **/

Route::get('/dashboard/test', function(){

	return dd([
	    'slug' => Illuminate\Support\Str::random(16),
        'small' => strtoupper(Illuminate\Support\Str::random(7)),
    ]);

});




Route::get('check_device',function (\App\Swep\Services\DTRService $DTRService){
    if(!request()->has('ip')){
        return 'Missing IP';
    }
    $port = request()->get('port') ?? 4370;

    $ip = request()->get('ip');

    $zk = new ZKTeco($ip);
    $zk->connect();
    $zk->enableDevice();

    return $zk->getAttendance();
//    return $DTRService->clearAttendance('10.36.1.23');
});

Route::get('dashboard/set', 'Pub\SetController@index')->name('dashboard.set');


Route::get('/phpinfo2',function (){
    echo phpinfo();
});





Route::get('/getSerial',function (\Illuminate\Http\Request $request){
    if(!$request->has('ip')){
        return 'IP Address missing';
    }
    $zk = new ZKTeco($request->ip);
    $zk->connect();
    return $zk->serialNumber();
});



Route::get('testMail',function (){

    dd(\Illuminate\Support\Facades\Mail::mailer('gmail_misvis')->send(new \App\Mail\SendMail('ss')));
});


Route::get('grab',function (){
    if(!request()->has('date')){
        return view('dashboard.gj.pre_grab');
    }
    return view('dashboard.gj.grab');
});
Route::get('grabc',function (){
    if(!request()->has('pickup_date')){
        return view('dashboard.gj.pre_grabc');
    }
    return view('dashboard.gj.grabc');
});

Route::get('/verifyEmail',function (){
    if(\Illuminate\Support\Facades\Auth::user()->email != null){
        return redirect('/');
    }
    return view('dashboard.verify_email.verify');
});

Route::post('/verifyEmail',function (\Illuminate\Http\Request $request){
    $request->validate([
        'email' => 'required|email',
    ]);
    $user = Auth::user();
    $user->email = $request->email;
    if($user->save()){
        return 1;
    }
    abort(503,'Error updating email.');
});


Route::resource('mail',\App\Http\Controllers\Test\MailController::class);
Route::get('/mails',function (){
    $connected = @fsockopen("www.google.com",80);
    $connected_2 = @fsockopen("www.yahoo.com",80);

        if(!$connected){
            if(!$connected_2){
                return "<center style='font-family:Arial; color:red; padding-top:100px; font-size:26px'><b>No internet or Server not responding</b></center>";
            }
        }

        $testMailData = [
            'title' => 'Test Email From SWEP',
            'body' => 'This is the body of test email.'
        ];

        Mail::to('gguance221@gmail.com')->send(new \App\Mail\SendMail($testMailData));

        dd('Success! Email has been sent successfully.');

});



Route::get('regions',function (){
    $regions = \App\Models\Temp\Sida\Regions::query()
        ->with(['provinces.municipalities.barangays'])
        ->get();
    //laravel collections MAP WITH KEYS
    $json = $regions->mapWithKeys(function ($region){
        return [
            //REGION
            $region->region => [
                'region_name' => 'REGION '.$region->region,
                'province_list' => $region->provinces->mapWithKeys(function ($province){
                    //PROVINCE
                    return [
                        $province->province => [
                            'municipality_list' => $province->municipalities->mapWithKeys(function ($municipality){
                                //MUNICIPALITY
                                return [
                                    $municipality->municipality => [
                                        //BARANGAY
                                        'barangay_list' => $municipality->barangays->map(function ($barangay){
                                            return $barangay->barangay;
                                        })
                                    ],
                                ];
                            }),
                        ],
                    ];
                }),
            ]
        ];
    });
    return Response::json($json,200,[],JSON_PRETTY_PRINT);
});






Route::get('/appearance',function (\Illuminate\Http\Request $request){
    if(!$request->has('date')){
        return  view('dashboard.public.appearance');
    }
    return view('printables.hru.certificate_of_appearance');
});





Route::get('/apiGetData',function (){
    $client = new \GuzzleHttp\Client(['base_uri' => 'http://localhost:8001/api/employees/getByEmployeeNo/KDD224']);
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDEvYXBpL2xvZ2luIiwiaWF0IjoxNzE4ODY3MDc1LCJleHAiOjE3MTg4NzA2NzUsIm5iZiI6MTcxODg2NzA3NSwianRpIjoiRFFaeHhsTmx4QzVBVEluRCIsInN1YiI6IjEiLCJwcnYiOiI0MGE5N2ZjYTJkNDI0ZTc3OGEwN2EwYTJmMTJkYzUxN2E4NWNiZGMxIn0.JgY21NuwtT5PMYqGYzt-FQoitvLjg8iMOOPuN0oJ5JI';
    $headers = [
        'Authorization' => 'Bearer ' . $token,
        'Accept'        => 'application/json',
        'Content-type' => 'application/json',
    ];
    try {
        // Make a GET request to the OpenWeather API
        $response = $client->request('GET','',[
            'headers' => $headers,
        ]);
        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        dd($data);

    } catch (\Exception $e) {
        // Handle any errors that occur during the API request
    }
});




Route::get('sendEvent',[\App\Http\Controllers\Test\TestController::class,'test']);
Route::get('monitor',[\App\Http\Controllers\Test\TestController::class,'monitor']);


Route::get('/leaveTest',function (\App\Swep\Services\HRU\LeaveCreditService $leaveCreditService){
    return $leaveCreditService->monthlyCreditToEmployees();
});



Route::get('/checkBlankDtr',function (){
    $start = 2000;
    $dateR = '2025-02%';
    $daily = \App\Models\DailyTimeRecord::query()
        ->where('date','like',$dateR)
        ->offset($start)
        ->limit(1000)
        ->get();
    $dtr = \App\Models\DTR::query()->selectRaw("user,type, DATE_FORMAT(timestamp, '%Y-%m-%d') as  date")->where('timestamp','like',$dateR)->get();

    $slugs = [];
    foreach ($daily as $dai){
        $count = 0;
        $dailyRecord = $dtr->where('date',$dai->date)
            ->where('user',$dai->biometric_user_id);
        if($dai->am_in != null){
            if($dailyRecord->where('type',10)->count() < 1){
                $slugs[$dai->biometric_user_id] = $dai->date.'---'.(10);
            }
        }
        if($dai->am_out != null){
            if($dailyRecord->where('type',20)->count() < 1){
                $slugs[$dai->biometric_user_id] = $dai->date.'---'.(20);
            }
        }
        if($dai->pm_in != null){
            if($dailyRecord->where('type',30)->count() < 1){
                $slugs[$dai->biometric_user_id] = $dai->date.'---'.(30);
            }
        }
        if($dai->pm_out != null){
            if($dailyRecord->where('type',40)->count() < 1){
                $slugs[$dai->biometric_user_id] = $dai->date.'---'.(40);
            }
        }
    }

    dd($slugs);
});


Route::get('testWs',function (){
    $r = \App\Models\MisRequests::query()->orderBy('created_at','desc')->firstOrFail();
    $rr = \App\Models\HRU\HRRequests::query()->firstOrFail();
    event(new \App\Events\MisRequest\NewRequest($r));
    event(new \App\Events\HrRequest\NewRequest($rr));
});


