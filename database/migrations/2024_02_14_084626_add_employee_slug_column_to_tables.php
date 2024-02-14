<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function __construct(){
        $this->tables = [
            'hr_employee_voluntary_works',
            'hr_employee_trainings',
            'hr_employee_special_skills',
            'hr_employee_service_records',
            'hr_employee_references',
            'hr_employee_recognitions',
            'hr_employee_other_questions',
            'hr_employee_organizations',
            'hr_employee_medical_history',
            'hr_employee_matrix',
            'hr_employee_health_declaration',
            'hr_employee_file201',
            'hr_employee_family_details',
            'hr_employee_experiences',
            'hr_employee_eligibilities',
            'hr_employee_educational_background',
            'hr_employee_children',
            'hr_employee_address',
            'hr_emp_beginning_credits',
            'hr_daily_time_records',
            'rec_document_dissemination_logs',
            'users',
        ];
    }
    public function up()
    {
        foreach ($this->tables as $table){
            if(Schema::hasColumn($table,'slug')){
                if(!Schema::hasColumn($table,'employee_slug')){
                    Schema::table($table, function (Blueprint $table) {
                        $table->string('employee_slug')->after('slug')->nullable();
                    });
                }
            }else{
                if(!Schema::hasColumn($table,'employee_slug')){
                    Schema::table($table, function (Blueprint $table) {
                        $table->string('employee_slug')->after('id')->nullable();
                    });
                }
            }

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('employee_slug');
            });
        }
    }
};
