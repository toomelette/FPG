<?php

/** Auth **/

use App\Swep\Helpers\Helper;
use Rats\Zkteco\Lib\ZKTeco;
use SimpleSoftwareIO\QrCode\Facades\QrCode;




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
    Route::get('/profile', 'ProfileController@details')->name('profile.details');
    Route::patch('/profile/update_account_username/{slug}', 'ProfileController@updateAccountUsername')->name('profile.update_account_username');
    Route::patch('/profile/update_account_password/{slug}', 'ProfileController@updateAccountPassword')->name('profile.update_account_password');
    Route::patch('/profile/update_account_color/{slug}', 'ProfileController@updateAccountColor')->name('profile.update_account_color');
    Route::get('/profile/print_pds/{slug}/{page}', 'ProfileController@printPds')->name('profile.print_pds');
    Route::post('/profile/save_family_info','ProfileController@saveFamilyInfo')->name('profile.save_family_info');

    /** PROFILE SERVICE RECORD**/
    Route::get('/profile/service_record','ProfileController@serviceRecord')->name('profile.service_record');
    Route::post('/profile/service_record_store','ProfileController@serviceRecordStore')->name('profile.service_record_store');
    Route::put('/profile/service_record_update/{slug}','ProfileController@serviceRecordUpdate')->name('profile.service_record_update');
    Route::delete('/profile/service_record/destroy/{slug}','ProfileController@serviceRecordDestroy')->name('profile.service_record_destroy');

    Route::get('/profile/training','ProfileController@training')->name('profile.training');
    Route::post('/profile/training_store','ProfileController@trainingStore')->name('profile.training_store');
    Route::put('/profile/training_update/{slug}','ProfileController@trainingUpdate')->name('profile.training_update');
    Route::delete('/profile/training_destroy/{slug}','ProfileController@trainingDestroy')->name('profile.training_destroy');

    Route::get('/ajax/{for}','AjaxController@get')->name('ajax.get');
    Route::post('/ajaxPost/{for}','AjaxPostController@post')->name('ajax.post');
    Route::post('/profile/educ_bg_store','ProfileController@educationalBackgroundStore')->name('profile.educ_bg_store');
    Route::post('/profile/eligibility_store','ProfileController@eligibilityStore')->name('profile.eligibility_store');
    Route::post('/profile/work_experience_store','ProfileController@workExperienceStore')->name('profile.work_experience_store');

    Route::post('/profile/select_theme','ProfileController@selectTheme')->name('profile.select_theme');

    Route::get('/view_doc/{id}','NewsController@viewDoc')->name('news.view_doc');
    Route::get('/view_document/{id}/{type}','ViewDocument@index')->name('view_document.index');

    /** PERMISSION SLIPS **/
    Route::get('/permission_slips/my_permission_slips','PermissionSlipController@myPermissionSlips')->name('permission_slip.my_permission_slips');

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
	Route::resource('submenu','SubmenuController');

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
	Route::get('/leave_application/{slug}/print', 'LeaveApplicationController@print')->name('leave_application.print');
	Route::get('/leave_application/{slug}/save_as', 'LeaveApplicationController@saveAs')->name('leave_application.save_as');
	Route::resource('leave_application', 'LeaveApplicationController');


	/** EMPLOYEE **/
    Route::get('/employee/edit_bm_uid','EmployeeController@edit_bm_uid')->name('employee.edit_bm_uid');
    Route::post('/employee/update_bm_uid','EmployeeController@update_bm_uid')->name('employee.update_bm_uid');
	Route::get('/employee/print_pds/{slug}/{page}', 'EmployeeController@printPds')->name('employee.print_pds');
	
	Route::get('/employee/service_record/{slug}', 'EmployeeController@serviceRecord')->name('employee.service_record');
	Route::post('/employee/service_record/store/{slug}', 'EmployeeController@serviceRecordStore')->name('employee.service_record_store');
	Route::put('/employee/service_record/update/{slug}', 'EmployeeController@serviceRecordUpdate')->name('employee.service_record_update');
	Route::delete('/employee/service_record/destroy/{slug}', 'EmployeeController@serviceRecordDestroy')->name('employee.service_record_destroy');
	Route::get('/employee/service_record/print/{slug}', 'EmployeeController@serviceRecordPrint')->name('employee.service_record_print');

    Route::get('/employee/credentials/{slug}', 'EmployeeCredentialsController@index')->name('employee.credentials');

    Route::get('/employee/educ_bg/create/{slug}', 'Employee\EducationalBGController@create')->name('employee.educ_bg.create');
    Route::get('/employee/educ_bg/edit/{slug}', 'Employee\EducationalBGController@edit')->name('employee.educ_bg.edit');
    Route::patch('/employee/educ_bg/update/{slug}', 'Employee\EducationalBGController@update')->name('employee.educ_bg.update');
    Route::delete('/employee/educ_bg/destroy/{slug}', 'Employee\EducationalBGController@destroy')->name('employee.educ_bg.destroy');
    Route::post('/employee/educ_bg/store', 'Employee\EducationalBGController@store')->name('employee.educ_bg.store');

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


	Route::get('/employee/training/{slug}', 'EmployeeController@training')->name('employee.training');
	Route::post('/employee/training/store/{slug}', 'EmployeeController@trainingStore')->name('employee.training_store');
	Route::put('/employee/training/update/{slug}', 'EmployeeController@trainingUpdate')->name('employee.training_update');
	Route::delete('/employee/training/destroy/{slug}', 'EmployeeController@trainingDestroy')->name('employee.training_destroy');
	Route::get('/employee/training/print/{slug}', 'EmployeeController@trainingPrint')->name('employee.training_print');

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
    Route::get('/other_hr_actions_print/{slug}/{type}','EmployeeController@otherHrActionsPrint')->name('employee.other_hr_actions_print');
    Route::get('/other_hr_actions/{slug}','EmployeeController@otherHrActions')->name('employee.other_hr_actions');

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


	/** Email Contacts **/
	Route::resource('email_contact', 'EmailContactController');


	/** Permission Slip **/
	Route::get('/permission_slip/report', 'PermissionSlipController@report')->name('permission_slip.report');
	Route::get('/permission_slip/report_generate', 'PermissionSlipController@reportGenerate')->name('permission_slip.report_generate');
	Route::resource('permission_slip', 'PermissionSlipController');


	/** Leave Card **/
	Route::get('/leave_card/report', 'LeaveCardController@report')->name('leave_card.report');
	Route::get('/leave_card/report_generate', 'LeaveCardController@reportGenerate')->name('leave_card.report_generate');
    Route::get('/leave_card/{slug}/print', 'LeaveCardController@print')->name('leave_card.print');
    Route::resource('leave_card', 'LeaveCardController');


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
    Route::resource('news','NewsController');

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

    /** PPDO **/
    Route::resource('ppdo', 'PPU\PPDOController');






    /** Annual Budget **/
    Route::resource('annual_budget','Budget\AnnualBudgetController');

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

    Route::post('/payroll_preparation/{slug}/{status}/updateLockStatus',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@updateLockStatus')->name('payroll_preparation.updateLockStatus');
    Route::get('/payroll_preparation/{slug}/{type}/print',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@print')->name('payroll_preparation.print');
    Route::post('/payroll_preparation/{slug}/update',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@update')->name('payroll_preparation.update');
    Route::post('/payroll_preparation/{slug}/updateRataDed',\App\Http\Controllers\HRU\PayrollPreparationController::class.'@updateRataDed')->name('payroll_preparation.updateRataDed');
    Route::resource('payroll_preparation',\App\Http\Controllers\HRU\PayrollPreparationController::class)->except(['update']);

});

/** ADMIN LEVEL ROUTES REQUIRING PROJECT ID **/
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.',
    'middleware' => ['check.user_status', 'check.user_route', 'last_activity','verify.email','ensureUserHasProjectId']
], function () {
    /** ORS **/
    Route::get('ors/{slug}/print','Budget\ORSController@print')->name('ors.print');
    Route::get('ors/reports','Budget\ORSController@reports')->name('ors.reports');
    Route::get('ors/report_generate/{type}','Budget\ORSController@reportGenerate')->name('ors.report_generate');
    Route::resource('ors','Budget\ORSController');

    /** Projects **/
    Route::get('projects/{slug}/rs','Budget\ProjectsController@realigmentAndSupplemental')->name('projects.rs');
    Route::post('projects/{slug}/rs','Budget\ProjectsController@realigmentAndSupplementalPost')->name('projects.rs');
    Route::post('projects/{type}/adjustment','Budget\ProjectsController@adjustment')->name('projects.adjustment');
    Route::resource('projects','Budget\ProjectsController');

    /** ACCOUNTING **/
    /* Cash Receipts */
    Route::get('cash_receipts/{slug}/print', 'Accounting\CashReceiptsController@print')->name('cash_receipts.print');
    Route::resource('cash_receipts',\App\Http\Controllers\Accounting\CashReceiptsController::class);

    /* Check Disbursements */
    Route::get('check_disbursements/{slug}/print', 'Accounting\CheckDisbursementsController@print')->name('check_disbursements.print');
    Route::resource('check_disbursements',\App\Http\Controllers\Accounting\CheckDisbursementsController::class);

    /* General Journal */
    Route::get('general_journal/{slug}/print', 'Accounting\GeneralJournalController@print')->name('general_journal.print');
    Route::resource('general_journal',\App\Http\Controllers\Accounting\GeneralJournalController::class);

    /* Cash Disbursements Journal */
    Route::get('cash_disbursements/{slug}/print', 'Accounting\CashDisbursementsController@print')->name('cash_disbursements.print');
    Route::resource('cash_disbursements',\App\Http\Controllers\Accounting\CashDisbursementsController::class);
});


Route::group(['as' => 'public.',
], function () {
    Route::get('applicant_form/get_qs','Public\ApplicantFormController@getQs')->name('applicant_form.get_qs');
    Route::get('applicant_form','Public\ApplicantFormController@index');
    Route::post('applicant_form/submit','Public\ApplicantFormController@submit')->name('applicant_form.submit');
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
Route::get('/assign',function (){
    $users = \App\Models\User::query()->where('user_id','=','')->get();
    foreach ($users as $user){
        $user->user_id = rand(1111111,9999999);
        $user->update();
    }
    return 1;
});

Route::get('/dashboard/compute', function (\App\Swep\Services\DTRService $service){

    return $service->compute();


});

Route::get('/dashboard/tree', function (){
    return view('dashboard.blank');
});

Route::get('/file_explorer',function (){

   return view('dashboard.file_explorer.index');
})->name('dashboard.documents.file_explorer.index');

/** Test Route **/

Route::get('/dashboard/test', function(){

//    $zk = new ZKTeco('10.36.1.23');
//    //ini_set('max_execution_time', 300);
//    $zk->connect();
//    $zk->testVoice();
//    $zk->setTime('2022-01-04 14:59:03');
//
//    $zk->disconnect();

	return dd([
	    'slug' => Illuminate\Support\Str::random(16),
        'small' => strtoupper(Illuminate\Support\Str::random(7)),
    ]);

});

Route::get('dashboard/prayer', function (){
    $path = asset('json/quotes.json');
    $content = json_decode(file_get_contents($path),true);

    $today = Carbon::now()->format('Y-m-d');
    $qod_db = \App\Models\QuoteOfTheDay::query()->where('date',$today)->first();
    if(empty($qod_db)){
        $random = rand(0,1643);
        $qod = new \App\Models\QuoteOfTheDay();
        $qod->quote = $random;
        $qod->date = $today;
        $qod->save();

    }
    $qod_db_2 = \App\Models\QuoteOfTheDay::query()->where('date',$today)->first();
    return view('dashboard.prayer.index')->with([
        'qod' => $content[$qod_db_2->quote],
    ]);
})->name('dashboard.prayer');

Route::get('dashboard/zk_test',function (){

    $zk = new \Rats\Zkteco\Lib\ZKTeco('10.36.1.21');
    $zk->connect();

    return $zk->getUser();
    //return $zk->serialNumber();
});


Route::get('jo',function (){
   return view('dashboard.public.jo_entry')->with([
       'user_menus_records ' => '',

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


    return $zk->getAttendance();
//    return $DTRService->clearAttendance('10.36.1.23');
});

Route::get('dashboard/set', 'Pub\SetController@index')->name('dashboard.set');


Route::get('/phpinfo',function (){
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








Route::post('testMail',\App\Http\Controllers\DocumentController::class.'@mailSingle');
Route::get('sraLogo',function (){
    return response()->file('/SRA_DA logo.png');
});


Route::get('/acc',function (){
    $a = \App\Models\UserSubmenu::query()->where('user_id','=',\Illuminate\Support\Facades\Auth::user()->user_id)
        ->leftJoin('su_submenus','su_submenus.submenu_id','=','su_user_submenus.submenu_id')
        ->where('su_submenus.route','=','dashboard.dtr.store')
        ->first();
    return $a;
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

Route::get('summaryOfOrsWithProjects',function (\Illuminate\Http\Request $request){
    if(!$request->has('start') || !$request->has('end')){
        return view('dashboard.budget.ors.pre');
    }
    $arr = [];
    $start = $request->start;
    $end = $request->end;
    $burs = \App\Models\SqlServer\BUR::query()
        ->with('BURDetails')
        ->whereBetween('BURDate',[
            $start,$end
        ]);

    if(!empty($request->funds)){
        $funds = $request->funds;
        $burs = $burs->where(function ($q) use ($funds){
            foreach ($funds as $fund){
                $q = $q->orWhere('Funds','=',$fund);
            }
        });
    }

    $burs = $burs->orderBy('BURDate','asc')
        ->get();
    $cols = \App\Models\SqlServer\BURDet::query()
        ->whereHas('BURParentData',function ($q) use ($start,$end){
            return $q->whereBetween('BURDate',[
                $start,$end
            ]);
        })
        ->groupBy('Dept')->pluck('dept')->toArray();
    $colss = [];
    foreach ($cols as $col){
        $colss[$col] = null;
    }
    ksort($colss);

    foreach ($burs as $bur){
        $arr[$bur->BURNo]['obj'] = $bur;
        $arr[$bur->BURNo]['accountEntries'] = $colss;
        if(!empty($bur->BURDetails)){
            foreach ($bur->BURDetails as $det){
                $arr[$bur->BURNo]['accountEntries'][$det->Dept] = $arr[$bur->BURNo]['accountEntries'][$det->Dept] + $det->Debit;
            }
        }

        if(!empty($bur->BURProjApplied)){
            foreach ($bur->BURProjApplied as $proj){
                $arr[$bur->BURNo]['projectsApplied'][\Illuminate\Support\Str::random()] = $proj;
            }
        }
    }



    return view('printables.bur.bur_with_projects')->with([
        'burs' => $arr,
        'cols' => $colss,
    ]);
});
Route::get('count_bur',function (){
    $burs = \App\Models\SqlServer\BUR::query()
        ->with(['BURDetails','BURProjApplied','certified','budget'])
        ->where('BURDate','>=','2023-01-01')
        ->count();
    dd($burs);
});

Route::get('/migrate_bur',function (\Illuminate\Http\Request $request){
    //please resume on 44,000
    if(!$request->has('offset')){
        return 'Offset parameter missing';
    }
    $offset = $request->offset;

    $burs = \App\Models\SqlServer\BUR::query()
        ->with(['BURDetails','BURProjApplied','certified','budget'])
        ->where('BURDate','>=','2023-01-01')
        ->offset($offset)
        ->limit(1000)
        ->get();
    $orsArr = [];
    $orsDetailsArr = [];
    $orsProjectsAppliedArr = [];

    if($burs->isEmpty()){
        return 'NO records found';
    }

    foreach ($burs as $bur){
        $slug = \Illuminate\Support\Str::random();
        array_push($orsArr,[
            'slug' => $slug,
            'project_id' => 2,
            'ors_id' => $bur->BURID,
            'funds' => $bur->Funds,
            'ors_no' => $bur->BURNo,
            'base_ors_no' => null,
            'ors_date' => Carbon::parse($bur->BURDate)->format('Y-m-d'),
            'ref_book' => $bur->RefBook,
            'ref_doc' => $bur->RefDoc,
            'payee' => $bur->Payee,
            'office' => $bur->Office,
            'address' => $bur->Address,
            'particulars' => $bur->Particulars,
            'certified_by' => $bur->certified->SignName ?? $bur->CertifiedByInitial,
            'certified_by_position' => $bur->Position,
            'certified_budget_by' => $bur->budget->SignName ?? $bur->CertifiedBudget,
            'certified_budget_by_position' => $bur->BudgetPost,
            'amount' => $bur->BURAmt,
        ]);

        if(count($bur->BURDetailsAll) > 0){
            foreach ($bur->BURDetailsAll as $detail){
                array_push($orsDetailsArr,[
                    'slug' => \Illuminate\Support\Str::random(),
                    'project_id' => 2,
                    'ors_slug' => $slug,
                    'type' => $detail->BURorDV == 'BUR' ? 'ORS': $detail->BURorDV,
                    'seq_no' => $detail->SEQNO,
                    'resp_center' => null,
                    'dept' => $detail->Dept,
                    'unit' => $detail->DeptUnit,
                    'account_code' => $detail->AcctCode,
                    'debit' => $detail->Debit == 0 ? null : $detail->Debit,
                    'credit' => $detail->Credit == 0 ? null: $detail->Credit,
                ]);
            }
        }

        if(count($bur->BURProjApplied) > 0){
            foreach ($bur->BURProjApplied as $proj){
                array_push($orsProjectsAppliedArr,[
                    'slug' => Str::random(),
                    'project_id' => 2,
                    'ors_slug' => $slug,
                    'pap_code' => $proj->AcctCode,
                    'co' => $proj->CoAmt == 0 ? null : $proj->CoAmt,
                    'mooe' => $proj->Amount == 0 ? null : $proj->Amount,
                    'total' => $proj->CoAmt + $proj->Amount,
                ]);
            }
        }
    }
    \App\Models\Budget\ORS::insert($orsArr);
    \App\Models\Budget\ORSAccountEntries::insert($orsDetailsArr);
    \App\Models\Budget\ORSProjectsApplied::insert($orsProjectsAppliedArr);
    return $offset;
});

Route::get('migrate_coa',function (){
    $coa = \App\Models\SqlServer\COA::query()->get();
    $arr = [];
    foreach ($coa as $c){
        array_push($arr,[
            'slug' => \Illuminate\Support\Str::random(),
            'account_code' => $c->AccountCode,
            'account_title' => $c->AccountTitle,
            'account_init' => $c->AccountInit,
            'gl_group_id' => $c->GLGroupInd,
            'gl_group' => $c->GLGroup,
            'nature_id' => $c->NatureID,
            'bank_rec_account' => $c->BackRecAcct,
            'normal_bal' => $c->NormalBal,
            'isbs_accounts' => $c->ISBSAccts,
            'resp_center' => $c->RespCenterCode,
            'header_1' => $c->Header1,
            'header_2' => $c->Header2,
            'header_3' => $c->Header3,
            'name_of_collecting_officer' => $c->NameOfCollOfficer,
            'parent_account' => $c->ParentAcct,
            'child_account' => $c->ChildAcct,
            'has_sched' => $c->HasSched,
            'auto_dv' => $c->AUTODV,
            'fa_account' => $c->FAACCT,
            'for_or' => $c->ForOR,
            'taxable' => $c->Taxable,
            'bur_per_account' => $c->BURPERACCT,
            'bur_oblig' => $c->BUR_OBLIG,
            'bur_oblig_group' => $c->BUR_OBLIG_GROUP,
            'g1' => $c->G1,
            'g2' => $c->G2,
            'g4' => $c->G4,
            'treas_account' => $c->TREASACCT,
            'tax' => $c->TAX,
            'account_number' => $c->ACCOUNTNUMBER,
        ]);
    }
    \App\Models\Budget\ChartOfAccounts::insert($arr);
});

Route::get('/sqlsrv',function (){
   $serverName = '10.36.1.105\SRA';
   $connectionInfo = [
           'Database' => 'GASS',
           'UID' => 'sa',
           'PWD' => 'noliboy',
//            'Encrypt' => 'no',
//            'TrustServerCertificate' => true,
       ];
   $conn = sqlsrv_connect($serverName,$connectionInfo);
    if( $conn ) {
        echo "Connection established.<br />";
    }else{
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
    }
});


Route::get('numtowords',function (){
    $num = 1546;

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


Route::get('/checking',function (){
    $burs = \App\Models\SqlServer\BUR::query()->with(['BURProjApplied'])
        ->where('BURDate','>','2022-12-31')
        ->whereHas('BURProjApplied',function ($q){
            return $q->where('COAmt','>',0);
        })
        ->get();
    foreach ($burs as $bur){
        echo $bur->BURNo.'<hr>';
        foreach($bur->BURProjApplied as $d){
            echo $d->COAmt.'<br>';
        }
        echo '<br><br>';
    }
}
);

Route::get('fullPather',function (){
    $file201s = \App\Models\EmployeeFile201::query()
        ->whereNull('full_path')
        ->get();
    foreach ($file201s as $file201){
        $file201->full_path = '/File201/'.$file201->employee_no.'/'.$file201->filename;
        $file201->save();
    }
    dd(1);
});





Route::get('/update_plantilla',function(){
    $items = DB::table('aa_temp_items')->get();
    foreach ($items as $item){
        $p = \App\Models\HRPayPlanitilla::query()->where('item_no','=',$item->item_no)->first();
        if(!empty($p)){
            $p->qs_education = $item->qs_education;
            $p->qs_training = $item->qs_training;
            $p->qs_experience = $item->qs_experience;
            $p->qs_eligibility = $item->qs_eligibility;
            $p->qs_competency = $item->qs_competency;
            $p->place_of_assignment = $item->place_of_assignment;
            $p->csc_position = $item->position;
            $p->save();
        }
    }
    return 1;
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


Route::get('update_qc_employees',function (){
    $employeesQc = \App\Models\QC\Employee::query()->get();
    $employeeTableColumns = Schema::connection('afd_qc')->getColumnListing('hr_employees');

    unset($employeeTableColumns[array_search('biometric_user_id',$employeeTableColumns)]);
    unset($employeeTableColumns[array_search('id',$employeeTableColumns)]);

    $employeesNotFoundInBcd = [];

    foreach ($employeesQc as $employeeQc){
        $employeeBcd = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        if(empty($employeeBcd)){
            $employeeBcd = new \App\Models\Employee();
            foreach ($employeeTableColumns as $columnName){
                $employeeBcd->$columnName = $employeeQc->$columnName;
            }
            $employeeBcd->save();
        }else{
            foreach ($employeeTableColumns as $columnName){
                $employeeBcd->$columnName = $employeeQc->$columnName;
            }
            $employeeBcd->save();
        }
    }

    dd('Finished');
    dd($employeesQc);
});

Route::get('update_qc_employees_201',function () {
    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas('file201s')
        ->get();

    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->file201s()->delete();
        if($employeeQc->file201s->count() > 0){
            $file201ToInsert = [];
            foreach ($employeeQc->file201s as $file201){
                $file201Array = $file201->toArray();
                unset($file201Array['id']);
                array_push($file201ToInsert,$file201Array);
            }
            \App\Models\EmployeeFile201::insert($file201ToInsert);
        }
    }
    dd('Finished');

});

Route::get('update_qc_employees_sr',function () {
    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas('employeeServiceRecord')
        ->get();
    
    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->employeeServiceRecord()->delete();
        if($employeeQc->employeeServiceRecord->count() > 0){
            $employeeServiceRecordsToInsert = [];
            foreach ($employeeQc->employeeServiceRecord as $sr){
                $srArray = $sr->toArray();
                unset($srArray['id']);

                array_push($employeeServiceRecordsToInsert,$srArray);
            }

            \App\Models\EmployeeServiceRecord::insert($employeeServiceRecordsToInsert);
        }
    }
    dd('Finished Service Record');
});

Route::get('update_qc_employees_trainings',function () {

    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas('employeeTraining')
        ->get();

    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->employeeTraining()->delete();
        if($employeeQc->employeeTraining->count() > 0){
            $employeeTrainingsToInsert = [];
            foreach ($employeeQc->employeeTraining as $training){
                $trainingsArray = $training->toArray();
                unset($trainingsArray['id']);

                array_push($employeeTrainingsToInsert,$trainingsArray);
            }

            \App\Models\EmployeeTraining::insert($employeeTrainingsToInsert);
        }
    }
    dd('Finished Trainings');
});


Route::get('update_qc_employees_educ',function () {

    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas('employeeEducationalBackground')
        ->get();

    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->employeeEducationalBackground()->delete();
        if($employeeQc->employeeEducationalBackground->count() > 0){
            $employeeEducationalBackgroundsToInsert = [];
            foreach ($employeeQc->employeeEducationalBackground as $educ){
                $educsArray = $educ->toArray();
                unset($educsArray['id']);

                array_push($employeeEducationalBackgroundsToInsert,$educsArray);
            }

            \App\Models\EmployeeEducationalBackground::insert($employeeEducationalBackgroundsToInsert);
        }
    }
    dd('Finished Educational Background');
});

Route::get('update_qc_employees_elig',function () {

    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas('employeeEligibility')
        ->get();

    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->employeeEligibility()->delete();
        if($employeeQc->employeeEligibility->count() > 0){
            $employeeEligibilitysToInsert = [];
            foreach ($employeeQc->employeeEligibility as $elig){
                $eligsArray = $elig->toArray();
                unset($eligsArray['id']);

                array_push($employeeEligibilitysToInsert,$eligsArray);
            }

            App\Models\EmployeeEligibility::insert($employeeEligibilitysToInsert);
        }
    }
    dd('Finished Eligibility');
});





Route::get('update_qc_employees_family',function () {

    $about = 'employeeFamilyDetail';
    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas($about)
        ->get();


    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->employeeFamilyDetail()->delete();

        $employeeQc->$about;
        $classNameOfRelationShip = get_class($employeeQc->$about()->getRelated());
        $tableName = with(new $classNameOfRelationShip())-> getTable();

        $columnsOfRelationShip = Schema::connection('afd_qc')->getColumnListing($tableName);
        unset($columnsOfRelationShip[array_search('id',$columnsOfRelationShip)]);
        $newEmployee = new \App\Models\EmployeeFamilyDetail();

        foreach ($columnsOfRelationShip as $col){
            $newEmployee->$col = $employeeQc->$about->$col;
        }


        $newEmployee->save();

    }
    dd('Finished '.$about);
});
Route::get('update_qc_employees_has_one',function () {

    $about = \Illuminate\Support\Facades\Request::get('about');
    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas($about)
        ->get();

    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();

        if(!empty($employeeBCD)){
            $employeeBCD->$about()->delete();

            $employeeQc->$about;
            $classNameOfRelationShip = get_class($employeeQc->$about()->getRelated());
            $tableName = with(new $classNameOfRelationShip())-> getTable();

            $columnsOfRelationShip = Schema::connection('afd_qc')->getColumnListing($tableName);
            unset($columnsOfRelationShip[array_search('id',$columnsOfRelationShip)]);
            $class = str_replace('QC\\','',get_class($employeeQc->$about()->getRelated()));
            $newEmployee =  new $class();

            foreach ($columnsOfRelationShip as $col){
                $newEmployee->$col = $employeeQc->$about->$col;
            }

            $newEmployee->save();
        }
    }
    dd('Finished '.$about);
});


Route::get('update_qc_employees_has_many',function () {

    $about = \Illuminate\Support\Facades\Request::get('about');
    $relationClass = App\Models\EmployeeExperience::class;

    $employeesQc = \App\Models\QC\Employee::query()
        ->whereHas($about)
        ->get();
    $class = '';
    foreach ($employeesQc as $employeeQc){
        $employeeBCD = \App\Models\Employee::query()->where('slug','=',$employeeQc->slug)->first();
        $employeeBCD->$about()->delete();
        if($employeeQc->$about->count() > 0){
            $toInsert = [];
            foreach ($employeeQc->$about as $sigleData){
                $class = str_replace('QC\\','',get_class($employeeQc->$about()->getRelated()));
                $sigleDataArray = $sigleData->toArray();
                unset($sigleDataArray['id']);

                array_push($toInsert,$sigleDataArray);
            }

            $class::insert($toInsert);
        }
    }
    dd('Finished '.$about);
});

Route::get('update',function (\Illuminate\Http\Request $request){

    $relations = [
        'employeeVoluntaryWork',
        'employeeTraining',
        'employeeSpecialSkill',
        'employeeServiceRecord',
        'employeeReference',
        'employeeRecognition',
        'employeeOtherQuestion',
        'employeeOrganization',
        'employeeMedicalHistories',
        'employeeMatrix',
        'employeeHealthDeclaration',
        'file201s',
        'employeeFamilyDetail',
        'employeeExperience',
        'employeeEligibility',
        'employeeEducationalBackground',
        'employeeChildren',
        'employeeAddress',
        'empBeginningCredits',
        'dtr_records',
        'documentDisseminationLog',
        'user',
    ];

    if(isset($relations[$request->current])){
        $relation = $relations[$request->current];
        $employees = \App\Models\Employee::query()
            ->whereHas($relation,function ($q){
                return $q->where('employee_slug','=',null);
            })
            ->get();

        foreach ($employees as $employee){
            $employee->$relation()->update([
                'employee_slug' => $employee->slug,
            ]);
        }
        return redirect()->route('updateee',[
            'current' => $request->current + 1,
        ]);
    }else{
        dd('Done all.');
    }
})->name('updateee');


Route::get('/user', function(){

    $zk = new ZKTeco('10.36.1.23');
    //ini_set('max_execution_time', 300);
    $zk->connect();

    $employees = \App\Models\Employee::query()
        ->where('biometric_user_id','!=',null)
        ->where(function ($q){
            $q->where('locations','=','VISAYAS')
            ->orWhere('locations','=','COS-VISAYAS');
        })
        ->get()
        ->mapWithKeys(function ($data){
            return [
                $data->biometric_user_id => $data
            ];
        });

    foreach (collect($zk->getUser())->toArray() as $id => $data){
        if (isset($employees[$id])){

            $new_uid = $data['uid'];
            $new_userid = $data['userid'];
            $new_name = \Illuminate\Support\Str::limit($employees[$id]->firstname.' '.$employees[$id]->lastname,24);
            $new_password = $data['password'];
            $zk->setUser($new_uid,$new_userid,$new_name,$new_password,\Rats\Zkteco\Lib\Helper\Util::LEVEL_USER,"0000000000");
        }

    }


    return $zk->getUser();

});

Route::get('/lgarec', function(){
    $last = \App\Models\DTR::query()
        ->where('location','=','LGAREC API')
        ->orderBy('lgarec_id','desc')
        ->first()->lgarec_id ?? 0;

    $lgarec = 'http://122.52.169.219:8001/api/dtr_data?last='.$last;
    $response = file_get_contents($lgarec);
    $newsData = collect(json_decode($response))->chunk(1000);

    foreach ($newsData as $dtrs) {
        $arr = [];
        foreach ($dtrs as $dtr){
            array_push($arr,[
                'lgarec_id' => $dtr->id,
                'uid' => $dtr->uid,
                'user' => $dtr->user,
                'state' => $dtr->state,
                'type' => $dtr->type,
                'timestamp' => $dtr->timestamp,
                'device' => $dtr->device,
                'created_at' => \Carbon\Carbon::now(),
                'location' => 'LGAREC API',
            ]);
        }
        if(\App\Models\DTR::insert($arr)){
            $count = $newsData->flatten()->count();
            \App\Models\CronLogs::insert([
                'log' => 'API: Copied '.$count.' data from LGAREC',
                'type' => 10,
                'created_at' => Carbon::now(),
            ]);
        }else{
            \App\Models\CronLogs::insert([
                'log' => 'API Failed',
                'type' => 11,
                'created_at' => Carbon::now(),
            ]);
        }
    }
    dd($newsData->flatten()->count());
});

Route::get('/filesize',function (){
   $docs  = \App\Models\Document::query()
       ->where('filesize','=',null)
       ->get();
    foreach ($docs as $doc) {
        if(\Illuminate\Support\Facades\File::exists(env('STORAGE_LOCATION').$doc->path.$doc->filename)){
            $size = File::size(env('STORAGE_LOCATION').$doc->path.$doc->filename);
            $doc->filesize = $size;
            $doc->save();
        }
   }
    return 1;
});

Route::get('/setTime',function (){
    $biometrics = \App\Models\BiometricDevices::query()
        ->where('status','=',1)
        ->get();
    $logs = [];
   foreach ($biometrics as $biometric){
       $zk = new \Rats\Zkteco\Lib\ZKTeco($biometric->ip_address);
       $zk->connect();
       $zk->setTime(Carbon::now()->format(\Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s')));
       array_push($logs,[
           'log' => 'Time reset successful: '.$biometric->ip_address,
           'type' => 4,
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
       ]);
   }
   \App\Models\CronLogs::insert($logs);
});

Route::get('/appearance',function (\Illuminate\Http\Request $request){
    if(!$request->has('date')){
        return  view('dashboard.public.appearance');
    }
    return view('printables.hru.certificate_of_appearance');
});



Route::get('/appointmentxxxxx',function (\Illuminate\Http\Request $request){
    $emps = \App\Models\Employee::query()
        ->where(function ($q){
            $q->where('locations','=','COS-VISAYAS')
                ->orWhere('locations','=','COS-LUZMIN')
                ->orWhere('locations','=','VISAYAS')
                ->orWhere('locations','=','LUZON/MINDANAO');
        })
        ->get();
    foreach ($emps as $emp) {
        switch ($emp->locations) {
            case 'VISAYAS':
            case 'LUZON':
                $emp->appointment_status = 'Permanent';
                break;
            case 'COS-VISAYAS':
            case 'COS-LUZMIN':
                $emp->appointment_status = 'COS';
                break;

        }
        $emp->save();
    }
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