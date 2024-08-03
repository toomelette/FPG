<?php

namespace App\Providers;


use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider{

    
    public function boot(){

        /** VIEW COMPOSERS  **/


        // USERMENU
        View::composer(['layouts.admin-sidenav','dashboard.blank'], 'App\Swep\ViewComposers\UserMenuComposer');

        //TREE
        View::composer(['layouts.admin-sidenav','dashboard.blank'], 'App\Swep\ViewComposers\TreeComposer');
        View::composer(['adminkit.sidebar','dashboard.blank'], 'App\Swep\ViewComposers\TreeComposer');
        // MENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Swep\ViewComposers\MenuComposer');
        

        // SUBMENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Swep\ViewComposers\SubmenuComposer');


        // PROJECT
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index',
                        'dashboard.disbursement_voucher.save_as',
                        'dashboard.employee.create',
                        'dashboard.employee.edit',], 'App\Swep\ViewComposers\ProjectComposer');


        // FUND SOURCE
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.save_as',
                        'dashboard.disbursement_voucher.user_index'], 'App\Swep\ViewComposers\FundSourceComposer');
        


        // DEPARTMENT
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index',
                        'dashboard.disbursement_voucher.save_as',
                        'dashboard.department_unit.create',
                        'dashboard.department_unit.edit',
                        'dashboard.project_code.create',
                        'dashboard.project_code.edit',
                        'dashboard.employee.create',
                        'dashboard.employee.edit',
                        'dashboard.permission_slip.report',
                        'dashboard.employee.index'], 'App\Swep\ViewComposers\DepartmentComposer');


        // DEPARTMENT UNITS
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index',
                        'dashboard.disbursement_voucher.save_as',
                        'dashboard.employee.create',
                        'dashboard.employee.edit',
                        'dashboard.plantilla.create',
                        'dashboard.plantilla.edit',
                        'dashboard.plantilla.index',
                        'dashboard.plantilla.report',
                        'dashboard.applicant.create',
                        'dashboard.applicant.edit',
                        'dashboard.applicant.index',
                        'dashboard.applicant.report',], 'App\Swep\ViewComposers\DepartmentUnitComposer');


        // PROJECT CODES
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.save_as',
                        'dashboard.disbursement_voucher.user_index'], 'App\Swep\ViewComposers\ProjectCodeComposer');
        

        // SIGNATORIES
        View::composer(['printables.disbursement_voucher.dv_front',
                        'dashboard.leave_application.create',
                        'dashboard.leave_application.edit',
                        'dashboard.signatory.create',
                        'dashboard.signatory.edit'], 'App\Swep\ViewComposers\SignatoryComposer');



        // EMPLOYEES
        View::composer(['dashboard.user.sync_employee',
                        'dashboard.permission_slip.create',
                        'dashboard.permission_slip.edit',
                        'dashboard.permission_slip.index',
                        'dashboard.leave_card.create',
                        'dashboard.leave_card.edit',
                        'dashboard.leave_card.index',
                        'dashboard.leave_card.report',
                        'dashboard.document.dissemination',], 'App\Swep\ViewComposers\EmployeeComposer');



        // DOCUMENT FOLDER
        View::composer(['dashboard.document.create',
                        'dashboard.document.edit',
                        'dashboard.document.index',
                        'dashboard.document.download',], 'App\Swep\ViewComposers\DocumentFolderComposer');



        // COURSE
        View::composer(['dashboard.applicant.create',
                        'dashboard.applicant.edit',
                        'dashboard.applicant.index',
                        'dashboard.applicant.report',], 'App\Swep\ViewComposers\CourseComposer');



        // Plantilla
        View::composer(['dashboard.applicant.create',
                        'dashboard.applicant.edit',
                        'dashboard.applicant.index',], 'App\Swep\ViewComposers\PlantillaComposer');



        // EMAIL CONTACTS
        View::composer(['dashboard.document.dissemination',], 'App\Swep\ViewComposers\EmailContactComposer');



        
    }

    




    
    public function register(){

      


    
    }




}
