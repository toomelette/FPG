<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\EmployeeServiceRecord;
use App\Policies\HRU\EmployeeServiceRecordPolicy;
use App\Policies\HRU\EmployeesPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        Employee::class => EmployeesPolicy::class,
//        EmployeeServiceRecord::class => EmployeeServiceRecordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
