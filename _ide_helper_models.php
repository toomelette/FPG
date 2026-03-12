<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Api{
/**
 * App\Models\Api\User
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $username
 * @property string|null $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $project_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent implements \PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\Applicant
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantEducationalBackground> $applicantEducationalBackground
 * @property-read int|null $applicant_educational_background_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantEligibility> $applicantEligibility
 * @property-read int|null $applicant_eligibility_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantExperience> $applicantExperience
 * @property-read int|null $applicant_experience_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantTraining> $applicantTraining
 * @property-read int|null $applicant_training_count
 * @property-read \App\Models\Course|null $course
 * @property-read \App\Models\DepartmentUnit|null $departmentUnit
 * @property-read \App\Models\Plantilla|null $plantilla
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantPositionApplied> $positionApplied
 * @property-read int|null $position_applied_count
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant sortable($defaultParameters = null)
 */
	class Applicant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantEducationalBackground
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground query()
 */
	class ApplicantEducationalBackground extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantEligibility
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility query()
 */
	class ApplicantEligibility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantExperience
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience query()
 */
	class ApplicantExperience extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantPositionApplied
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @property-read \App\Models\HRPayPlanitilla|null $item
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied query()
 */
	class ApplicantPositionApplied extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantTraining
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining query()
 */
	class ApplicantTraining extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BiometricDevices
 *
 * @property int $id
 * @property string $name
 * @property string $serial_no
 * @property string $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property int|null $last_uid
 * @property string|null $remarks
 * @property string|null $last_cleared
 * @property string|null $last_cleared_user
 * @property int|null $last_state
 * @property string|null $last_state_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DTR> $attendances
 * @property-read int|null $attendances_count
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices query()
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereLastCleared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereLastClearedUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereLastState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereLastStateTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereLastUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereUpdatedAt($value)
 */
	class BiometricDevices extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\AnnualBudget
 *
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccount
 * @property-read \App\Models\PPU\RCDesc|null $dept
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget query()
 */
	class AnnualBudget extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\ChartOfAccounts
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $account_code
 * @property string|null $account_title
 * @property string|null $account_init
 * @property int|null $gl_group_id
 * @property string|null $gl_group
 * @property int|null $nature_id
 * @property int|null $bank_rec_account
 * @property int|null $normal_bal
 * @property int|null $isbs_accounts
 * @property int|null $resp_center
 * @property int|null $header_1
 * @property int|null $header_2
 * @property int|null $header_3
 * @property string|null $name_of_collecting_officer
 * @property string|null $parent_account
 * @property string|null $child_account
 * @property int|null $has_sched
 * @property int|null $auto_dv
 * @property int|null $fa_account
 * @property int|null $for_or
 * @property int|null $taxable
 * @property int|null $bur_per_account
 * @property string|null $bur_oblig
 * @property int|null $bur_oblig_group
 * @property string|null $g1
 * @property string|null $g2
 * @property string|null $g4
 * @property int|null $treas_account
 * @property int|null $tax
 * @property string|null $account_number
 * @property int|null $payroll
 * @property int|null $cv_report
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\ORSAccountEntries> $orsEntries
 * @property-read int|null $ors_entries_count
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts coAccountsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereAccountInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereAccountTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereAutoDv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereBankRecAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereBurOblig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereBurObligGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereBurPerAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereChildAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereCvReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereFaAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereForOr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereG1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereG2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereG4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereGlGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereGlGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereHasSched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereHeader1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereHeader2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereHeader3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereIsbsAccounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereNameOfCollectingOfficer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereNatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereNormalBal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereParentAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts wherePayroll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccounts whereTreasAccount($value)
 */
	class ChartOfAccounts extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\ORS
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\ORSAccountEntries> $accountEntries
 * @property-read int|null $account_entries_count
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\ORSAccountEntries> $dvEntries
 * @property-read int|null $dv_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\ORSAccountEntries> $orsEntries
 * @property-read int|null $ors_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\ORSProjectsApplied> $projectsApplied
 * @property-read int|null $projects_applied_count
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|ORS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORS query()
 */
	class ORS extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\ORSAccountEntries
 *
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccount
 * @property-read \App\Models\Budget\ORS|null $ors
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries dvEntriesOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries orsEntriesOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries query()
 */
	class ORSAccountEntries extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\ORSProjectsApplied
 *
 * @property-read \App\Models\Budget\ORS|null $ors
 * @property-read \App\Models\PPU\Pap|null $pap
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied query()
 */
	class ORSProjectsApplied extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\PapAdjustments
 *
 * @property-read \App\Models\PPU\Pap|null $destinationPap
 * @property-read \App\Models\PPU\Pap|null $sourcePap
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments query()
 */
	class PapAdjustments extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Course
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $course_id
 * @property string|null $acronym
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereAcronym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUserUpdated($value)
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CronLogs
 *
 * @property int $id
 * @property string $log
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs query()
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CronLogs whereUpdatedAt($value)
 */
	class CronLogs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DTR
 *
 * @property-read \App\Models\BiometricDevices|null $deviceDetails
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\Employee|null $employeeUnion
 * @property-read \App\Models\Employee|null $permanentEmployees
 * @method static \Illuminate\Database\Eloquent\Builder|DTR newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTR newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTR query()
 */
	class DTR extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DTREdits
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits query()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits withoutTrashed()
 */
	class DTREdits extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DailyTimeRecord
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DTREdits> $edits
 * @property-read int|null $edits_count
 * @property-read \App\Models\User|null $remarksUpdater
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord query()
 */
	class DailyTimeRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property mixed name
 * @property mixed department_id
 * @property mixed slug
 * @property int $id
 * @property string|null $slug
 * @property string|null $department_id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DepartmentUnit> $departmentUnit
 * @property-read int|null $department_unit_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DepartmentUnit> $departmentUnits
 * @property-read int|null $department_units_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employee
 * @property-read int|null $employee_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectCode> $projectCode
 * @property-read int|null $project_code_count
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUserUpdated($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DepartmentTree
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DepartmentTree> $children
 * @property-read int|null $children_count
 * @property-read DepartmentTree|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrPlantilla> $plantillas
 * @property-read int|null $plantillas_count
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentTree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentTree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentTree query()
 */
	class DepartmentTree extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DepartmentUnit
 *
 * @property mixed description
 * @property mixed id
 * @property mixed slug
 * @property mixed department_id
 * @property mixed name
 * @property mixed department_no
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed user_created
 * @property mixed user_updated
 * @property mixed ip_created
 * @property mixed ip_updated
 * @property int $id
 * @property string|null $slug
 * @property string|null $department_unit_id
 * @property string|null $department_id
 * @property string|null $department_name
 * @property string|null $name
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Applicant> $applicant
 * @property-read int|null $applicant_count
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employee
 * @property-read int|null $employee_count
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereDepartmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereDepartmentUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUnit whereUserUpdated($value)
 */
	class DepartmentUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DisbursementVoucher
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $dv_id
 * @property string|null $user_id
 * @property string|null $doc_no
 * @property string|null $dv_no
 * @property string|null $date
 * @property string|null $project_id
 * @property string|null $fund_source_id
 * @property string|null $fund_source
 * @property string|null $mode_of_payment
 * @property string|null $mode_of_payment_specify
 * @property string|null $payee
 * @property string|null $address
 * @property string|null $tin
 * @property string|null $bur_no
 * @property string|null $department_name
 * @property string|null $department_unit_name
 * @property string|null $project_code
 * @property string|null $explanation
 * @property string|null $amount
 * @property string|null $certified_supervisor
 * @property string|null $certified_supervisor_position
 * @property string|null $certified_by
 * @property string|null $certified_by_position
 * @property string|null $approved_by
 * @property string|null $approved_by_position
 * @property string|null $processed_at
 * @property string|null $checked_at
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $tax_base
 * @property float|null $vat_percent
 * @property string|null $vat_amount
 * @property float|null $w_tax_percent
 * @property string|null $w_tax_amount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\DepartmentUnit|null $departmentUnit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DisbursementVoucherDetails> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\FundSource|null $fundSource
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereApprovedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereBurNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereCertifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereCertifiedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereCertifiedSupervisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereCertifiedSupervisorPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereDepartmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereDepartmentUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereDocNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereDvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereDvNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereExplanation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereFundSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereFundSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereModeOfPaymentSpecify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher wherePayee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereProjectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereTaxBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereVatPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereWTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucher whereWTaxPercent($value)
 */
	class DisbursementVoucher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DisbursementVoucherDetails
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $dv_slug
 * @property string|null $dv_id
 * @property string|null $resp_center
 * @property string|null $mfo_pap
 * @property string|null $amount
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereDvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereDvSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereMfoPap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisbursementVoucherDetails whereSlug($value)
 */
	class DisbursementVoucherDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLog
 * @property-read int|null $document_dissemination_log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLogAll
 * @property-read int|null $document_dissemination_log_all_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLogSendCopy
 * @property-read int|null $document_dissemination_log_send_copy_count
 * @property-read \App\Models\DocumentFolder|null $folder
 * @property-read \App\Models\DocumentFolder|null $folder2
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentDisseminationLog
 *
 * @property-read \App\Models\Document|null $document
 * @property-read \App\Models\EmailContact|null $emailContact
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog logs()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog sendCopyLogs()
 */
	class DocumentDisseminationLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentFolder
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents1
 * @property-read int|null $documents1_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents2
 * @property-read int|null $documents2_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder query()
 */
	class DocumentFolder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailContact
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLog
 * @property-read int|null $document_dissemination_log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLogAll
 * @property-read int|null $document_dissemination_log_all_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLogSendCopy
 * @property-read int|null $document_dissemination_log_send_copy_count
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact query()
 */
	class EmailContact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmpBeginningCredits
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $bigbal_vacation_leave
 * @property string|null $bigbal_sick_leave
 * @property string|null $bigbal_overtime
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits whereBigbalOvertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits whereBigbalSickLeave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits whereBigbalVacationLeave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpBeginningCredits whereId($value)
 */
	class EmpBeginningCredits extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $user_id
 * @property string|null $project_id
 * @property string|null $department_id
 * @property string|null $department_unit_id
 * @property string|null $dept_name
 * @property string|null $unit_name
 * @property string|null $employee_no
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $name_ext
 * @property string|null $prefix
 * @property string|null $fullname
 * @property string|null $date_of_birth
 * @property string|null $place_of_birth
 * @property string|null $sex
 * @property string|null $civil_status
 * @property string|null $height
 * @property string|null $weight
 * @property string|null $blood_type
 * @property string|null $citizenship
 * @property string|null $citizenship_type
 * @property string|null $dual_citizenship_country
 * @property string|null $tel_no
 * @property string|null $cell_no
 * @property string|null $email
 * @property string|null $agency_no
 * @property string|null $gov_id
 * @property string|null $license_passport_no
 * @property string|null $id_date_issue
 * @property string|null $gsis
 * @property string|null $philhealth
 * @property string|null $sss
 * @property string|null $tin
 * @property string|null $hdmf
 * @property string|null $hdmfpremiums
 * @property string|null $appointment_status
 * @property string|null $position
 * @property int|null $item_no
 * @property int|null $salary_grade
 * @property int|null $sg
 * @property int|null $step_inc
 * @property string|null $monthly_basic
 * @property string|null $aca
 * @property string|null $pera
 * @property string|null $food_subsidy
 * @property string|null $ra
 * @property string|null $ta
 * @property string|null $cs_eligibility
 * @property string|null $cs_eligibility_level
 * @property string|null $firstday_gov
 * @property string|null $firstday_sra
 * @property string|null $appointment_date
 * @property string|null $adjustment_date
 * @property string|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property int $biometric_user_id
 * @property string|null $locations
 * @property string|null $resp_center
 * @property string|null $place_of_assignment
 * @property string|null $remarks
 * @property string $station
 * @property string|null $assignment
 * @property string|null $assignment_details
 * @property int|null $as_signatory
 * @property string|null $photo
 * @property string|null $date_of_separation
 * @property string|null $reason_of_separation
 * @property string|null $tax_rate
 * @property string|null $payroll_group
 * @property bool|null $is_board_member
 * @property array|null $deduction_groups
 * @property array|null $other_hr_actions_data
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\DTR|null $amInToday
 * @property-read mixed $attr_appointment_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\COSEmployees> $cosEmployees
 * @property-read int|null $cos_employees_count
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\DepartmentUnit|null $departmentUnit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLog
 * @property-read int|null $document_dissemination_log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyTimeRecord> $dtr_records
 * @property-read int|null $dtr_records_count
 * @property-read \App\Models\EmpBeginningCredits|null $empBeginningCredits
 * @property-read \App\Models\SqlServer\EmpMaster|null $empMaster
 * @property-read \App\Models\EmployeeAddress|null $employeeAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeChildren> $employeeChildren
 * @property-read int|null $employee_children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeEducationalBackground> $employeeEducationalBackground
 * @property-read int|null $employee_educational_background_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeEligibility> $employeeEligibility
 * @property-read int|null $employee_eligibility_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeExperience> $employeeExperience
 * @property-read int|null $employee_experience_count
 * @property-read \App\Models\EmployeeFamilyDetail|null $employeeFamilyDetail
 * @property-read \App\Models\EmployeeHealthDeclaration|null $employeeHealthDeclaration
 * @property-read \App\Models\EmployeeMatrix|null $employeeMatrix
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeMedicalHistory> $employeeMedicalHistories
 * @property-read int|null $employee_medical_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeOrganization> $employeeOrganization
 * @property-read int|null $employee_organization_count
 * @property-read \App\Models\EmployeeOtherQuestion|null $employeeOtherQuestion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeRecognition> $employeeRecognition
 * @property-read int|null $employee_recognition_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeReference> $employeeReference
 * @property-read int|null $employee_reference_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeServiceRecord> $employeeServiceRecord
 * @property-read int|null $employee_service_record_count
 * @property-read \App\Models\EmployeeServiceRecord|null $employeeServiceRecordLatest
 * @property-read \App\Models\EmployeeServiceRecord|null $employeeServiceRecordSecondToLatest
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeSpecialSkill> $employeeSpecialSkill
 * @property-read int|null $employee_special_skill_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeTraining> $employeeTraining
 * @property-read int|null $employee_training_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeVoluntaryWork> $employeeVoluntaryWork
 * @property-read int|null $employee_voluntary_work_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeFile201> $file201s
 * @property-read int|null $file201s_count
 * @property-read mixed $full
 * @property-read mixed $full_name
 * @property-read mixed $incentive_monthly_basic
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SqlServer\IncentiveTemplate> $incentiveTemplate
 * @property-read int|null $incentive_template_count
 * @property-read mixed $jg_monthly_basic
 * @property-read \App\Models\DTR|null $lastRawDtrRecord
 * @property-read mixed $leave_balances
 * @property-read \App\Models\HRU\LeaveBeginningBalance|null $leaveBegBal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveCard> $leaveCard
 * @property-read int|null $leave_card_count
 * @property-read mixed $middle_initial
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateDeductions> $nonZeroDeductions
 * @property-read int|null $non_zero_deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateIncentives> $nonZeroIncentives
 * @property-read int|null $non_zero_incentives_count
 * @property-read \App\Models\HRU\HrOtherActions|null $otherNosa
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterEmployees> $payrollEmployees
 * @property-read int|null $payroll_employees_count
 * @property-read \App\Models\HRU\PayrollEmployeeSettings|null $payrollSettings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PermissionSlip> $permissionSlip
 * @property-read int|null $permission_slip_count
 * @property-read mixed $photo_path
 * @property-read \App\Models\HRPayPlanitilla|null $plantilla
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DTR> $rawDtrRecords
 * @property-read int|null $raw_dtr_records_count
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateDeductions> $templateDeductions
 * @property-read int|null $template_deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateIncentives> $templateIncentives
 * @property-read int|null $template_incentives_count
 * @property-read \App\Models\HRU\TemplateIncentives|null $templateMonthlyBasic
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee active()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee applyProjectId()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee cos()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countByDeptUnit($dept_unit_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countBySex($sex)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countBySexAndDeptUnit($dept_unit_id, $sex)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee luzMin()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee permanent()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee receivesEitherRaOrTa()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee receivesHazardPrc()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee removeBoardMember()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee vis()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAdjustmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAgencyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAsSignatory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAssignmentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBiometricUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCellNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCitizenshipType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCsEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCsEligibilityLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDateOfSeparation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeductionGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDepartmentUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeptName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDualCitizenshipCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstdayGov($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstdaySra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFoodSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGovId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHdmf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHdmfpremiums($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIdDateIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIsBoardMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLicensePassportNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOtherHrActionsData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePayrollGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePera($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhilhealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePlaceOfAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereReasonOfSeparation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStepInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTelNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereWeight($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeAddress
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $res_address_block
 * @property string|null $res_address_street
 * @property string|null $res_address_village
 * @property string|null $res_address_barangay
 * @property string|null $res_address_city
 * @property string|null $res_address_province
 * @property string|null $res_address_zipcode
 * @property string|null $perm_address_block
 * @property string|null $perm_address_street
 * @property string|null $perm_address_village
 * @property string|null $perm_address_barangay
 * @property string|null $perm_address_city
 * @property string|null $perm_address_province
 * @property string|null $perm_address_zipcode
 * @property-read \App\Models\Employee|null $employee
 * @property-read mixed $full_perm_address
 * @property-read mixed $full_res_address
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressVillage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress wherePermAddressZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressVillage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeAddress whereResAddressZipcode($value)
 */
	class EmployeeAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeChildren
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $fullname
 * @property string|null $date_of_birth
 * @property string|null $school_company
 * @property string|null $civil_status
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereSchoolCompany($value)
 */
	class EmployeeChildren extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeEducationalBackground
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $level
 * @property int|null $priority
 * @property string|null $school_name
 * @property string|null $course
 * @property string|null $date_from
 * @property string|null $date_to
 * @property float|null $units
 * @property string|null $graduate_year
 * @property string|null $scholarship
 * @property string|null $honor
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $system_remarks
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereGraduateYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereHonor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereScholarship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereSystemRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground withoutTrashed()
 */
	class EmployeeEducationalBackground extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeEligibility
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $eligibility
 * @property string|null $level
 * @property float|null $rating
 * @property string|null $exam_place
 * @property string|null $exam_date
 * @property string|null $license_no
 * @property string|null $license_validity
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $system_remarks
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereExamDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereExamPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereLicenseValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility whereSystemRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEligibility withoutTrashed()
 */
	class EmployeeEligibility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeExperience
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $position
 * @property string|null $company
 * @property string|null $salary
 * @property int|null $salary_grade
 * @property int|null $step
 * @property string|null $appointment_status
 * @property int|null $is_gov_service
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $system_remarks
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereIsGovService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience whereSystemRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeExperience withoutTrashed()
 */
	class EmployeeExperience extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeFamilyDetail
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $spouse_lastname
 * @property string|null $spouse_firstname
 * @property string|null $spouse_middlename
 * @property string|null $spouse_name_ext
 * @property string|null $spouse_birthdate
 * @property string|null $spouse_occupation
 * @property string|null $spouse_employer
 * @property string|null $spouse_business_address
 * @property string|null $spouse_tel_no
 * @property string|null $father_lastname
 * @property string|null $father_firstname
 * @property string|null $father_middlename
 * @property string|null $father_name_ext
 * @property string|null $mother_lastname
 * @property string|null $mother_firstname
 * @property string|null $mother_middlename
 * @property string|null $mother_name_ext
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereFatherFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereFatherLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereFatherMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereFatherNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereMotherFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereMotherLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereMotherMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereMotherNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseBusinessAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFamilyDetail whereSpouseTelNo($value)
 */
	class EmployeeFamilyDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeFile201
 *
 * @property int $id
 * @property string $slug
 * @property string|null $employee_slug
 * @property string $employee_no
 * @property string|null $date
 * @property string $title
 * @property string $description
 * @property string|null $type
 * @property string|null $full_path
 * @property string $original_filename
 * @property string $filename
 * @property string|null $file_ext
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string $system_remarks
 * @property-read \App\Models\Employee|null $employeeData
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereFileExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereFullPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereSystemRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereUserUpdated($value)
 */
	class EmployeeFile201 extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeHealthDeclaration
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $family_doctor
 * @property string|null $contact_person
 * @property string|null $contact_person_phone
 * @property string|null $cities_ecq
 * @property string|null $been_sick
 * @property string|null $been_sick_yes_details
 * @property string|null $fever_colds
 * @property string|null $fever_colds_yes_details
 * @property string|null $smoking
 * @property string|null $smoking_yes_details
 * @property string|null $drinking
 * @property string|null $drinking_yes_details
 * @property string|null $taking_drugs
 * @property string|null $taking_drugs_yes_details
 * @property string|null $taking_vitamins
 * @property string|null $taking_vitamins_yes_details
 * @property string|null $eyeglasses
 * @property string|null $eyeglasses_yes_details
 * @property string|null $exercise
 * @property string|null $exercise_yes_details
 * @property string|null $being_treated
 * @property string|null $being_treated_yes_details
 * @property string|null $chronic_injuries
 * @property string|null $chronic_injuries_yes_details
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereBeenSick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereBeenSickYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereBeingTreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereBeingTreatedYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereChronicInjuries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereChronicInjuriesYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereCitiesEcq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereContactPersonPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereDrinking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereDrinkingYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereExercise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereExerciseYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereEyeglasses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereEyeglassesYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereFamilyDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereFeverColds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereFeverColdsYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereSmoking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereSmokingYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereTakingDrugs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereTakingDrugsYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereTakingVitamins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeHealthDeclaration whereTakingVitaminsYesDetails($value)
 */
	class EmployeeHealthDeclaration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeMatrix
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $educ_bachelors_degree
 * @property string|null $educ_undergrad_bachelor_units_earned
 * @property string|null $educ_undergrad_bachelor
 * @property string|null $educ_masters_degree
 * @property string|null $educ_doctoral_degree
 * @property string|null $educ_undergrad_masteral_units_earned
 * @property string|null $educ_undergrad_masteral
 * @property string|null $educ_grad_certificate_course
 * @property string|null $educ_distinctions_summa_cum_laude
 * @property string|null $educ_distinctions_magna_cum_laude
 * @property string|null $educ_distinctions_cum_laude
 * @property string|null $educ_distinctions_pres_awardee
 * @property string|null $educ_distinctions_csc_sra_da_awardee
 * @property string|null $educ_distinctions_top_gov_exam
 * @property string|null $experience_years
 * @property string|null $experience_req_years
 * @property string|null $experience
 * @property string|null $training_req_no
 * @property string|null $training_no
 * @property string|null $training
 * @property string|null $eligibility
 * @property string|null $performance
 * @property string|null $behavior_point_score
 * @property string|null $behavior
 * @property string|null $psycho_test_point_score
 * @property string|null $psycho_test
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereBehavior($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereBehaviorPointScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducBachelorsDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDistinctionsCscSraDaAwardee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDistinctionsCumLaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDistinctionsMagnaCumLaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDistinctionsPresAwardee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDistinctionsSummaCumLaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDistinctionsTopGovExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducDoctoralDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducGradCertificateCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducMastersDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducUndergradBachelor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducUndergradBachelorUnitsEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducUndergradMasteral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEducUndergradMasteralUnitsEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereExperienceReqYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereExperienceYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix wherePerformance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix wherePsychoTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix wherePsychoTestPointScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereTrainingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMatrix whereTrainingReqNo($value)
 */
	class EmployeeMatrix extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeMedicalHistory
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $medical_history
 * @property string|null $medication
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereMedicalHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereMedication($value)
 */
	class EmployeeMedicalHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeOrganization
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $name
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereName($value)
 */
	class EmployeeOrganization extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeOtherQuestion
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property int|null $q_34_a
 * @property int|null $q_34_b
 * @property string|null $q_34_b_yes_details
 * @property int|null $q_35_a
 * @property string|null $q_35_a_yes_details
 * @property int|null $q_35_b
 * @property string|null $q_35_b_yes_details_1
 * @property string|null $q_35_b_yes_details_2
 * @property int|null $q_36
 * @property string|null $q_36_yes_details
 * @property int|null $q_37
 * @property string|null $q_37_yes_details
 * @property int|null $q_38_a
 * @property string|null $q_38_a_yes_details
 * @property int|null $q_38_b
 * @property string|null $q_38_b_yes_details
 * @property int|null $q_39
 * @property string|null $q_39_yes_details
 * @property int|null $q_40_a
 * @property string|null $q_40_a_yes_details
 * @property int|null $q_40_b
 * @property string|null $q_40_b_yes_details
 * @property int|null $q_40_c
 * @property string|null $q_40_c_yes_details
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ34A($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ34B($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ34BYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ35A($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ35AYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ35B($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ35BYesDetails1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ35BYesDetails2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ36($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ36YesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ37($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ37YesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ38A($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ38AYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ38B($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ38BYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ39($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ39YesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ40A($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ40AYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ40B($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ40BYesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ40C($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOtherQuestion whereQ40CYesDetails($value)
 */
	class EmployeeOtherQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeRecognition
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $title
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereTitle($value)
 */
	class EmployeeRecognition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeReference
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $fullname
 * @property string|null $address
 * @property string|null $tel_no
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereTelNo($value)
 */
	class EmployeeReference extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeServiceRecord
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property int|null $sequence_no
 * @property string|null $date_from
 * @property string|null $from_date
 * @property string|null $date_to
 * @property string|null $to_date
 * @property int|null $upto_date
 * @property string|null $position
 * @property string|null $appointment_status
 * @property float|null $salary
 * @property string|null $mode_of_payment
 * @property string|null $station
 * @property string|null $gov_serve
 * @property string|null $psc_serve
 * @property string|null $lwp
 * @property string|null $spdate
 * @property string|null $status
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string $system_remarks
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $item_no
 * @property string|null $salary_type
 * @property int|null $grade
 * @property int|null $step
 * @property string|null $monthly_basic
 * @property string|null $due_to
 * @property string|null $file_path
 * @property string|null $salary_scale
 * @property string|null $batch_code
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereBatchCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDueTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereGovServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereLwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord wherePscServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSalaryScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSalaryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSystemRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereUptoDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord withoutTrashed()
 */
	class EmployeeServiceRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeSpecialSkill
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $description
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereId($value)
 */
	class EmployeeSpecialSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeTraining
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property int|null $sequence_no
 * @property string|null $title
 * @property string|null $type
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $detailed_period
 * @property float|null $hours
 * @property string|null $conducted_by
 * @property string|null $venue
 * @property string|null $remarks
 * @property int|null $is_relevant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $system_remarks
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereConductedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereDetailedPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereIsRelevant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereSystemRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining whereVenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTraining withoutTrashed()
 */
	class EmployeeTraining extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeVoluntaryWork
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $name
 * @property string|null $address
 * @property string|null $date_from
 * @property string|null $date_to
 * @property float|null $hours
 * @property string|null $position
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork wherePosition($value)
 */
	class EmployeeVoluntaryWork extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\Clients
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $account_no
 * @property string|null $name
 * @property string|null $address
 * @property string|null $tin
 * @property string|null $contact_person
 * @property string|null $contact_no
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUuid($value)
 */
	class Clients extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\CollectionChecks
 *
 * @property int $id
 * @property string $collection_uuid
 * @property string|null $bank
 * @property string|null $check_no
 * @property string|null $amount
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks whereCheckNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks whereCollectionUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionChecks whereId($value)
 */
	class CollectionChecks extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\CollectionDistributions
 *
 * @property int $id
 * @property string $collection_uuid
 * @property string|null $ref_invoice
 * @property string|null $invoice_no
 * @property string|null $amount
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions whereCollectionUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionDistributions whereRefInvoice($value)
 */
	class CollectionDistributions extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\Collections
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $payment_type
 * @property string|null $ref_no
 * @property string|null $date
 * @property string|null $payor
 * @property string|null $address
 * @property string|null $remarks
 * @property string|null $total_check
 * @property string|null $total_cash
 * @property string|null $total_amount
 * @property string|null $cwt
 * @property string|null $total_paid
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Collections newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collections newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collections query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereCwt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections wherePayor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereTotalCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereTotalCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereTotalPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collections whereUuid($value)
 */
	class Collections extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\ProjectExpenseLiquidation
 *
 * @property int $id
 * @property string $project_uuid
 * @property string $uuid
 * @property string|null $control_no
 * @property string|null $date
 * @property string|null $remarks
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FG\ProjectExpenseLiquidationDetails> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\FG\Projects|null $project
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereControlNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereProjectUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidation whereUuid($value)
 */
	class ProjectExpenseLiquidation extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\ProjectExpenseLiquidationDetails
 *
 * @property int $id
 * @property string $project_expense_liquidation_uuid
 * @property string|null $description
 * @property string|null $debit
 * @property string|null $credit
 * @property-read \App\Models\FG\ProjectExpenseLiquidation|null $liquidation
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectExpenseLiquidationDetails whereProjectExpenseLiquidationUuid($value)
 */
	class ProjectExpenseLiquidationDetails extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\Projects
 *
 * @property int $id
 * @property string $client_uuid
 * @property string $uuid
 * @property string|null $project_code
 * @property string|null $project_name
 * @property string|null $delivery_date
 * @property string|null $delivery_address
 * @property string|null $date_started
 * @property string|null $project_amount
 * @property string|null $details
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FG\Clients|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FG\ProjectExpenseLiquidation> $liquidations
 * @property-read int|null $liquidations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Projects newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects query()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereClientUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereDateStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereProjectAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereProjectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects whereUuid($value)
 */
	class Projects extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\SalesInvoice
 *
 * @property int $id
 * @property string $project_uuid
 * @property string $uuid
 * @property string|null $invoice_no
 * @property string|null $date
 * @property string|null $terms
 * @property string|null $remarks
 * @property string|null $ref_book
 * @property string|null $tax_base
 * @property string|null $vat
 * @property string|null $total_amount_due
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FG\SalesInvoiceDetails> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\FG\Projects|null $project
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereProjectUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereTaxBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereTotalAmountDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoice whereVat($value)
 */
	class SalesInvoice extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\SalesInvoiceDetails
 *
 * @property int $id
 * @property string $sales_invoice_uuid
 * @property string|null $stock_uuid
 * @property string|null $description
 * @property float|null $qty
 * @property string|null $uom
 * @property string|null $unit_cost
 * @property string|null $amount
 * @property-read \App\Models\FG\SalesInvoice|null $salesInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereSalesInvoiceUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereStockUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesInvoiceDetails whereUom($value)
 */
	class SalesInvoiceDetails extends \Eloquent {}
}

namespace App\Models\FG{
/**
 * App\Models\FG\Stocks
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $bar_code
 * @property string|null $name
 * @property string|null $description
 * @property string|null $category
 * @property string|null $uom
 * @property string|null $unit_price
 * @property string|null $selling_price
 * @property float|null $reordering_level
 * @property int|null $is_active
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereBarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereReorderingLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stocks whereUuid($value)
 */
	class Stocks extends \Eloquent {}
}

namespace App\Models\FLIGHTS{
/**
 * App\Models\FLIGHTS\FlightsAirports
 *
 * @property int $id
 * @property string $airport_code
 * @property string $airport_name
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsAirports newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsAirports newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsAirports query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsAirports whereAirportCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsAirports whereAirportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsAirports whereId($value)
 */
	class FlightsAirports extends \Eloquent {}
}

namespace App\Models\FLIGHTS{
/**
 * App\Models\FLIGHTS\FlightsRequests
 *
 * @property int $id
 * @property string $slug
 * @property string $employee_slug
 * @property string $requested_by
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $pap_code
 * @property string|null $start_airport
 * @property string|null $departure
 * @property string|null $departure_flight_no
 * @property string|null $layover_airport
 * @property string|null $layover_departure
 * @property string|null $layover_flight_no
 * @property string|null $end_airport
 * @property string|null $return_start_airport
 * @property string|null $return_departure
 * @property string|null $return_departure_flight_no
 * @property string|null $return_layover_airport
 * @property string|null $return_layover_departure
 * @property string|null $return_layover_flight_no
 * @property string|null $return_end_airport
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereDepartureFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereEndAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereLayoverAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereLayoverDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereLayoverFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests wherePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnDepartureFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnEndAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnLayoverAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnLayoverDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnLayoverFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereReturnStartAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereStartAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequests whereUserUpdated($value)
 */
	class FlightsRequests extends \Eloquent {}
}

namespace App\Models\FLIGHTS{
/**
 * App\Models\FLIGHTS\FlightsRequestsAttachments
 *
 * @property int $id
 * @property string $slug
 * @property string $request_slug
 * @property string $passenger_slug
 * @property string|null $attachment_type
 * @property string|null $file_type
 * @property string|null $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereAttachmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments wherePassengerSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereRequestSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsAttachments whereUserUpdated($value)
 */
	class FlightsRequestsAttachments extends \Eloquent {}
}

namespace App\Models\FLIGHTS{
/**
 * App\Models\FLIGHTS\FlightsRequestsPassengers
 *
 * @property int $id
 * @property string $request_slug
 * @property string $slug
 * @property string $employee_slug
 * @property string $employee_name
 * @property string|null $employee_birthday
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $seat_preference
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereEmployeeBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereEmployeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereRequestSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereSeatPreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightsRequestsPassengers whereSlug($value)
 */
	class FlightsRequestsPassengers extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FundSource
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $fund_source_id
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\DisbursementVoucher|null $disbursementVoucher
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource query()
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereFundSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundSource whereUserUpdated($value)
 */
	class FundSource extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HRPayPlanitilla
 *
 * @property int $id
 * @property string $location
 * @property int $item_no
 * @property string|null $resp_center
 * @property int $department_header
 * @property string $department
 * @property int $division_header
 * @property string $division
 * @property int $section_header
 * @property string $section
 * @property string $position
 * @property string|null $alias
 * @property string|null $csc_position
 * @property string|null $employee_no
 * @property string|null $employee_name
 * @property int|null $job_grade
 * @property int|null $step_inc
 * @property string|null $actual_salary
 * @property string|null $actual_salary_gcg
 * @property string|null $eligibility
 * @property string|null $educ_att
 * @property string|null $appointment_status
 * @property string|null $appointment_date
 * @property string|null $last_promotion
 * @property int|null $seq_groupings
 * @property int|null $div_groupings
 * @property int|null $original_job_grade
 * @property int|null $original_job_grade_si
 * @property int|null $original_salary_grade
 * @property int|null $original_salary_grade_si
 * @property int $control_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $qs_education
 * @property string|null $qs_training
 * @property string|null $qs_experience
 * @property string|null $qs_eligibility
 * @property string|null $qs_competency
 * @property string|null $place_of_assignment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantPositionApplied> $applicants
 * @property-read int|null $applicants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\HrPlantillaClassification> $classifications
 * @property-read int|null $classifications_count
 * @property-read \App\Models\Employee|null $incumbentEmployee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $occupants
 * @property-read int|null $occupants_count
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereActualSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereActualSalaryGcg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereControlNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereCscPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereDepartmentHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereDivGroupings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereDivisionHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereEducAtt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereEmployeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereJobGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereLastPromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereOriginalJobGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereOriginalJobGradeSi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereOriginalSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereOriginalSalaryGradeSi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla wherePlaceOfAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereQsCompetency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereQsEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereQsEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereQsExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereQsTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereSectionHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereSeqGroupings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereStepInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereUserUpdated($value)
 */
	class HRPayPlanitilla extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HRTrainingsServer5
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $slug
 * @property int|null $no
 * @property int|null $sequence_no
 * @property string|null $title
 * @property string|null $period
 * @property string|null $type
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $date_from_month_only
 * @property float|null $hours
 * @property string|null $conducted_by
 * @property string|null $venue
 * @property string|null $remarks
 * @property int|null $is_relevant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 query()
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereConductedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereDateFromMonthOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereIsRelevant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsServer5 whereVenue($value)
 */
	class HRTrainingsServer5 extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HRTrainingsTemp
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $slug
 * @property int|null $no
 * @property int|null $sequence_no
 * @property string|null $title
 * @property string|null $period
 * @property string|null $type
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $date_from_month_only
 * @property float|null $hours
 * @property string|null $conducted_by
 * @property string|null $venue
 * @property string|null $remarks
 * @property int|null $is_relevant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp query()
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereConductedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereDateFromMonthOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereIsRelevant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRTrainingsTemp whereVenue($value)
 */
	class HRTrainingsTemp extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\COS
 *
 * @property int $id
 * @property string $slug
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $memo_code
 * @property string|null $memo_date
 * @property string|null $funds_available
 * @property string|null $funds_available_position
 * @property int|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $ip_created
 * @property string|null $user_updated
 * @property string|null $ip_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\COSEmployees> $employees
 * @property-read int|null $employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|COS active()
 * @method static \Illuminate\Database\Eloquent\Builder|COS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|COS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|COS query()
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereFundsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereFundsAvailablePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereMemoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereMemoDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COS whereUserUpdated($value)
 */
	class COS extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\COSEmployees
 *
 * @property int $id
 * @property string $hr_cos_employees_slug
 * @property string $cos_slug
 * @property string $employee_slug
 * @property string|null $employee_fullname
 * @property string|null $status
 * @property string|null $evaluation_path
 * @property string|null $evaluation_uploaded_at
 * @property int|null $has_printed
 * @property array|null $logs
 * @property array|null $other_data
 * @property string|null $resp_center
 * @property string|null $cos_assignment
 * @property string|null $type
 * @property string|null $batch_code
 * @property-read \App\Models\HRU\COS|null $cos
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees query()
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereBatchCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereCosAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereCosSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereEmployeeFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereEvaluationPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereEvaluationUploadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereHasPrinted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereHrCosEmployeesSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereLogs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereOtherData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COSEmployees whereType($value)
 */
	class COSEmployees extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\Deductions
 *
 * @property int $id
 * @property string|null $deduction_code
 * @property string|null $description
 * @property int|null $taxable
 * @property int|null $priority
 * @property float|null $factor
 * @property float|null $govt_share_factor
 * @property string|null $account_code
 * @property int|null $sundry_account
 * @property int|null $availables
 * @property string|null $employee_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $n_priority
 * @property string|null $excel_header
 * @property string|null $groupings
 * @property string|null $factor_operand
 * @property int|null $pre_tax_deduction
 * @property int|null $non_edit
 * @property int|null $bulk_edit
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions available()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions preTaxDeduction()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereAvailables($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereBulkEdit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereDeductionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereEmployeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereExcelHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereFactorOperand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereGovtShareFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereGroupings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereNPriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereNonEdit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions wherePreTaxDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereSundryAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereUpdatedAt($value)
 */
	class Deductions extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\EmployeeTimeLogs
 *
 * @property int $id
 * @property string $slug
 * @property string $employee_slug
 * @property string $date
 * @property string|null $am_in
 * @property string|null $pm_out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property int|null $project_id
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereAmIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs wherePmOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeTimeLogs whereUserUpdated($value)
 */
	class EmployeeTimeLogs extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\HRRequests
 *
 * @property int $id
 * @property string $slug
 * @property string $tracking_no
 * @property string|null $employee_slug
 * @property string|null $employee_full
 * @property string|null $document
 * @property string|null $purpose
 * @property string|null $details
 * @property string|null $status
 * @property array|null $status_trail
 * @property int|null $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property array|null $document_fields
 * @property int|null $request_file
 * @property string|null $user_file_path
 * @property string|null $file_path
 * @property string|null $file_updated_at
 * @property string|null $file_user_updated
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests my()
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests query()
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereDocumentFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereEmployeeFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereFileUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereFileUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereRequestFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereStatusTrail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereTrackingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereUserFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRRequests whereUserUpdated($value)
 */
	class HRRequests extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\HrOtherActions
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $employee_slug
 * @property array|null $values
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrOtherActions whereValues($value)
 */
	class HrOtherActions extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\HrPlantillaClassification
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HrPlantillaClassification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPlantillaClassification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPlantillaClassification query()
 */
	class HrPlantillaClassification extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\Incentives
 *
 * @property int $id
 * @property string|null $incentive_code
 * @property string|null $description
 * @property int|null $taxable
 * @property int|null $priority
 * @property string|null $fixed_values
 * @property string|null $taxable_amount
 * @property int|null $tax_free_90k
 * @property int|null $incentive_count
 * @property int|null $is_visible
 * @property int|null $non_deletable
 * @property int|null $is_monthly
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $n_is_monthly
 * @property int|null $n_priority
 * @property string|null $groupings
 * @property string|null $account_code
 * @property int|null $coe
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives exceptBasicPay()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives isMonthly()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives query()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereCoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereFixedValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereGroupings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIncentiveCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIncentiveCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIsMonthly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereNIsMonthly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereNPriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereNonDeletable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereTaxFree90k($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereTaxableAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereUpdatedAt($value)
 */
	class Incentives extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\LeaveApplicationDates
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $leave_application_slug
 * @property string|null $date
 * @property string|null $deduct
 * @property-read \App\Models\LeaveApplication|null $leaveApplication
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates whereDeduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates whereLeaveApplicationSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates whereSlug($value)
 */
	class LeaveApplicationDates extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\LeaveBeginningBalance
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $vl
 * @property string|null $sl
 * @property string|null $as_of
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereAsOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereSl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveBeginningBalance whereVl($value)
 */
	class LeaveBeginningBalance extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantEducation
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation selected()
 */
	class OApplicantEducation extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantEligibility
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility selected()
 */
	class OApplicantEligibility extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantPositionApplied
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied query()
 */
	class OApplicantPositionApplied extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantTraining
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining selected()
 */
	class OApplicantTraining extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantWork
 *
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork selected()
 */
	class OApplicantWork extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicants
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\OApplicantEducation> $educationalBackground
 * @property-read int|null $educational_background_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\OApplicantEligibility> $eligibilities
 * @property-read int|null $eligibilities_count
 * @property-read \App\Models\HRU\PublicationDetails|null $publicationItem
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\OApplicantTraining> $trainings
 * @property-read int|null $trainings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\OApplicantWork> $workExperiences
 * @property-read int|null $work_experiences_count
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants finalized()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants query()
 */
	class OApplicants extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PS
 *
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|PS my()
 * @method static \Illuminate\Database\Eloquent\Builder|PS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PS query()
 */
	class PS extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PayrollEmployeeSettings
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property int|null $receives_ra
 * @property string|null $ra_rate
 * @property int|null $receives_ta
 * @property string|null $ta_rate
 * @property int|null $receives_hazard_prc
 * @property float|null $hazard_prc_tax_rate
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereHazardPrcTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereRaRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereReceivesHazardPrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereReceivesRa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereReceivesTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollEmployeeSettings whereTaRate($value)
 */
	class PayrollEmployeeSettings extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PayrollMaster
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $date
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property int|null $is_locked
 * @property string|null $user_locked
 * @property string|null $locked_at
 * @property string|null $user_unlocked
 * @property string|null $unlocked_at
 * @property int|null $project_id
 * @property string|null $account_code
 * @property string|null $a_name
 * @property string|null $a_position
 * @property string|null $b_name
 * @property string|null $b_position
 * @property string|null $c_name
 * @property string|null $c_position
 * @property string|null $d_name
 * @property string|null $d_position
 * @property array|null $other_details
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccounts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterDetails> $hmtDetails
 * @property-read int|null $hmt_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterEmployees> $payrollMasterEmployees
 * @property-read int|null $payroll_master_employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereAName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereAPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereBName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereBPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereCName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereCPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereDName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereDPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereLockedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereOtherDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereUnlockedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereUserLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereUserUnlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereUserUpdated($value)
 */
	class PayrollMaster extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PayrollMasterDetails
 *
 * @property int $id
 * @property string|null $pay_master_slug
 * @property string|null $pay_master_employee_listing_slug
 * @property string|null $employee_slug
 * @property string|null $slug
 * @property string|null $type
 * @property string|null $code
 * @property string|null $amount
 * @property string|null $original_amount
 * @property string|null $non_taxable_amount
 * @property string|null $govt_share
 * @property string|null $ec_share
 * @property int|null $priority
 * @property string|null $source
 * @property int|null $sundry_account
 * @property string|null $account_code
 * @property string|null $refund_date
 * @property string|null $refund_amount
 * @property string|null $refund_remarks
 * @property string|null $refunded_by
 * @property string|null $refunded_at
 * @property int|null $taxable
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccount
 * @property-read \App\Models\HRU\Deductions|null $deduction
 * @property-read \App\Models\HRU\PayrollMasterEmployees|null $employeePayroll
 * @property-read \App\Models\HRU\Incentives|null $incentive
 * @property-read \App\Models\HRU\PayrollMaster|null $payrollMaster
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails deductionsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails incentivesOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails intermediateGroup($intermediateGroups)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereEcShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereGovtShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereNonTaxableAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereOriginalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails wherePayMasterEmployeeListingSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails wherePayMasterSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereRefundAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereRefundDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereRefundRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereRefundedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereRefundedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereSundryAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereType($value)
 */
	class PayrollMasterDetails extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PayrollMasterEmployees
 *
 * @property int $id
 * @property string|null $pay_master_slug
 * @property string|null $employee_slug
 * @property string|null $slug
 * @property string|null $employee_payroll_type
 * @property string|null $pay15
 * @property string|null $pay30
 * @property array|null $has_been_edited
 * @property array|null $saved_employee_data
 * @property string|null $hazardprc_factor
 * @property string|null $hazardprc_gross
 * @property string|null $hazardprc_all_days
 * @property string|null $hazardprc_eligible_days
 * @property string|null $hazardprc_ineligible_days
 * @property string|null $hazardprc_tax_rate
 * @property string|null $hazardprc_tax
 * @property string|null $hazardprc_net_amount
 * @property string|null $rata_ra_rate
 * @property string|null $rata_ta_rate
 * @property string|null $rata_actual_days_worked
 * @property string|null $rata_total
 * @property string|null $rata_deductions
 * @property string|null $rata_net_amount
 * @property string|null $diff_old_monthly_basic
 * @property string|null $diff_new_monthly_basic
 * @property string|null $diff_from
 * @property string|null $diff_to
 * @property string|null $diff_days
 * @property string|null $diff_gross
 * @property string|null $diff_net
 * @property array|null $diff_other
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterDetails> $employeePayrollDetails
 * @property-read int|null $employee_payroll_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterDetails> $employeePayrollDetailsDeductions
 * @property-read int|null $employee_payroll_details_deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterDetails> $employeePayrollDetailsIncentives
 * @property-read int|null $employee_payroll_details_incentives_count
 * @property-read \App\Models\HRU\PayrollMaster|null $payrollMaster
 * @property-read mixed $totals
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffNewMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffOldMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereDiffTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereEmployeePayrollType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHasBeenEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcAllDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcEligibleDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcIneligibleDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereHazardprcTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees wherePay15($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees wherePay30($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees wherePayMasterSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataActualDaysWorked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataDeductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataRaRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataTaRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereSavedEmployeeData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereSlug($value)
 */
	class PayrollMasterEmployees extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PayrollTree
 *
 * @property int $id
 * @property string|null $resp_center
 * @property string|null $group
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $project_id
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollTree whereUpdatedAt($value)
 */
	class PayrollTree extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\PublicationDetails
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $publication_slug
 * @property int|null $no
 * @property string|null $position
 * @property string|null $item_no
 * @property int|null $salary_grade
 * @property string|null $monthly_salary
 * @property string|null $qs_education
 * @property string|null $qs_training
 * @property string|null $qs_experience
 * @property string|null $qs_eligibility
 * @property string|null $qs_competency
 * @property string|null $place_of_assignment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\OApplicants> $applicants
 * @property-read int|null $applicants_count
 * @property-read \App\Models\HRU\Publications|null $publication
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereMonthlySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails wherePlaceOfAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails wherePublicationSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereQsCompetency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereQsEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereQsEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereQsExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereQsTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationDetails whereUpdatedAt($value)
 */
	class PublicationDetails extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\Publications
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $date
 * @property string|null $deadline
 * @property string|null $send_to
 * @property string|null $send_to_position
 * @property string|null $send_to_address
 * @property string|null $send_to_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property int|null $is_final
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\OApplicants> $publicationApplicants
 * @property-read int|null $publication_applicants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PublicationDetails> $publicationDetails
 * @property-read int|null $publication_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Publications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publications query()
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereIsFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereSendTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereSendToAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereSendToEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereSendToPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publications whereUserUpdated($value)
 */
	class Publications extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\TemplateDeductions
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $deduction_code
 * @property int|null $priority
 * @property float|null $amount
 * @property string|null $govt_share
 * @property string|null $ec_share
 * @property string|null $amount_orig
 * @property string|null $effectivity_date
 * @property-read \App\Models\HRU\Deductions|null $deduction
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions nonZero()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions query()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereAmountOrig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereDeductionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereEcShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereEffectivityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereGovtShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateDeductions wherePriority($value)
 */
	class TemplateDeductions extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\TemplateIncentives
 *
 * @property int $id
 * @property string|null $employee_slug
 * @property string|null $incentive_code
 * @property int|null $taxable
 * @property int|null $priority
 * @property float|null $amount
 * @property string|null $taxable_amount
 * @property int|null $non_deletable
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\HRU\Incentives|null $incentive
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives nonZero()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives query()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereIncentiveCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereNonDeletable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateIncentives whereTaxableAmount($value)
 */
	class TemplateIncentives extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\Timekeeping
 *
 * @property int $id
 * @property string $slug
 * @property string|null $series
 * @property string|null $employee_slug
 * @property string|null $name
 * @property string|null $resp_center
 * @property string|null $position
 * @property string|null $guard_on_duty
 * @property string|null $authorized_official
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $status
 * @property int|null $project_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TimekeepingDetails> $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereAuthorizedOfficial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereGuardOnDuty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timekeeping whereUserUpdated($value)
 */
	class Timekeeping extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\TimekeepingDetails
 *
 * @property int $id
 * @property string $timekeeping_slug
 * @property string $slug
 * @property string $date
 * @property string|null $am_in
 * @property string|null $am_out
 * @property string|null $pm_in
 * @property string|null $pm_out
 * @property-read \App\Models\HRU\Timekeeping|null $timekeeping
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails whereAmIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails whereAmOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails wherePmIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails wherePmOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimekeepingDetails whereTimekeepingSlug($value)
 */
	class TimekeepingDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Holiday
 *
 * @property int $id
 * @property string $date
 * @property string $type
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $google_calendar_id
 * @property string|null $slug
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday query()
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereGoogleCalendarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Holiday whereUserUpdated($value)
 */
	class Holiday extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HrEmployeesSRTemp
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_no
 * @property int|null $sequence_no
 * @property string|null $date_from
 * @property string|null $from_date
 * @property string|null $date_to
 * @property string|null $to_date
 * @property int|null $upto_date
 * @property string|null $position
 * @property string|null $appointment_status
 * @property string|null $salary
 * @property string|null $mode_of_payment
 * @property string|null $station
 * @property string|null $gov_serve
 * @property string|null $psc_serve
 * @property string|null $lwp
 * @property string|null $spdate
 * @property string|null $status
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereGovServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereLwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp wherePscServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereSpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereUptoDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrEmployeesSRTemp whereUserUpdated($value)
 */
	class HrEmployeesSRTemp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HrPayPlantillaEmployees
 *
 * @property int $id
 * @property string $item_no
 * @property string $employee_no
 * @property string|null $fullname
 * @property string $appointment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrPayPlantillaEmployees whereUpdatedAt($value)
 */
	class HrPayPlantillaEmployees extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HrPlantilla
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HrPlantilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPlantilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrPlantilla query()
 */
	class HrPlantilla extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IpAddress
 *
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress query()
 */
	class IpAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JoEmployees
 *
 * @property int $id
 * @property string $employee_no
 * @property string $firstname
 * @property string|null $middlename
 * @property string $lastname
 * @property string $biometric_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name_ext
 * @property string|null $sex
 * @property string|null $birthday
 * @property string|null $civil_status
 * @property string|null $province
 * @property string|null $city
 * @property string|null $brgy
 * @property string|null $address_detailed
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $department_unit
 * @property string|null $position
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $slug
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyTimeRecord> $dtr_records
 * @property-read int|null $dtr_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DTR> $rawDtrRecords
 * @property-read int|null $raw_dtr_records_count
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees query()
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereAddressDetailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereBiometricUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereBrgy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereDepartmentUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoEmployees whereUserUpdated($value)
 */
	class JoEmployees extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LeaveApplication
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $leave_application_no
 * @property string|null $department
 * @property string|null $employee_slug
 * @property string|null $charge_to
 * @property string|null $actual_deduction
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $position
 * @property string|null $salary
 * @property string|null $date_of_filing
 * @property string|null $leave_type
 * @property string|null $leave_type_specify
 * @property string|null $leave_details
 * @property string|null $leave_specify
 * @property int|null $no_of_days
 * @property string|null $commutation
 * @property string|null $certified_by
 * @property string|null $certified_by_position
 * @property string|null $recommended_by
 * @property string|null $recommended_by_position
 * @property string|null $approved_by
 * @property string|null $approved_by_position
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property int|null $project_id
 * @property string|null $received_at
 * @property string|null $user_received
 * @property string|null $status
 * @property-read \App\Models\PPU\RCDesc|null $_department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\LeaveApplicationDates> $dates
 * @property-read int|null $dates_count
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication myData()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication received()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereActualDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereApprovedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereCertifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereCertifiedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereChargeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereCommutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereDateOfFiling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereLeaveApplicationNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereLeaveDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereLeaveSpecify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereLeaveType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereLeaveTypeSpecify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereNoOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereRecommendedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereRecommendedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereUserReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereUserUpdated($value)
 */
	class LeaveApplication extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LeaveCard
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $leave_card
 * @property string|null $date
 * @property string|null $credits
 * @property string|null $deduction
 * @property string|null $usable_until
 * @property string|null $remarks
 * @property string|null $type
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard creditsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard deductionsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getCompensatory($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getLeave($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getLeaveForced($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getLeaveSick($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getLeaveVacation($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getMonitize($month, $year, $charge)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getOvertime($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getTardy($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard getUndertime($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereLeaveCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereUsableUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereUserUpdated($value)
 */
	class LeaveCard extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MDDC
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC query()
 */
	class MDDC extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $menu_id
 * @property string|null $category
 * @property int|null $order
 * @property string|null $name
 * @property string|null $route
 * @property string|null $icon
 * @property int|null $is_menu
 * @property int|null $is_dropdown
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $tags
 * @property string|null $portal
 * @property int $vis
 * @property int $lm
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Submenu> $submenu
 * @property-read int|null $submenu_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIsDropdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePortal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereVis($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequests
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\PPU\RCDesc|null $dept
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MisRequestsStatus> $status
 * @property-read int|null $status_count
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests query()
 */
	class MisRequests extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequestsEmailRecipients
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients query()
 */
	class MisRequestsEmailRecipients extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequestsNature
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature query()
 */
	class MisRequestsNature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequestsStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus query()
 */
	class MisRequestsStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\News
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $details
 * @property string|null $descriptive_details
 * @property string|null $author
 * @property string|null $author_position
 * @property string|null $expires_on
 * @property int|null $is_active
 * @property int|null $severity
 * @property string|null $attachment_type
 * @property string|null $attachment_location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property array|null $viewers
 * @property int|null $project_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NewsAttachments> $attachments
 * @property-read int|null $attachments_count
 * @method static \Illuminate\Database\Eloquent\Builder|News active()
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAttachmentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAttachmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAuthorPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDescriptiveDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereExpiresOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereViewers($value)
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsAttachments
 *
 * @property int $id
 * @property string $slug
 * @property string $news
 * @property string $file
 * @property string $original_file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereOriginalFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereUpdatedAt($value)
 */
	class NewsAttachments extends \Eloquent {}
}

namespace App\Models\PPBTMS{
/**
 * App\Models\PPBTMS\InventoryPPE
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $ref_book
 * @property string|null $par_code
 * @property string|null $sub_major_account_group
 * @property string|null $general_ledger_account
 * @property string|null $fund_cluster
 * @property string|null $propuniqueno
 * @property string|null $article
 * @property string|null $description
 * @property string|null $serial_no
 * @property string|null $old_propertyno
 * @property string|null $propertyno
 * @property string|null $uom
 * @property string|null $acquiredcost
 * @property int|null $qtypercard
 * @property int|null $onhandqty
 * @property int|null $shortqty
 * @property int|null $shortvalue
 * @property string|null $dateacquired
 * @property string|null $remarks
 * @property string|null $acctemployee_no
 * @property string|null $acctemployee_fname
 * @property string|null $acctemployee_post
 * @property string|null $respcenter
 * @property string|null $supplier
 * @property string|null $invoiceno
 * @property string|null $invoicedate
 * @property string|null $pono
 * @property string|null $podate
 * @property string|null $invtacctcode
 * @property string|null $location
 * @property string|null $acquiredmode
 * @property string|null $condition
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ppe_model
 * @property string|null $ppe_serial_no
 * @property string|null $office
 * @property int|null $project_id
 * @property int|null $inv_taken
 * @property string|null $inv_date
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereAcctemployeeFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereAcctemployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereAcctemployeePost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereAcquiredcost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereAcquiredmode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereDateacquired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereFundCluster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereGeneralLedgerAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereInvDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereInvTaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereInvoicedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereInvoiceno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereInvtacctcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereOldPropertyno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereOnhandqty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereParCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE wherePodate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE wherePono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE wherePpeModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE wherePpeSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE wherePropertyno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE wherePropuniqueno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereQtypercard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereRespcenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereShortqty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereShortvalue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereSubMajorAccountGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryPPE whereUserUpdated($value)
 */
	class InventoryPPE extends \Eloquent {}
}

namespace App\Models\PPBTMS{
/**
 * App\Models\PPBTMS\ParOld
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ParOld newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParOld newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParOld query()
 */
	class ParOld extends \Eloquent {}
}

namespace App\Models\PPBTMS{
/**
 * App\Models\PPBTMS\Transactions
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $cross_slug
 * @property string|null $order_slug
 * @property string|null $resp_center
 * @property string|null $pap_code
 * @property string|null $ref_book
 * @property string|null $ref_no
 * @property string|null $cross_ref_no
 * @property string|null $received_at
 * @property string|null $date
 * @property string|null $abc
 * @property string|null $sai
 * @property string|null $sai_date
 * @property string|null $purpose
 * @property string|null $jr_type
 * @property string|null $supplier_tin
 * @property string|null $requested_by
 * @property string|null $requested_by_designation
 * @property string|null $approved_by
 * @property string|null $approved_by_designation
 * @property string|null $certified_by
 * @property string|null $certified_by_designation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $rfq_no
 * @property string|null $rfq_deadline
 * @property string|null $rfq_s_name
 * @property string|null $rfq_s_position
 * @property string|null $rfq_user_updated
 * @property string|null $rfq_updated_at
 * @property string|null $deleted_at
 * @property string|null $prepared_by
 * @property string|null $prepared_by_position
 * @property string|null $noted_by
 * @property string|null $noted_by_position
 * @property string|null $recommending_approval
 * @property string|null $recommending_approval_position
 * @property int|null $is_locked
 * @property string|null $user_received
 * @property string|null $cancelled_at
 * @property string|null $user_cancelled
 * @property string|null $cancellation_reason
 * @property string|null $remarks
 * @property string|null $supplier
 * @property string|null $supplier_address
 * @property string|null $place_of_delivery
 * @property string|null $delivery_term
 * @property string|null $payment_term
 * @property string|null $total_gross
 * @property string|null $total
 * @property string|null $mode
 * @property string|null $po_number
 * @property string|null $po_date
 * @property string|null $invoice_number
 * @property string|null $invoice_date
 * @property string|null $date_inspected
 * @property string|null $fund_cluster
 * @property string|null $account_code
 * @property string|null $document_type
 * @property int|null $project_id
 * @property-read \App\Models\PPU\Pap|null $pap
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions jrsReceivedAndNotCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions prsReceivedAndNotCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions receivedAndNotCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereAbc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereApprovedByDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCancellationReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCertifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCertifiedByDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCrossRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCrossSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDateInspected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDeliveryTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereFundCluster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereJrType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereNotedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereNotedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereOrderSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePaymentTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePlaceOfDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePoDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePreparedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePreparedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRecommendingApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRecommendingApprovalPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRequestedByDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqSName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqSPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSaiDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSupplierAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSupplierTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereTotalGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserUpdated($value)
 */
	class Transactions extends \Eloquent {}
}

namespace App\Models\PPUV{
/**
 * App\Models\PPUV\AQ
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $aq_slug
 * @property string|null $supplier_slug
 * @property string|null $supplier_name
 * @property string|null $warranty
 * @property string|null $price_validity
 * @property string|null $delivery_term
 * @property string|null $payment_term
 * @property int|null $has_attachments
 * @method static \Illuminate\Database\Eloquent\Builder|AQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AQ newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AQ query()
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereAqSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereDeliveryTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereHasAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ wherePaymentTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ wherePriceValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereSupplierSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQ whereWarranty($value)
 */
	class AQ extends \Eloquent {}
}

namespace App\Models\PPUV{
/**
 * App\Models\PPUV\AQOffers
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $quotation_slug
 * @property string|null $item_slug
 * @property string|null $amount
 * @property string|null $description
 * @property-read \App\Models\PPUV\AQ|null $aq
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers query()
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers whereItemSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers whereQuotationSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AQOffers whereSlug($value)
 */
	class AQOffers extends \Eloquent {}
}

namespace App\Models\PPUV{
/**
 * App\Models\PPUV\Options
 *
 * @property int $id
 * @property string $for
 * @property string $value
 * @property string $display
 * @method static \Illuminate\Database\Eloquent\Builder|Options newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Options newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Options query()
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereValue($value)
 */
	class Options extends \Eloquent {}
}

namespace App\Models\PPUV{
/**
 * App\Models\PPUV\Suppliers
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $name
 * @property string|null $address
 * @property string|null $tin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $office_contact_number
 * @property string|null $contact_person
 * @property string|null $contact_person_address
 * @property string|null $phone_number_1
 * @property string|null $phone_number_2
 * @property string|null $fax_number
 * @property string|null $designation
 * @property int $is_vat
 * @property int $is_government
 * @property int|null $project_id
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers query()
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereContactPersonAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereFaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereIsGovernment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereIsVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereOfficeContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers wherePhoneNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers wherePhoneNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereUserUpdated($value)
 */
	class Suppliers extends \Eloquent {}
}

namespace App\Models\PPUV{
/**
 * App\Models\PPUV\TransactionDetails
 *
 * @property int $id
 * @property string|null $slug
 * @property string $transaction_slug
 * @property string|null $inventoryppe_slug
 * @property string|null $rfq_slug
 * @property string|null $stock_no
 * @property string|null $unit
 * @property string|null $item
 * @property string|null $description
 * @property float|null $qty
 * @property string|null $unit_cost
 * @property string|null $total_cost
 * @property string|null $property_no
 * @property string|null $nature_of_work
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $estimated_useful_life
 * @property float|null $actual_qty
 * @property string|null $remarks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPUV\AQOffers> $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\PPUV\Transactions|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereActualQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereEstimatedUsefulLife($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereInventoryppeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereNatureOfWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails wherePropertyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereRfqSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereStockNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereTransactionSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionDetails whereUpdatedAt($value)
 */
	class TransactionDetails extends \Eloquent {}
}

namespace App\Models\PPUV{
/**
 * App\Models\PPUV\Transactions
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $cross_slug
 * @property string|null $order_slug
 * @property string|null $resp_center
 * @property string|null $pap_code
 * @property string|null $ref_book
 * @property string|null $ref_no
 * @property string|null $cross_ref_no
 * @property string|null $received_at
 * @property string|null $date
 * @property string|null $abc
 * @property string|null $sai
 * @property string|null $sai_date
 * @property string|null $purpose
 * @property string|null $jr_type
 * @property string|null $supplier_tin
 * @property string|null $requested_by
 * @property string|null $requested_by_designation
 * @property string|null $approved_by
 * @property string|null $approved_by_designation
 * @property string|null $certified_by
 * @property string|null $certified_by_designation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $rfq_no
 * @property string|null $rfq_deadline
 * @property string|null $rfq_s_name
 * @property string|null $rfq_s_position
 * @property string|null $rfq_user_updated
 * @property string|null $rfq_updated_at
 * @property string|null $deleted_at
 * @property string|null $prepared_by
 * @property string|null $prepared_by_position
 * @property string|null $noted_by
 * @property string|null $noted_by_position
 * @property string|null $recommending_approval
 * @property string|null $recommending_approval_position
 * @property int|null $is_locked
 * @property string|null $user_received
 * @property string|null $cancelled_at
 * @property string|null $user_cancelled
 * @property string|null $cancellation_reason
 * @property string|null $remarks
 * @property string|null $supplier
 * @property string|null $supplier_address
 * @property string|null $place_of_delivery
 * @property string|null $delivery_term
 * @property string|null $payment_term
 * @property string|null $total_gross
 * @property string|null $total
 * @property string|null $mode
 * @property string|null $po_number
 * @property string|null $po_date
 * @property string|null $invoice_number
 * @property string|null $invoice_date
 * @property string|null $date_inspected
 * @property string|null $fund_cluster
 * @property string|null $account_code
 * @property string|null $document_type
 * @property int|null $project_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPUV\AQ> $aq
 * @property-read int|null $aq_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPUV\TransactionDetails> $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereAbc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereApprovedByDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCancellationReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCertifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCertifiedByDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCrossRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCrossSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDateInspected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDeliveryTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereFundCluster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereJrType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereNotedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereNotedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereOrderSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePaymentTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePlaceOfDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePoDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePreparedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePreparedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRecommendingApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRecommendingApprovalPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRequestedByDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqSName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqSPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereRfqUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSaiDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSupplierAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereSupplierTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereTotalGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUserUpdated($value)
 */
	class Transactions extends \Eloquent {}
}

namespace App\Models\PPU{
/**
 * App\Models\PPU\PPURespCodes
 *
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\PPU\RCDesc|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPU\Pap> $papCodes
 * @property-read int|null $pap_codes_count
 * @property-read \App\Models\PPU\PPURespCodes|null $parent
 * @property-read \App\Models\HRU\PayrollTree|null $payrollTree
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \App\Models\PPU\PPURespCodes|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\PPU\PPURespCodes[] $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class PPURespCodes extends \Eloquent {}
}

namespace App\Models\PPU{
/**
 * App\Models\PPU\Pap
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\PapAdjustments> $decreaseInBudget
 * @property-read int|null $decrease_in_budget_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\PapAdjustments> $increaseInBudget
 * @property-read int|null $increase_in_budget_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget\ORSProjectsApplied> $orsAppliedProjects
 * @property-read int|null $ors_applied_projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPBTMS\Transactions> $procurements
 * @property-read int|null $procurements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPBTMS\Transactions> $procurementsJr
 * @property-read int|null $procurements_jr_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPBTMS\Transactions> $procurementsPr
 * @property-read int|null $procurements_pr_count
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @method static \Illuminate\Database\Eloquent\Builder|Pap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pap query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pap withoutChargedToIncome()
 */
	class Pap extends \Eloquent {}
}

namespace App\Models\PPU{
/**
 * App\Models\PPU\RCDesc
 *
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\PPU\PPURespCodes> $responsibilityCenters
 * @property-read int|null $responsibility_centers_count
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc query()
 */
	class RCDesc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PapParent
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $user_created
 * @property string $user_updated
 * @property string $ip_created
 * @property string $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Submenu> $submenu
 * @property-read int|null $submenu_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent query()
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapParent whereUserUpdated($value)
 */
	class PapParent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PermissionSlip
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip dailyPS($date)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip monthlyPS($df, $dt)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip monthlyPS2($month, $year)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip sortable($defaultParameters = null)
 */
	class PermissionSlip extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Plantilla
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Applicant> $applicant
 * @property-read int|null $applicant_count
 * @property-read \App\Models\DepartmentUnit|null $departmentUnit
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla sortable($defaultParameters = null)
 */
	class Plantilla extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Project
 *
 * @property int $id
 * @property string|null $project_id
 * @property string|null $project_description
 * @property string|null $color
 * @property int|null $is_active
 * @property string|null $project_address
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUserUpdated($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProjectCode
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $project_code_id
 * @property string|null $department_id
 * @property string|null $department_name
 * @property string|null $project_code
 * @property string|null $description
 * @property string|null $mooe
 * @property string|null $co
 * @property string|null $date_started
 * @property string|null $projected_date_end
 * @property string|null $project_in_charge
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Department|null $department
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereDateStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereDepartmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereMooe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereProjectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereProjectCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereProjectInCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereProjectedDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCode whereUserUpdated($value)
 */
	class ProjectCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QueryLogs
 *
 * @method static \Illuminate\Database\Eloquent\Builder|QueryLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QueryLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QueryLogs query()
 */
	class QueryLogs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuoteOfTheDay
 *
 * @property int $id
 * @property int $quote
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay whereQuote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteOfTheDay whereUpdatedAt($value)
 */
	class QuoteOfTheDay extends \Eloquent {}
}

namespace App\Models\RBAC{
/**
 * App\Models\RBAC\Evaluation
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RBAC\EvaluationOffers> $offers
 * @property-read int|null $offers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation query()
 */
	class Evaluation extends \Eloquent {}
}

namespace App\Models\RBAC{
/**
 * App\Models\RBAC\EvaluationOffers
 *
 * @property-read \App\Models\PPUV\Suppliers|null $relSupplier
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffers query()
 */
	class EvaluationOffers extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RC
 *
 * @property int $id
 * @property string $rc
 * @property string $name
 * @property string|null $descriptive_name
 * @method static \Illuminate\Database\Eloquent\Builder|RC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RC query()
 * @method static \Illuminate\Database\Eloquent\Builder|RC whereDescriptiveName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RC whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RC whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RC whereRc($value)
 */
	class RC extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RCCodeTree
 *
 * @property int $id
 * @property string|null $rc_code
 * @property string|null $parent_rc_code
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\RCCodeTree|null $parent
 * @property-read \App\Models\PPU\PPURespCodes|null $respCenter
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \App\Models\RCCodeTree|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\RCCodeTree[] $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereParentRcCode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereRcCode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class RCCodeTree extends \Eloquent {}
}

namespace App\Models\RECORDS{
/**
 * App\Models\RECORDS\DMSAttachment
 *
 * @property int $id
 * @property string $slug
 * @property string|null $document_note_slug
 * @property string|null $document_attachment_file
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment whereDocumentAttachmentFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment whereDocumentNoteSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSAttachment whereSlug($value)
 */
	class DMSAttachment extends \Eloquent {}
}

namespace App\Models\RECORDS{
/**
 * App\Models\RECORDS\DMSDocuments
 *
 * @property int $id
 * @property string $slug
 * @property string|null $document_control_no
 * @property string|null $document_title
 * @property string|null $document_date
 * @property string|null $document_origin
 * @property string|null $document_destination
 * @property string|null $document_file
 * @property string|null $document_status
 * @property int|null $dissiminate
 * @property string|null $document_view_status
 * @property string|null $document_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RECORDS\DMSAttachment> $AttachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RECORDS\DMSFiles> $documentFiles
 * @property-read int|null $document_files_count
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments query()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDissiminate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentControlNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereDocumentViewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSDocuments whereUserUpdated($value)
 */
	class DMSDocuments extends \Eloquent {}
}

namespace App\Models\RECORDS{
/**
 * App\Models\RECORDS\DMSFiles
 *
 * @property int $id
 * @property string $slug
 * @property string|null $document_slug
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles query()
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereDocumentSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DMSFiles whereUserUpdated($value)
 */
	class DMSFiles extends \Eloquent {}
}

namespace App\Models\RECORDS{
/**
 * App\Models\RECORDS\DocumentRequests
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentRequests my()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentRequests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentRequests query()
 */
	class DocumentRequests extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SSL
 *
 * @property int $id
 * @property int|null $salary_grade
 * @property float|null $step1
 * @property float|null $step2
 * @property float|null $step3
 * @property float|null $step4
 * @property float|null $step5
 * @property float|null $step6
 * @property float|null $step7
 * @property float|null $step8
 * @property int|null $date_implemented
 * @property string|null $scale
 * @property int|null $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|SSL newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SSL newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SSL query()
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereDateImplemented($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereStep8($value)
 */
	class SSL extends \Eloquent {}
}

namespace App\Models\SU{
/**
 * App\Models\SU\SuActiveIpAddress
 *
 * @property int $id
 * @property string|null $ip_address
 * @property string|null $octet1
 * @property string|null $octet2
 * @property string|null $octet3
 * @property string|null $octet4
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereOctet1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereOctet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereOctet3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereOctet4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuActiveIpAddress whereUpdatedAt($value)
 */
	class SuActiveIpAddress extends \Eloquent {}
}

namespace App\Models\SU{
/**
 * App\Models\SU\SuNotifications
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $text
 * @property string|null $subject
 * @property string|null $model
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuNotifications whereUpdatedAt($value)
 */
	class SuNotifications extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sessions
 *
 * @property string $id
 * @property int|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $payload
 * @property int $last_activity
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sessions whereUserId($value)
 */
	class Sessions extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Signatory
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $signatory_id
 * @property string|null $employee_name
 * @property string|null $employee_position
 * @property int|null $type
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereEmployeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereEmployeePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereSignatoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Signatory whereUserUpdated($value)
 */
	class Signatory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SuEmailVerification
 *
 * @property int $id
 * @property string $verification_slug
 * @property string $user_slug
 * @property int|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification whereUserSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuEmailVerification whereVerificationSlug($value)
 */
	class SuEmailVerification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SuOptions
 *
 * @property int $id
 * @property string $for
 * @property string $option
 * @property string $value
 * @property int|null $deactivated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $header
 * @property string|null $restriction
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereDeactivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereValue($value)
 */
	class SuOptions extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SuSettings
 *
 * @property int $id
 * @property string $setting
 * @property int|null $int_value
 * @property string|null $string_value
 * @property string|null $date_value
 * @property string|null $time_value
 * @property array|null $json_value
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereDateValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereIntValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereJsonValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereStringValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereTimeValue($value)
 */
	class SuSettings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Submenu
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $submenu_id
 * @property string|null $menu_id
 * @property int|null $is_nav
 * @property string|null $name
 * @property string|null $nav_name
 * @property string|null $route
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property int|null $public
 * @property int|null $sort
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Menu|null $menu
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserSubmenu> $usersWithAccess
 * @property-read int|null $users_with_access_count
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereIsNav($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereNavName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereSubmenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submenu whereUserUpdated($value)
 */
	class Submenu extends \Eloquent {}
}

namespace App\Models\Temp{
/**
 * App\Models\Temp\DTRTemp
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DTRTemp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTRTemp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTRTemp query()
 */
	class DTRTemp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string $user_id
 * @property string|null $email
 * @property string|null $email_old
 * @property string|null $username
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $lastname
 * @property string|null $middlename
 * @property string|null $firstname
 * @property string|null $position
 * @property int|null $is_online
 * @property int|null $is_activated
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $last_login_time
 * @property string|null $last_login_machine
 * @property string|null $last_login_ip
 * @property string|null $dash
 * @property string|null $last_activity
 * @property string|null $last_activity_machine
 * @property string|null $employee_no
 * @property string|null $sidenav
 * @property string|null $portal
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAccess> $access
 * @property int|null $pms_allowed
 * @property int|null $project_id
 * @property-read int|null $access_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activityLogs
 * @property-read int|null $activity_logs_count
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\Employee|null $employeeUnion
 * @property-read mixed $fullname
 * @property-read mixed $fullname_short
 * @property-read \App\Models\JoEmployees|null $joEmployee
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserMenu> $userMenu
 * @property-read int|null $user_menu_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserSubmenu> $userSubmenu
 * @property-read int|null $user_submenu_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActivityMachine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginMachine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePortal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSidenav($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAccess
 *
 * @property int $id
 * @property string $user
 * @property string $access
 * @property string $for
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccess whereUser($value)
 */
	class UserAccess extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserData
 *
 * @property int $id
 * @property string|null $slug
 * @property string $user_id
 * @property string $data
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereValue($value)
 */
	class UserData extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserMenu
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $menu_id
 * @property string|null $user_menu_id
 * @property string|null $category
 * @property string|null $name
 * @property string|null $route
 * @property string|null $icon
 * @property int|null $is_menu
 * @property int|null $is_dropdown
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserSubmenu> $userSubmenu
 * @property-read int|null $user_submenu_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereIsDropdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereUserMenuId($value)
 */
	class UserMenu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserSubmenu
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $submenu_id
 * @property string|null $user_menu_id
 * @property int|null $is_nav
 * @property string|null $name
 * @property string|null $nav_name
 * @property string|null $route
 * @property-read \App\Models\Submenu|null $submenu
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\UserMenu|null $userMenu
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereIsNav($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereNavName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereSubmenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubmenu whereUserMenuId($value)
 */
	class UserSubmenu extends \Eloquent {}
}

