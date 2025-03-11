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



