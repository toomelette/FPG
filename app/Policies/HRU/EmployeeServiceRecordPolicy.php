<?php

namespace App\Policies\HRU;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeServiceRecordPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny()
    {
        return Auth::user()->can('employees.service-record.view-any');
    }

    public function update()
    {
        return Auth::user()->can('employees.service-record.update');
    }

    public function delete()
    {
        return Auth::user()->can('employees.service-record.destroy');
    }

}
