<?php




Route::get('/getEmployee/{id}','Api\Employee\ApiEmployeeController@getEmployee');

Route::get('/g',function (\Illuminate\Http\Request $request){
    $employee = \App\Models\Employee::query()
        ->where('employee_no','=',$request->employee_no)
        ->first();

    return $employee;
});

Route::controller(\App\Http\Controllers\Api\AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'employees'],function (){
    Route::controller(App\Http\Controllers\Api\Employee\ApiEmployeeController::class)->group(function (){
        Route::get('all','all');
        Route::get('getByEmployeeNo/{employee_no}','getByEmployeeNo');
        Route::post('store','store');
    });
});

Route::group(['middleware' => [], 'prefix' => 'dtr'],function (){
    Route::controller(App\Http\Controllers\Api\DTR\ApiQC_DTRController::class)->group(function (){
        Route::post('accept','accept');
        Route::post('updateBiometricId','updateBiometricId');
    });
});

Route::group(['middleware' => [], 'prefix' => 'validate'],function (){
    Route::controller(App\Http\Controllers\Api\Validate\ValidationController::class)->group(function (){
        Route::post('bmuid','bmuid');
        Route::post('employee_no','employeeNo');
    });
});


Route::group(['middleware' => ['auth:api'], 'prefix' => 'dtr-qc'],function (){
    Route::controller(App\Http\Controllers\Api\DTR\QcDtrController::class)->group(function (){
        Route::post('store','store');
    });
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'dtr-lgarec'],function (){
    Route::controller(App\Http\Controllers\Api\DTR\LgarecDtrController::class)->group(function (){
        Route::post('store','store');
    });
});

//Route::group(['prefix' => 'dms-records'],function (){
//    Route::controller(App\Http\Controllers\Api\Records\DMSController::class)->group(function (){
//        Route::post('store','store');
//    });
//});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'dms-records'],function () {
    Route::post('/store', [App\Http\Controllers\Api\Records\DMSController::class, 'store']);
    Route::post('/test-upload', [\App\Http\Controllers\Api\Records\DMSController::class, 'testUpload']);

});



