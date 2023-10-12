<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model{



    protected $connection = 'afd_qc';

	protected $table = 'hr_employee_address';

    public $timestamps = false;
    
    




	protected $attributes = [
        
        'employee_no' => '',
        'res_address_block' => '',
        'res_address_street' => '',
        'res_address_village' => '',
        'res_address_barangay' => '',
        'res_address_city' => '',
        'res_address_province' => '',
        'res_address_zipcode' => '',
        'perm_address_block' => '',
        'perm_address_street' => '',
        'perm_address_village' => '',
        'perm_address_barangay' => '',
        'perm_address_city' => '',
        'perm_address_province' => '',
        'perm_address_zipcode' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }





    /** Getters **/
    public function getFullResAddressAttribute(){

        return $this->res_address_barangay .' '. $this->res_address_city .', '. $this->res_address_province;
    
    }


    public function getFullPermAddressAttribute(){

        return $this->perm_address_barangay .' '. $this->perm_address_city .', '. $this->perm_address_province;
    
    }
   






}
