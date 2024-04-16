<?php



// Employee
Route::get('/employee/serviceRecord/{slug}/edit', 'Api\ApiEmployeeController@editServiceRecord')
		->name('api.employee_serviceRecord_edit');


Route::get('/employee/training/{slug}/edit', 'Api\ApiEmployeeController@editTraining')
		->name('api.employee_training_edit');




// User
Route::get('/user/response_from_employee/{slug}', 'Api\ApiUserController@responseFromEmployee')
		->name('api.user_response_from_employee');




// Submenu
Route::get('/submenu/select_submenu_byMenuId/{menu_id}', 'Api\ApiSubmenuController@selectSubmenuByMenuId')
		->name('selectSubmenuByMenuId');




// Department Unit
Route::get('/department_unit/select_departmentUnit_byDeptName/{dept_name}', 'Api\ApiDepartmentUnitController@selectDepartmentUnitByDepartmentName')
		->name('selectDepartmentUnitByDepartmentName');


Route::get('/department_unit/select_departmentUnit_byDeptId/{dept_id}', 'Api\ApiDepartmentUnitController@selectDepartmentUnitByDepartmentId')
		->name('selectDepartmentUnitByDepartmentId');




// Project Code
Route::get('/project_code/select_projectCode_byDeptName/{dept_name}', 'Api\ApiProjectCodeController@selectProjectCodeByDepartmentName')
		->name('selectProjectCodeByDepartmentName');




// Department
Route::get('/department/textbox_department_ByDepartmentId/{dept_id}', 'Api\ApiDepartmentController@textboxDepartmentByDepartmentId')
		->name('textboxDepartmentByDepartmentId');


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

Route::controller(App\Http\Controllers\Api\Employee\ApiEmployeeController::class)->group(function (){
    Route::get('getEmployees','getAll');
    Route::get('getEmployeeByEmployeeNo/{employee_no}','getEmployeeByEmployeeNo');
})->middleware('auth:api');