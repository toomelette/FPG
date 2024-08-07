<?php

namespace App\Policies\HRU;

use Illuminate\Support\Facades\Auth;

class EmployeesPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }



    public function view(): bool
    {
        return Auth::user()->can('employees.view');
    }

    public function create(): bool
    {
        return Auth::user()->can('employees.store');
    }

    public function viewAny(): bool
    {
        return Auth::user()->can('employees.view-any');
    }

    public function update(): bool
    {
        return Auth::user()->can('employees.update');
    }

    public function delete(): bool
    {
        return \Auth::user()->can('employees.delete');
    }
}
