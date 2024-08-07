<?php

namespace App\Swep\Interfaces;
 


interface EmployeeInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $employee);

	public function destroy($slug);

	public function findBySlug($slug);

	public function findByUserId($user_id);

	public function findByEmployeeNo($employee_no);

	public function getAll();

	public function getBySlug($slug);

	public function getByIsActive($status);

	public function getBySex($sex);

	public function getByDepartmentId($dept);

	
	public function storeFamilyDetails($request, $employee);

	public function storeAddress($request, $employee);

	public function storeQuestions($request, $employee);

	public function storeChildren($row, $employee);

	public function storeEducationalBackground($row, $employee);

	public function storeEligibility($row, $employee);

	public function storeExperience($row, $employee);

	public function storeVoluntaryWork($row, $employee);

	public function storeRecognition($row, $employee);

	public function storeOrganization($row, $employee);

	public function storeSpecialSkill($row, $employee);

	public function storeReference($row, $employee);

		
}