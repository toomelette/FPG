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


Route::get('/home', 'HomeController@index')->name('home')->middleware(['check.user_status']);
//Route::get('dashboard/home', 'HomeController@index')->name('dashboard.home')->middleware(['check.user_status','verify.email']);


Route::get('/dashboard/plantilla/print','PlantillaController@print')->name('plantilla.print');


//USER LEVEL ROUTES
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.',
    'middleware' => ['check.user_status', 'last_activity','sidenav_mw', 'verify.email']
], function () {

    Route::get('/employee/{slug}/qr','EmployeeController@generateQr')->name('employee.generate_qr');

    /** PROFILE **/
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class,'index'])->name('profile');
    Route::get('/profile/payslip', [\App\Http\Controllers\ProfileController::class,'payslipShow'])->name('profile.payslip');
    Route::post('/profile/payslip', [\App\Http\Controllers\ProfileController::class,'payslipVerifyPassword'])->name('profile.payslip');
    Route::get('/profile_details', [\App\Http\Controllers\ProfileController::class,'index'])->name('profile.details');
    Route::patch('/profile/update_password', [\App\Http\Controllers\ProfileController::class,'updatePassword'])->name('profile.update_password');
    Route::delete('/profile/signOutDevice', [\App\Http\Controllers\ProfileController::class,'signOutDevice'])->name('profile.sign_out_device');

    Route::get('/ajax/{for}','AjaxController@get')->name('ajax.get');
    Route::post('/ajaxPost/{for}','AjaxPostController@post')->name('ajax.post');

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






	/** MENU **/
	Route::resource('menu', 'MenuController');

    /** MENU **/
    Route::get('/submenu/fetch','SubmenuController@fetch')->name('submenu.fetch');
    Route::get('submenu/{slug}',[\App\Http\Controllers\SubmenuController::class,'index'])->name('submenu.index');
    Route::get('submenu/{slug}/show',[\App\Http\Controllers\SubmenuController::class,'show'])->name('submenu.show');
    Route::post('submenu/{slug}',[\App\Http\Controllers\SubmenuController::class,'store'])->name('submenu.store');
    Route::delete('submenu/{slug}/revoke',[\App\Http\Controllers\SubmenuController::class,'revoke'])->name('submenu.revoke_permission');
	Route::resource('submenu','SubmenuController')->except(['index','store','show']);



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


});

Route::group([
    'middleware' => ['check.user_status', 'check.user_route', 'last_activity','verify.email']
], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('clients',\App\Http\Controllers\FG\ClientController::class);
    Route::resource('projects',\App\Http\Controllers\FG\ProjectsController::class);
    Route::resource('project-expense-liquidation',\App\Http\Controllers\FG\ProjectExpenseLiquidationController::class);
    Route::resource('sales-invoice',\App\Http\Controllers\FG\SalesInvoiceController::class);
    Route::resource('collections',\App\Http\Controllers\FG\CollectionsController::class);
    Route::resource('payroll-template',\App\Http\Controllers\FG\PayrollTemplateController::class);
    Route::resource('payroll-preparation',\App\Http\Controllers\FG\PayrollPreparationController::class);
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


Route::get('/phpinfo2',function (){
    echo phpinfo();
});

Route::get('sendEvent',[\App\Http\Controllers\Test\TestController::class,'test']);
Route::get('monitor',[\App\Http\Controllers\Test\TestController::class,'monitor']);

Route::get('testWs',function (){
    $r = \App\Models\MisRequests::query()->orderBy('created_at','desc')->firstOrFail();
    $rr = \App\Models\HRU\HRRequests::query()->firstOrFail();
    event(new \App\Events\MisRequest\NewRequest($r));
    event(new \App\Events\HrRequest\NewRequest($rr));
});


Route::get('testWs',function (){
    $r = \App\Models\MisRequests::query()->orderBy('created_at','desc')->firstOrFail();
    $rr = \App\Models\HRU\HRRequests::query()->firstOrFail();
    event(new \App\Events\MisRequest\NewRequest($r));
    event(new \App\Events\HrRequest\NewRequest($rr));
});


