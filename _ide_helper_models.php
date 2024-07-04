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


namespace App\Models\Accounting{
/**
 * App\Models\Accounting\JEV
 *
 * @property int $id
 * @property int $project_id
 * @property string|null $slug
 * @property string|null $date
 * @property string|null $fund_source
 * @property string|null $jev_no
 * @property string|null $ref_book
 * @property string|null $ref_date
 * @property string|null $rcd_no
 * @property int|null $year_no
 * @property int|null $month_no
 * @property int|null $seq_no
 * @property string|null $remarks
 * @property string|null $remarks2
 * @property string|null $remarks3
 * @property string|null $cd_no
 * @property string|null $payee
 * @property string|null $check_from
 * @property string|null $check_to
 * @property string|null $collecting_officer
 * @property string|null $prepared_by
 * @property string|null $prepared_by_position
 * @property int|null $is_locked
 * @property string|null $approved_by
 * @property string|null $approved_by_position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\JEVDetails> $corollaryDetails
 * @property-read int|null $corollary_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\JEVDetails> $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|JEV cashDisbursementsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV cashReceiptsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV checkDisbursementsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV generalJournalOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV query()
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereApprovedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereCdNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereCheckFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereCheckTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereCollectingOfficer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereFundSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereJevNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereMonthNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV wherePayee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV wherePreparedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV wherePreparedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereRcdNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereRefDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereRemarks2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereRemarks3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereSeqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEV whereYearNo($value)
 */
	class JEV extends \Eloquent {}
}

namespace App\Models\Accounting{
/**
 * App\Models\Accounting\JEVDetails
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $jev_slug
 * @property string|null $slug
 * @property int|null $is_corollary
 * @property int|null $seq_no
 * @property string|null $resp_center
 * @property string|null $account_code
 * @property string|null $jev_debit
 * @property string|null $jev_credit
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccount
 * @property-read \App\Models\PPU\RCDesc|null $department
 * @property-read \App\Models\Accounting\JEV|null $jev
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\SubsidiaryLedger> $subsidiaryLedgers
 * @property-read int|null $subsidiary_ledgers_count
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereIsCorollary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereJevCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereJevDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereJevSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereSeqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JEVDetails whereSlug($value)
 */
	class JEVDetails extends \Eloquent {}
}

namespace App\Models\Accounting{
/**
 * App\Models\Accounting\SubsidiaryAccounts
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $slug
 * @property string|null $seq_no
 * @property string|null $sa_head1
 * @property string|null $sa_account_code_header
 * @property string|null $account_id
 * @property string|null $sa_account_code
 * @property string|null $sa_name
 * @property string|null $sa_address
 * @property int|null $sa_terms
 * @property int|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSaAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSaAccountCodeHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSaAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSaHead1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSaTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSeqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryAccounts whereUpdatedAt($value)
 */
	class SubsidiaryAccounts extends \Eloquent {}
}

namespace App\Models\Accounting{
/**
 * App\Models\Accounting\SubsidiaryLedger
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $jev_detail_slug
 * @property string|null $slug
 * @property int|null $seq_no
 * @property string|null $sa_account_code
 * @property string|null $sl_debit
 * @property string|null $sl_credit
 * @property string|null $ref_book
 * @property string|null $ref_date
 * @property string|null $ref_jev_no
 * @property int|null $is_corollary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Accounting\JEVDetails|null $jevDetail
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereIsCorollary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereJevDetailSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereRefDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereRefJevNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereSaAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereSeqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereSlCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereSlDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubsidiaryLedger whereUpdatedAt($value)
 */
	class SubsidiaryLedger extends \Eloquent {}
}

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
 * @property int|null $project_id
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
 * @property int $id
 * @property string|null $slug
 * @property string|null $applicant_id
 * @property string|null $course_id
 * @property \App\Models\Course|null $course
 * @property string|null $department_unit_id
 * @property string|null $plantilla_id
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $name_ext
 * @property string|null $fullname
 * @property string|null $gender
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $civil_status
 * @property string|null $address
 * @property string|null $contact_no
 * @property string|null $school
 * @property string|null $remarks
 * @property int|null $is_on_short_list
 * @property \Illuminate\Support\Carbon|null $received_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $thru
 * @property string|null $email
 * @property string|null $res_block
 * @property string|null $res_street
 * @property string|null $res_subdivision
 * @property string|null $res_barangay
 * @property string|null $res_city
 * @property string|null $res_province
 * @property string|null $citizenship
 * @property string|null $citizenship_type
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
 * @property-read \App\Models\DepartmentUnit|null $departmentUnit
 * @property-read \App\Models\Plantilla|null $plantilla
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicantPositionApplied> $positionApplied
 * @property-read int|null $position_applied_count
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereCitizenshipType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereDepartmentUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereIsOnShortList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant wherePlantillaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereResBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereResBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereResCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereResProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereResStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereResSubdivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereThru($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applicant whereUserUpdated($value)
 */
	class Applicant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantEducationalBackground
 *
 * @property int $id
 * @property string|null $applicant_id
 * @property string|null $course
 * @property string|null $school
 * @property string|null $units
 * @property string|null $graduate_year
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground whereGraduateYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEducationalBackground whereUnits($value)
 */
	class ApplicantEducationalBackground extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantEligibility
 *
 * @property int $id
 * @property string|null $applicant_id
 * @property string|null $eligibility
 * @property string|null $level
 * @property float|null $rating
 * @property string|null $exam_place
 * @property \Illuminate\Support\Carbon|null $exam_date
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereExamDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereExamPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantEligibility whereRating($value)
 */
	class ApplicantEligibility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantExperience
 *
 * @property int $id
 * @property string|null $applicant_id
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
 * @property string|null $position
 * @property string|null $company
 * @property int|null $is_gov_service
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience whereIsGovService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantExperience wherePosition($value)
 */
	class ApplicantExperience extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantPositionApplied
 *
 * @property int $id
 * @property string|null $applicant_slug
 * @property string|null $position_applied
 * @property string $item_no
 * @property-read \App\Models\Applicant|null $applicant
 * @property-read \App\Models\HRPayPlanitilla|null $item
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied whereApplicantSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantPositionApplied wherePositionApplied($value)
 */
	class ApplicantPositionApplied extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApplicantTraining
 *
 * @property int $id
 * @property string|null $applicant_id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
 * @property string|null $venue
 * @property string|null $conducted_by
 * @property string|null $remarks
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereConductedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicantTraining whereVenue($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereLastUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BiometricDevices whereUpdatedAt($value)
 */
	class BiometricDevices extends \Eloquent {}
}

namespace App\Models\Bridge\Employees{
/**
 * App\Models\Bridge\Employees\B_EducationalBg
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $level
 * @property string|null $school_name
 * @property string|null $course
 * @property string|null $date_from
 * @property string|null $date_to
 * @property float|null $units
 * @property string|null $graduate_year
 * @property string|null $scholarship
 * @property string|null $honor
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg query()
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereGraduateYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereHonor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereScholarship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_EducationalBg whereUnits($value)
 */
	class B_EducationalBg extends \Eloquent {}
}

namespace App\Models\Bridge\Employees{
/**
 * App\Models\Bridge\Employees\B_Employees
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bridge\Employees\B_EducationalBg> $employeeEducationalBackground
 * @property-read int|null $employee_educational_background_count
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees query()
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereAca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereAdjustmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereAgencyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereBiometricUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCellNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCitizenshipType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCsEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereCsEligibilityLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereDepartmentUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereDeptName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereDualCitizenshipCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereFirstdayGov($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereFirstdaySra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereFoodSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereGovId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereGsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereHdmf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereHdmfpremiums($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereIdDateIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereLicensePassportNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees wherePera($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees wherePhilhealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees wherePlaceOfAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereRa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereSss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereStepInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereTelNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|B_Employees whereWeight($value)
 */
	class B_Employees extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\AnnualBudget
 *
 * @property int $id
 * @property string $slug
 * @property string|null $project_id
 * @property int|null $year
 * @property string|null $department
 * @property string|null $account_code
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccount
 * @property-read \App\Models\PPU\RCDesc|null $dept
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualBudget whereYear($value)
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
 * @property int $id
 * @property string|null $slug
 * @property string|null $project_id
 * @property string|null $ors_id
 * @property string|null $funds
 * @property string|null $ors_no
 * @property string|null $base_ors_no
 * @property string|null $ors_date
 * @property string|null $ref_book
 * @property string|null $ref_doc
 * @property string|null $payee
 * @property string|null $office
 * @property string|null $address
 * @property string|null $particulars
 * @property string|null $certified_by
 * @property string|null $certified_by_position
 * @property string|null $certified_budget_by
 * @property string|null $certified_budget_by_position
 * @property string|null $amount
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereBaseOrsNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereCertifiedBudgetBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereCertifiedBudgetByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereCertifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereCertifiedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereFunds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereOrsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereOrsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereOrsNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereParticulars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS wherePayee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereRefDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORS whereUserUpdated($value)
 */
	class ORS extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\ORSAccountEntries
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $slug
 * @property string|null $ors_slug
 * @property string|null $type
 * @property int|null $seq_no
 * @property string|null $resp_center
 * @property string|null $pap_code
 * @property string|null $dept
 * @property string|null $unit
 * @property string|null $account_code
 * @property string|null $debit
 * @property string|null $credit
 * @property string|null $fund_type
 * @property-read \App\Models\Budget\ChartOfAccounts|null $chartOfAccount
 * @property-read \App\Models\Budget\ORS|null $ors
 * @property-read \App\Models\PPU\PPURespCodes|null $responsibilityCenter
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries dvEntriesOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries orsEntriesOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries query()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereDept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereFundType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereOrsSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries wherePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereSeqNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSAccountEntries whereUnit($value)
 */
	class ORSAccountEntries extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\ORSProjectsApplied
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $slug
 * @property string|null $ors_slug
 * @property string|null $pap_code
 * @property string|null $co
 * @property string|null $mooe
 * @property string|null $total
 * @property-read \App\Models\Budget\ORS|null $ors
 * @property-read \App\Models\PPU\Pap|null $pap
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied query()
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereMooe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereOrsSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied wherePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ORSProjectsApplied whereTotal($value)
 */
	class ORSProjectsApplied extends \Eloquent {}
}

namespace App\Models\Budget{
/**
 * App\Models\Budget\PapAdjustments
 *
 * @property int $id
 * @property string|null $pap_slug
 * @property string|null $slug
 * @property string|null $ps
 * @property string|null $co
 * @property string|null $mooe
 * @property string|null $type
 * @property string|null $source_slug
 * @property string|null $destination_slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property-read \App\Models\PPU\Pap|null $destinationPap
 * @property-read \App\Models\PPU\Pap|null $sourcePap
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments query()
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereDestinationSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereMooe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments wherePapSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments wherePs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereSourceSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PapAdjustments whereUserUpdated($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course sortable($defaultParameters = null)
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
 * @property int $id
 * @property int|null $lgarec_id
 * @property int|null $uid
 * @property int $user
 * @property int $state
 * @property int $type
 * @property string $timestamp
 * @property string $device
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $processed
 * @property string|null $location
 * @property int|null $uploaded
 * @property-read \App\Models\BiometricDevices|null $deviceDetails
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\Employee|null $employeeUnion
 * @property-read \App\Models\Employee|null $permanentEmployees
 * @method static \Illuminate\Database\Eloquent\Builder|DTR newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTR newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTR query()
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereLgarecId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereUploaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTR whereUser($value)
 */
	class DTR extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DTREdits
 *
 * @property int $id
 * @property string $slug
 * @property string|null $dtr_slug
 * @property string $employee_no
 * @property string $biometric_user_id
 * @property string|null $date
 * @property string|null $time
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_created
 * @property string|null $user_updated
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits query()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereBiometricUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereDtrSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DTREdits withoutTrashed()
 */
	class DTREdits extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DailyTimeRecord
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string $employee_no
 * @property string $biometric_user_id
 * @property string $biometric_uid
 * @property string|null $date
 * @property string|null $am_in
 * @property string|null $am_out
 * @property string|null $pm_in
 * @property string|null $pm_out
 * @property string|null $ot_in
 * @property string|null $ot_out
 * @property int|null $late
 * @property int|null $undertime
 * @property int|null $calculated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remarks
 * @property string|null $remarks_updated_at
 * @property string|null $remarks_user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DTREdits> $edits
 * @property-read int|null $edits_count
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereAmIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereAmOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereBiometricUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereBiometricUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereCalculated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereLate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereOtIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereOtOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord wherePmIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord wherePmOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereRemarksUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereRemarksUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereUndertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTimeRecord whereUpdatedAt($value)
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property \Illuminate\Support\Carbon|null $date
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
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $checked_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property int $id
 * @property string|null $slug
 * @property string|null $document_id
 * @property string|null $old_document_id
 * @property string|null $path
 * @property string|null $filename
 * @property string|null $path2
 * @property int|null $filesize
 * @property string|null $reference_no
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $person_to
 * @property string|null $person_from
 * @property string|null $type
 * @property string|null $subject
 * @property string|null $folder_code
 * @property string|null $folder_code2
 * @property string|null $remarks
 * @property string|null $category
 * @property int|null $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $qr_location
 * @property string|null $visibility
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $project_id
 * @property string|null $outgoing_control_no
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Document sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFilesize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFolderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFolderCode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereOldDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereOutgoingControlNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePath2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePersonFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePersonTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereQrLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereReferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentDisseminationLog
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_slug
 * @property string|null $employee_no
 * @property string|null $email_contact_id
 * @property string|null $document_id
 * @property string|null $email
 * @property string|null $subject
 * @property string|null $content
 * @property string|null $status
 * @property int|null $send_copy
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property string|null $ip_sent
 * @property string|null $user_sent
 * @property string|null $received_at
 * @property-read \App\Models\Document|null $document
 * @property-read \App\Models\EmailContact|null $emailContact
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereEmailContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereIpSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereSendCopy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentDisseminationLog whereUserSent($value)
 */
	class DocumentDisseminationLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentFolder
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $folder_code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property int|null $retention_period
 * @property bool|null $is_permanent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents1
 * @property-read int|null $documents1_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents2
 * @property-read int|null $documents2_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereFolderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIsPermanent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereRetentionPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereUserUpdated($value)
 */
	class DocumentFolder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailContact
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $email_contact_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $contact_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLog
 * @property-read int|null $document_dissemination_log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLogAll
 * @property-read int|null $document_dissemination_log_all_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLogSendCopy
 * @property-read int|null $document_dissemination_log_send_copy_count
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereEmailContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailContact whereUserUpdated($value)
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
 * @property \Illuminate\Support\Carbon|null $date_of_birth
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
 * @property int|null $step_inc
 * @property string|null $monthly_basic
 * @property string|null $aca
 * @property string|null $pera
 * @property string|null $food_subsidy
 * @property string|null $ra
 * @property string|null $ta
 * @property string|null $cs_eligibility
 * @property string|null $cs_eligibility_level
 * @property \Illuminate\Support\Carbon|null $firstday_gov
 * @property \Illuminate\Support\Carbon|null $firstday_sra
 * @property \Illuminate\Support\Carbon|null $appointment_date
 * @property \Illuminate\Support\Carbon|null $adjustment_date
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeSpecialSkill> $employeeSpecialSkill
 * @property-read int|null $employee_special_skill_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeTraining> $employeeTraining
 * @property-read int|null $employee_training_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeVoluntaryWork> $employeeVoluntaryWork
 * @property-read int|null $employee_voluntary_work_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeFile201> $file201s
 * @property-read int|null $file201s_count
 * @property-read mixed $full_name
 * @property-read mixed $incentive_monthly_basic
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SqlServer\IncentiveTemplate> $incentiveTemplate
 * @property-read int|null $incentive_template_count
 * @property-read \App\Models\DTR|null $lastRawDtrRecord
 * @property-read \App\Models\HRU\LeaveBeginningBalance|null $leaveBegBal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveCard> $leaveCard
 * @property-read int|null $leave_card_count
 * @property-read mixed $middle_initial
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateDeductions> $nonZeroDeductions
 * @property-read int|null $non_zero_deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateIncentives> $nonZeroIncentives
 * @property-read int|null $non_zero_incentives_count
 * @property-read \App\Models\HRU\HrOtherActions|null $otherNosa
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
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee active()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee applyProjectId()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee cos()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countByDeptUnit($dept_unit_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countBySex($sex)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countBySexAndDeptUnit($dept_unit_id, $sex)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee permanent()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee sortable($defaultParameters = null)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLicensePassportNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNameExt($value)
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
 * @property \Illuminate\Support\Carbon|null $date_of_birth
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
 * @property \Illuminate\Support\Carbon|null $exam_date
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
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
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
 * @property string $type
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
 * @property string $system_remarks
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereGovServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereLwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord wherePscServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStatus($value)
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
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
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
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
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

namespace App\Models{
/**
 * App\Models\FundSource
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $fund_source_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property-read \App\Models\Employee|null $incumbentEmployee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $occupants
 * @property-read int|null $occupants_count
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereActualSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HRPayPlanitilla whereActualSalaryGcg($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions available()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereAvailables($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereSundryAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deductions whereUpdatedAt($value)
 */
	class Deductions extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives exceptBasicPay()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives isMonthly()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives query()
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
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplicationDates whereDate($value)
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
 * @property int $id
 * @property string|null $applicant_slug
 * @property string|null $slug
 * @property string|null $level
 * @property string|null $school
 * @property string|null $course
 * @property string|null $from
 * @property string|null $to
 * @property string|null $highest_level_earned
 * @property int|null $year_graduated
 * @property string|null $scholarship
 * @property int|null $selected
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation selected()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereApplicantSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereHighestLevelEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereScholarship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEducation whereYearGraduated($value)
 */
	class OApplicantEducation extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantEligibility
 *
 * @property int $id
 * @property string|null $applicant_slug
 * @property string|null $slug
 * @property string|null $eligibility
 * @property string|null $rating
 * @property string|null $date
 * @property string|null $place
 * @property string|null $license_no
 * @property string|null $license_validity
 * @property int|null $selected
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility selected()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereApplicantSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereLicenseValidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantEligibility whereSlug($value)
 */
	class OApplicantEligibility extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantPositionApplied
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $applicant_slug
 * @property string|null $publication_detail_slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied whereApplicantSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied wherePublicationDetailSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantPositionApplied whereUpdatedAt($value)
 */
	class OApplicantPositionApplied extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantTraining
 *
 * @property int $id
 * @property string|null $applicant_slug
 * @property string|null $slug
 * @property string|null $training
 * @property string|null $from
 * @property string|null $to
 * @property float|null $number_of_hours
 * @property string|null $type
 * @property string|null $conducted_by
 * @property int|null $selected
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining selected()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereApplicantSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereConductedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereNumberOfHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantTraining whereType($value)
 */
	class OApplicantTraining extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicantWork
 *
 * @property int $id
 * @property string|null $applicant_slug
 * @property string|null $slug
 * @property string|null $from
 * @property string|null $to
 * @property string|null $position
 * @property string|null $company
 * @property string|null $monthly_salary
 * @property string|null $sg_si
 * @property string|null $status
 * @property int|null $is_govt
 * @property int|null $selected
 * @property-read \App\Models\Applicant|null $applicant
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork query()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork selected()
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereApplicantSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereIsGovt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereMonthlySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereSgSi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicantWork whereTo($value)
 */
	class OApplicantWork extends \Eloquent {}
}

namespace App\Models\HRU{
/**
 * App\Models\HRU\OApplicants
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $publication_slug
 * @property string|null $publication_detail_slug
 * @property string|null $item_no
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $name_ext
 * @property string|null $gender
 * @property string|null $date_of_birth
 * @property string|null $civil_status
 * @property string|null $contact_no
 * @property string|null $email
 * @property string|null $thru
 * @property string|null $res_block
 * @property string|null $res_street
 * @property string|null $res_subdivision
 * @property string|null $res_barangay
 * @property string|null $res_city
 * @property string|null $res_province
 * @property string|null $citizenship
 * @property string|null $citizenship_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status
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
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereCitizenshipType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants wherePublicationDetailSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants wherePublicationSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereResBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereResBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereResCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereResProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereResStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereResSubdivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereThru($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OApplicants whereUpdatedAt($value)
 */
	class OApplicants extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterDetails> $hmtDetails
 * @property-read int|null $hmt_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterEmployees> $payrollMasterEmployees
 * @property-read int|null $payroll_master_employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMaster whereLockedAt($value)
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
 * @property int|null $priority
 * @property string|null $source
 * @property-read \App\Models\HRU\PayrollMasterEmployees|null $employeePayroll
 * @property-read \App\Models\HRU\PayrollMaster|null $payrollMaster
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails wherePayMasterEmployeeListingSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails wherePayMasterSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterDetails whereSource($value)
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
 * @property string|null $pay15
 * @property string|null $pay30
 * @property string|null $rata_actualdays
 * @property string|null $rata_deduction
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\PayrollMasterDetails> $employeePayrollDetails
 * @property-read int|null $employee_payroll_details_count
 * @property-read \App\Models\HRU\PayrollMaster|null $payrollMaster
 * @property-read mixed $totals
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees wherePay15($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees wherePay30($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees wherePayMasterSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataActualdays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereRataDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayrollMasterEmployees whereSlug($value)
 */
	class PayrollMasterEmployees extends \Eloquent {}
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
 * @property int $id
 * @property string|null $slug
 * @property string|null $user
 * @property string|null $employee_no
 * @property string|null $property_no
 * @property string|null $location
 * @property int|null $octet_1
 * @property int|null $octet_2
 * @property int|null $octet_3
 * @property int|null $octet_4
 * @property string|null $ip_address
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereOctet1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereOctet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereOctet3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereOctet4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress wherePropertyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpAddress whereUserUpdated($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereApprovedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereCertifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereCertifiedByPosition($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereRecommendedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereRecommendedByPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveApplication whereUserCreated($value)
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
 * @property string|null $month
 * @property string|null $credits
 * @property string|null $usable_until
 * @property string|null $remarks
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Employee|null $employee
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
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereEmployeeSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereLeaveCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveCard whereSlug($value)
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
 * @property int $id
 * @property string|null $slug
 * @property string|null $mddc
 * @property string|null $region
 * @property string|null $chairman
 * @property string|null $address
 * @property string|null $mdo
 * @property string|null $phone
 * @property string|null $geog_loc
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC query()
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereChairman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereGeogLoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereMddc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereMdo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MDDC whereUserUpdated($value)
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
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequests
 *
 * @property int $id
 * @property string $request_no
 * @property string $requisitioner
 * @property string|null $department
 * @property string $nature_of_request
 * @property string|null $request_details
 * @property string|null $summary_of_diagnostics
 * @property string|null $recommendations
 * @property string|null $returned
 * @property string|null $date_returned
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $cancelled_at
 * @property string|null $completed_at
 * @property string|null $user_completed
 * @property string|null $email
 * @property string|null $phone
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\PPU\RCDesc|null $dept
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MisRequestsStatus> $status
 * @property-read int|null $status_count
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests query()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereDateReturned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereNatureOfRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereRequestDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereRequestNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereRequisitioner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereReturned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereSummaryOfDiagnostics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereUserCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequests whereUserUpdated($value)
 */
	class MisRequests extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequestsEmailRecipients
 *
 * @property int $id
 * @property string $email
 * @property string|null $name
 * @property int|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients query()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsEmailRecipients whereUpdatedAt($value)
 */
	class MisRequestsEmailRecipients extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequestsNature
 *
 * @property int $id
 * @property string $slug
 * @property string $nature_of_request
 * @property string|null $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature query()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature whereNatureOfRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsNature whereUpdatedAt($value)
 */
	class MisRequestsNature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MisRequestsStatus
 *
 * @property int $id
 * @property string $slug
 * @property string $request_slug
 * @property string $status
 * @property string $user_created
 * @property string $ip_created
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereRequestSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MisRequestsStatus whereUserCreated($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NewsAttachments> $attachments
 * @property-read int|null $attachments_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserUpdated($value)
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsAttachments
 *
 * @property int $id
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
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAttachments whereUpdatedAt($value)
 */
	class NewsAttachments extends \Eloquent {}
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
 * @property string|null $date
 * @property string|null $abc
 * @property string|null $sai
 * @property string|null $sai_date
 * @property string|null $purpose
 * @property string|null $jr_type
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
 * @property string|null $received_at
 * @property string|null $user_received
 * @property string|null $cancelled_at
 * @property string|null $user_cancelled
 * @property string|null $cancellation_reason
 * @property string|null $remarks
 * @property string|null $supplier
 * @property string|null $supplier_address
 * @property string|null $supplier_tin
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

namespace App\Models\PPU{
/**
 * App\Models\PPU\PPURespCodes
 *
 * @property int $id
 * @property string $rc_code
 * @property string|null $parent_rc_code
 * @property string $desc
 * @property string|null $alias
 * @property string $rc
 * @property string $div
 * @property string $sec
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $department
 * @property string|null $division
 * @property string|null $section
 * @property int|null $vis
 * @property int|null $lm
 * @property int|null $payroll_vis
 * @property int|null $payroll_lm
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, PPURespCodes> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\PPU\RCDesc|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPU\Pap> $papCodes
 * @property-read int|null $pap_codes_count
 * @property-read PPURespCodes|null $parent
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes depthFirst()
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
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes treeOf(callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereAlias($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereDepartment($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereDesc($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereDiv($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereDivision($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereLm($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereParentRcCode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes wherePayrollLm($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes wherePayrollVis($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereRc($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereRcCode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereSec($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereSection($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes whereVis($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|PPURespCodes withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class PPURespCodes extends \Eloquent {}
}

namespace App\Models\PPU{
/**
 * App\Models\PPU\Pap
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $slug
 * @property int $year
 * @property string $resp_center
 * @property string $budget_type
 * @property int|null $base_pap_code
 * @property string $pap_code
 * @property string|null $pap_title
 * @property string|null $pap_desc
 * @property string|null $ps
 * @property string|null $co
 * @property string|null $mooe
 * @property string|null $pcent_share
 * @property string|null $type
 * @property string|null $status
 * @property string|null $division
 * @property string|null $section
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $date_started
 * @property string|null $projected_date_end
 * @property int|null $charge_to_income
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
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereBasePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereBudgetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereChargeToIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereDateStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereMooe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap wherePapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap wherePapDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap wherePapTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap wherePcentShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereProjectedDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap wherePs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pap withoutChargedToIncome()
 */
	class Pap extends \Eloquent {}
}

namespace App\Models\PPU{
/**
 * App\Models\PPU\RCDesc
 *
 * @property int $id
 * @property string $rc
 * @property string $name
 * @property string|null $descriptive_name
 * @property string|null $type
 * @property string|null $group
 * @property int|null $sort_sbae
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\PPU\PPURespCodes> $responsibilityCenters
 * @property-read int|null $responsibility_centers_count
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc query()
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereDescriptiveName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereRc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereSortSbae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RCDesc whereType($value)
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
 * @property int $id
 * @property string|null $slug
 * @property string|null $ps_id
 * @property string|null $employee_no
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $time_out
 * @property string|null $time_in
 * @property int|null $with_ps
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
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
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip wherePsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereTimeIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereTimeOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionSlip whereWithPs($value)
 */
	class PermissionSlip extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Plantilla
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $plantilla_id
 * @property string|null $department_unit_id
 * @property string|null $name
 * @property int|null $is_vacant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Applicant> $applicant
 * @property-read int|null $applicant_count
 * @property-read \App\Models\DepartmentUnit|null $departmentUnit
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereDepartmentUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereIsVacant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla wherePlantillaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plantilla whereUserUpdated($value)
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property \Illuminate\Support\Carbon|null $date_started
 * @property \Illuminate\Support\Carbon|null $projected_date_end
 * @property string|null $project_in_charge
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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

namespace App\Models\QC{
/**
 * App\Models\QC\Employee
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
 * @property string|null $fullname
 * @property \Illuminate\Support\Carbon|null $date_of_birth
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
 * @property int|null $step_inc
 * @property string|null $monthly_basic
 * @property string|null $aca
 * @property string|null $pera
 * @property string|null $food_subsidy
 * @property string|null $ra
 * @property string|null $ta
 * @property string|null $cs_eligibility
 * @property string|null $cs_eligibility_level
 * @property \Illuminate\Support\Carbon|null $firstday_gov
 * @property \Illuminate\Support\Carbon|null $firstday_sra
 * @property \Illuminate\Support\Carbon|null $appointment_date
 * @property \Illuminate\Support\Carbon|null $adjustment_date
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentDisseminationLog> $documentDisseminationLog
 * @property-read int|null $document_dissemination_log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyTimeRecord> $dtr_records
 * @property-read int|null $dtr_records_count
 * @property-read \App\Models\EmpBeginningCredits|null $empBeginningCredits
 * @property-read \App\Models\SqlServer\EmpMaster|null $empMaster
 * @property-read \App\Models\QC\EmployeeAddress|null $employeeAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeChildren> $employeeChildren
 * @property-read int|null $employee_children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeEducationalBackground> $employeeEducationalBackground
 * @property-read int|null $employee_educational_background_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeEligibility> $employeeEligibility
 * @property-read int|null $employee_eligibility_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeExperience> $employeeExperience
 * @property-read int|null $employee_experience_count
 * @property-read \App\Models\QC\EmployeeFamilyDetail|null $employeeFamilyDetail
 * @property-read \App\Models\QC\EmployeeHealthDeclaration|null $employeeHealthDeclaration
 * @property-read \App\Models\QC\EmployeeMatrix|null $employeeMatrix
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeMedicalHistory> $employeeMedicalHistories
 * @property-read int|null $employee_medical_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeOrganization> $employeeOrganization
 * @property-read int|null $employee_organization_count
 * @property-read \App\Models\QC\EmployeeOtherQuestion|null $employeeOtherQuestion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeRecognition> $employeeRecognition
 * @property-read int|null $employee_recognition_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeReference> $employeeReference
 * @property-read int|null $employee_reference_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeServiceRecord> $employeeServiceRecord
 * @property-read int|null $employee_service_record_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeSpecialSkill> $employeeSpecialSkill
 * @property-read int|null $employee_special_skill_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeTraining> $employeeTraining
 * @property-read int|null $employee_training_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeVoluntaryWork> $employeeVoluntaryWork
 * @property-read int|null $employee_voluntary_work_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QC\EmployeeFile201> $file201s
 * @property-read int|null $file201s_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SqlServer\IncentiveTemplate> $incentiveTemplate
 * @property-read int|null $incentive_template_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveCard> $leaveCard
 * @property-read int|null $leave_card_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PermissionSlip> $permissionSlip
 * @property-read int|null $permission_slip_count
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateDeductions> $templateDeductions
 * @property-read int|null $template_deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HRU\TemplateIncentives> $templateIncentives
 * @property-read int|null $template_incentives_count
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countByDeptUnit($dept_unit_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countBySex($sex)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee countBySexAndDeptUnit($dept_unit_id, $sex)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAdjustmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAgencyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAppointmentStatus($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLicensePassportNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePera($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhilhealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePlaceOfAssignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRespCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSalaryGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStepInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTa($value)
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeAddress
 *
 * @property int $id
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeChildren
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $fullname
 * @property \Illuminate\Support\Carbon|null $date_of_birth
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
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeChildren whereSchoolCompany($value)
 */
	class EmployeeChildren extends \Eloquent {}
}

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeEducationalBackground
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_no
 * @property string|null $level
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
 * @property-read \App\Models\QC\Employee|null $employee
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
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereGraduateYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereHonor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducationalBackground whereLevel($value)
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeEligibility
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_no
 * @property string|null $eligibility
 * @property string|null $level
 * @property float|null $rating
 * @property string|null $exam_place
 * @property \Illuminate\Support\Carbon|null $exam_date
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeExperience
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_no
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
 * @property string|null $position
 * @property string|null $company
 * @property string|null $salary
 * @property int|null $salary_grade
 * @property int|null $step
 * @property string|null $appointment_status
 * @property int|null $is_gov_service
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $system_remarks
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeFamilyDetail
 *
 * @property int $id
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeFile201
 *
 * @property int $id
 * @property string $slug
 * @property string $employee_no
 * @property string $title
 * @property string $description
 * @property string $type
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
 * @property-read \App\Models\QC\Employee|null $employeeData
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeFile201 whereEmployeeNo($value)
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeHealthDeclaration
 *
 * @property int $id
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeMatrix
 *
 * @property int $id
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeMedicalHistory
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $medical_history
 * @property string|null $medication
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereMedicalHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeMedicalHistory whereMedication($value)
 */
	class EmployeeMedicalHistory extends \Eloquent {}
}

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeOrganization
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $name
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeOrganization whereName($value)
 */
	class EmployeeOrganization extends \Eloquent {}
}

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeOtherQuestion
 *
 * @property int $id
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeRecognition
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $title
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRecognition whereTitle($value)
 */
	class EmployeeRecognition extends \Eloquent {}
}

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeReference
 *
 * @property int $id
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
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReference whereTelNo($value)
 */
	class EmployeeReference extends \Eloquent {}
}

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeServiceRecord
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
 * @property string $system_remarks
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereGovServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereLwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord wherePscServe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSequenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereSpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeServiceRecord whereStatus($value)
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeSpecialSkill
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $description
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill populate()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSpecialSkill whereId($value)
 */
	class EmployeeSpecialSkill extends \Eloquent {}
}

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeTraining
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $slug
 * @property int|null $sequence_no
 * @property string|null $title
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
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

namespace App\Models\QC{
/**
 * App\Models\QC\EmployeeVoluntaryWork
 *
 * @property int $id
 * @property string|null $employee_no
 * @property string|null $name
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $date_from
 * @property \Illuminate\Support\Carbon|null $date_to
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
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeVoluntaryWork wherePosition($value)
 */
	class EmployeeVoluntaryWork extends \Eloquent {}
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
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, RCCodeTree> $children
 * @property-read int|null $children_count
 * @property-read RCCodeTree|null $parent
 * @property-read \App\Models\PPU\PPURespCodes|null $respCenter
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree depthFirst()
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
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree treeOf(callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereParentRcCode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree whereRcCode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|RCCodeTree withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class RCCodeTree extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|SSL newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SSL newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SSL query()
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereDateImplemented($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SSL whereSalaryGrade($value)
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\BUR
 *
 * @property int $ProjectID
 * @property int $BURID
 * @property string|null $Funds
 * @property string|null $BURNo
 * @property string|null $BURDate
 * @property int|null $RefBook
 * @property string|null $RefDoc
 * @property string|null $Payee
 * @property string|null $Office
 * @property string|null $Address
 * @property string $Particulars
 * @property string|null $Particulars2
 * @property string|null $CertifiedByInitial
 * @property string|null $Position
 * @property string|null $DateSigned
 * @property string|null $CertifiedBudget
 * @property string|null $BudgetPost
 * @property string|null $DateSignedBudget
 * @property int $BURAmt
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SqlServer\BURDet> $BURDetails
 * @property-read int|null $b_u_r_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SqlServer\BURDet> $BURDetailsAll
 * @property-read int|null $b_u_r_details_all_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SqlServer\BURProjApplied> $BURProjApplied
 * @property-read int|null $b_u_r_proj_applied_count
 * @property-read \App\Models\SqlServer\Cert|null $budget
 * @property-read \App\Models\SqlServer\Cert|null $certified
 * @method static \Illuminate\Database\Eloquent\Builder|BUR newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BUR newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BUR query()
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereBURAmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereBURDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereBURID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereBURNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereBudgetPost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereCertifiedBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereCertifiedByInitial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereDateSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereDateSignedBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereFunds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereParticulars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereParticulars2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR wherePayee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereProjectID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereRefBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BUR whereRefDoc($value)
 */
	class BUR extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\BURDet
 *
 * @property int $ProjectID
 * @property string|null $BURNo
 * @property string|null $BURorDV
 * @property int $SEQNO
 * @property string|null $Dept
 * @property string|null $DeptUnit
 * @property string|null $AcctCode
 * @property int $Debit
 * @property int $Credit
 * @property-read \App\Models\SqlServer\BUR|null $BURParentData
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet query()
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereAcctCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereBURNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereBURorDV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereDept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereDeptUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereProjectID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURDet whereSEQNO($value)
 */
	class BURDet extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\BURProjApplied
 *
 * @property int|null $ProjectID
 * @property string|null $BURNo
 * @property int $SEQNO
 * @property string|null $AcctCode
 * @property int $Amount
 * @property int $COAmt
 * @property-read \App\Models\SqlServer\BUR|null $BURParentData
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied query()
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied whereAcctCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied whereBURNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied whereCOAmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied whereProjectID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BURProjApplied whereSEQNO($value)
 */
	class BURProjApplied extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\COA
 *
 * @property int $IsHeader
 * @property string $AccountCode
 * @property string|null $AccountTitle
 * @property string|null $AccountInit
 * @property int $GLGroupInd
 * @property string|null $GLGroup
 * @property int $NatureID
 * @property int $BankRecAcct
 * @property int $NormalBal
 * @property int $ISBSAccts
 * @property string|null $RespCenterCode
 * @property int $Header1
 * @property int $Header2
 * @property int $Header3
 * @property string|null $NameOfCollOfficer
 * @property string|null $ParentAcct
 * @property string|null $ChildAcct
 * @property int $HasSched
 * @property int $AUTODV
 * @property int $FAACCT
 * @property int $ForOR
 * @property int $Taxable
 * @property int $BURPERACCT
 * @property string|null $BUR_OBLIG
 * @property int $BUR_OBLIG_GROUP
 * @property string|null $G1
 * @property string|null $G2
 * @property string|null $G4
 * @property int $TREASACCT
 * @property int $TAX
 * @property string|null $ACCOUNTNUMBER
 * @method static \Illuminate\Database\Eloquent\Builder|COA newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|COA newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|COA query()
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereACCOUNTNUMBER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereAUTODV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereAccountInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereAccountTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereBUROBLIG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereBUROBLIGGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereBURPERACCT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereBankRecAcct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereChildAcct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereFAACCT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereForOR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereG1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereG2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereG4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereGLGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereGLGroupInd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereHasSched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereHeader1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereHeader2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereHeader3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereISBSAccts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereIsHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereNameOfCollOfficer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereNatureID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereNormalBal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereParentAcct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereRespCenterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereTAX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereTREASACCT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|COA whereTaxable($value)
 */
	class COA extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\Cert
 *
 * @property string|null $EmpNo
 * @property string|null $RC
 * @property string|null $DeptUnit
 * @property int $Signat
 * @property string $Initials
 * @property string|null $SignName
 * @property string|null $Birthday
 * @property string|null $Position
 * @property string|null $MD
 * @property int|null $APPROVEDBY
 * @method static \Illuminate\Database\Eloquent\Builder|Cert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cert query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereAPPROVEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereDeptUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereEmpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereMD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereRC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereSignName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cert whereSignat($value)
 */
	class Cert extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\EmpMaster
 *
 * @property string|null $EmpNo
 * @property string|null $StationID
 * @property string|null $EmpName
 * @property string|null $LastName
 * @property string|null $FirstName
 * @property string|null $MiddleName
 * @property string|null $Address
 * @property string|null $DOB
 * @property string|null $POB
 * @property string|null $Gender
 * @property string|null $CivilStat
 * @property string|null $UnderGrad
 * @property string|null $Graduate1
 * @property string|null $Graduate2
 * @property string|null $PostGrad1
 * @property string|null $Eligibility
 * @property string|null $EligibilityLevel
 * @property string|null $Dept
 * @property string|null $Division
 * @property string|null $Position
 * @property int|null $SalGrade
 * @property int|null $StepInc
 * @property string|null $ApptStat
 * @property int|null $ItemNo
 * @property int|null $MonthlyBasic
 * @property int|null $ACA
 * @property int|null $PERA
 * @property int|null $FoodSubsi
 * @property int|null $Allow1
 * @property int|null $Allow2
 * @property string|null $GovServ
 * @property string|null $FirstDay
 * @property string|null $ApptDate
 * @property string|null $AdjDate
 * @property string|null $BloodType
 * @property string|null $PHIC
 * @property string|null $TIN
 * @property string|null $HDMF
 * @property string|null $GSIS
 * @property string $ACTIVE
 * @property string|null $GROUPS
 * @property int $HDMFPREMIUMS
 * @property string|null $LOCATION
 * @property float $TAXRATE
 * @property int $FIXEDBASIC
 * @property int $HAZARDPAYELIG
 * @property int $MAGNACARTELIG
 * @property int $RA
 * @property int $TA
 * @property int $SUBSISTELIG
 * @property int $BIOMETRICUSERID
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereACA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereACTIVE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereAdjDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereAllow1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereAllow2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereApptDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereApptStat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereBIOMETRICUSERID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereCivilStat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereDOB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereDept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereEligibilityLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereEmpName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereEmpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereFIXEDBASIC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereFirstDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereFoodSubsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereGROUPS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereGSIS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereGovServ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereGraduate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereGraduate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereHAZARDPAYELIG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereHDMF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereHDMFPREMIUMS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereItemNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereLOCATION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereMAGNACARTELIG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereMonthlyBasic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster wherePERA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster wherePHIC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster wherePOB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster wherePostGrad1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereRA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereSUBSISTELIG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereSalGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereStationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereStepInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereTA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereTAXRATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereTIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmpMaster whereUnderGrad($value)
 */
	class EmpMaster extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\IncentiveTemplate
 *
 * @property string $EmpNo
 * @property string|null $IncCode
 * @property int $Taxable
 * @property int $PriorityNum
 * @property int $IncAmount
 * @property int $TaxableAmt
 * @property int $NonDelete
 * @property-read \App\Models\SqlServer\Incentives|null $incentive
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate whereEmpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate whereIncAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate whereIncCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate whereNonDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate wherePriorityNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncentiveTemplate whereTaxableAmt($value)
 */
	class IncentiveTemplate extends \Eloquent {}
}

namespace App\Models\SqlServer{
/**
 * App\Models\SqlServer\Incentives
 *
 * @property string|null $IncCode
 * @property string|null $IncDesc
 * @property int $Taxable
 * @property int $PriorityNum
 * @property int $FixedValues
 * @property int $TaxableAmount
 * @property int $TaxFree90K
 * @property int $IncCount
 * @property int $Visi
 * @property int $NonDelete
 * @property int $IsMonthly
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives query()
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereFixedValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIncCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIncCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIncDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereIsMonthly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereNonDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives wherePriorityNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereTaxFree90K($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereTaxableAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incentives whereVisi($value)
 */
	class Incentives extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereDeactivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuOptions whereOption($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereDateValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuSettings whereIntValue($value)
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
 * App\Models\Temp\Conso
 *
 * @property int $id
 * @property string|null $FUNDCLUSTER
 * @property string|null $PROPUNIQUENO
 * @property string|null $ARTICLE
 * @property string|null $DESCRIPTION
 * @property string|null $PROPERTYNO
 * @property string|null $UOM
 * @property string|null $ACQUIREDCOST
 * @property string|null $QTYPERCARD
 * @property string|null $ONHANDQTY
 * @property string|null $SHORTQTY
 * @property string|null $SHORTVALUE
 * @property string|null $DATEACQUIRED
 * @property string|null $REMARKS
 * @property string|null $ACCTEMPLOYEE_NO
 * @property string|null $ACCTEMPLOYEE_FNAME
 * @property string|null $ACCTEMPLOYEE_POST
 * @property string|null $RESPCENTER
 * @property string|null $SUPPLIER
 * @property string|null $INVOICENO
 * @property string|null $INVOICEDATE
 * @property string|null $PONO
 * @property string|null $PODATE
 * @property string|null $INVTACCTCODE
 * @property string|null $LOCATION
 * @method static \Illuminate\Database\Eloquent\Builder|Conso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conso query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereACCTEMPLOYEEFNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereACCTEMPLOYEENO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereACCTEMPLOYEEPOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereACQUIREDCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereARTICLE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereDATEACQUIRED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereDESCRIPTION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereFUNDCLUSTER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereINVOICEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereINVOICENO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereINVTACCTCODE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereLOCATION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereONHANDQTY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso wherePODATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso wherePONO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso wherePROPERTYNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso wherePROPUNIQUENO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereQTYPERCARD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereREMARKS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereRESPCENTER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereSHORTQTY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereSHORTVALUE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereSUPPLIER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conso whereUOM($value)
 */
	class Conso extends \Eloquent {}
}

namespace App\Models\Temp{
/**
 * App\Models\Temp\DocsQC
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $document_id
 * @property string|null $old_document_id
 * @property string|null $path
 * @property string|null $filename
 * @property string|null $path2
 * @property string|null $reference_no
 * @property string|null $date
 * @property string|null $person_to
 * @property string|null $person_from
 * @property string|null $type
 * @property string|null $subject
 * @property string|null $folder_code
 * @property string|null $folder_code2
 * @property string|null $remarks
 * @property string|null $category
 * @property int|null $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip_created
 * @property string|null $ip_updated
 * @property string|null $user_created
 * @property string|null $user_updated
 * @property string|null $qr_location
 * @property string|null $visibility
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Temp\Logs> $logs
 * @property-read int|null $logs_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereFolderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereFolderCode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereIpCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereIpUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereOldDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC wherePath2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC wherePersonFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC wherePersonTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereQrLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereReferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereUserCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereUserUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocsQC whereYear($value)
 */
	class DocsQC extends \Eloquent {}
}

namespace App\Models\Temp{
/**
 * App\Models\Temp\Logs
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $employee_no
 * @property string|null $email_contact_id
 * @property string|null $document_id
 * @property string|null $email
 * @property string|null $subject
 * @property string|null $content
 * @property string|null $status
 * @property int|null $send_copy
 * @property string|null $sent_at
 * @property string|null $ip_sent
 * @property string|null $user_sent
 * @method static \Illuminate\Database\Eloquent\Builder|Logs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereEmailContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereIpSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereSendCopy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereUserSent($value)
 */
	class Logs extends \Eloquent {}
}

namespace App\Models\Temp{
/**
 * App\Models\Temp\SRVConso
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SRVConso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SRVConso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SRVConso query()
 */
	class SRVConso extends \Eloquent {}
}

namespace App\Models\Temp\Sida{
/**
 * App\Models\Temp\Sida\Regions
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Temp\Sida\Provinces> $provinces
 * @property-read int|null $provinces_count
 * @method static \Illuminate\Database\Eloquent\Builder|Regions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regions query()
 */
	class Regions extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
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

