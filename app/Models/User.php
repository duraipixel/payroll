<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\Leave\StaffLeave;
use App\Models\Master\Institution;
use App\Models\Role\RoleMapping;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffBankDetail;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffEducationDetail;
use App\Models\Staff\StaffExperiencedSubject;
use App\Models\Staff\StaffFamilyMember;
use App\Models\Staff\StaffHealthDetail;
use App\Models\Staff\StaffInsurance;
use App\Models\Staff\StaffInvigilationDuty;
use App\Models\Staff\StaffKnownLanguage;
use App\Models\Staff\StaffMedicalRemark;
use App\Models\Staff\StaffNominee;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffPfEsiDetail;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffStudiedSubject;
use App\Models\Staff\StaffTalent;
use App\Models\Staff\StaffTrainingDetail;
use App\Models\Staff\StaffWorkExperience;
use App\Models\Staff\StaffWorkingRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\Staff\StaffDeduction;
use App\Models\Staff\StaffRentDetail;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\Staff\StaffTaxSeperation;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'academic_id',
        'institute_id',
        'society_emp_code',
        'institute_emp_code',
        'emp_code',
        'locker_no',
        'first_name',
        'first_name_tamil',
        'last_name',
        'short_name',
        'division_id',
        'reporting_manager_id',
        'joining_date',
        'profile_status',
        'verification_status',
        'status', //active,inactive,transferred,retired,resigned,death
        'is_super_admin',
        'addedBy',
        'is_top_level',
        'image',
        'updatedBy',
        'transfer_status', //'active', 'retired', 'resigned', 'death'
        'refer_user_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAcademic($query)
    {
        if (session()->get('academic_id') && !empty(session()->get('academic_id'))) {

            return $query->where('users.academic_id', session()->get('academic_id'));
        }
    }

    public function scopeInstituteBased($query)
    {
        if (session()->get('staff_institute_id') && !empty(session()->get('staff_institute_id'))) {

            return $query->where('users.institute_id', session()->get('staff_institute_id'));
        }
    }

    public function staffClasses()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffClass::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasMany(StaffClass::class, 'staff_id', 'id');
        }
    }

    public function handlingClassNames()
    {
        // return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
        //             ->selectRaw('GROUP_CONCAT(classes.name) AS handling_classes');

        /* this query for sql server above 2017
        return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
                ->selectRaw('STRING_AGG(classes.name, \', \') AS handling_classes');*/
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
                ->selectRaw('SUBSTRING((SELECT \', \' + classes.name
                                    FROM staff_classes
                                    INNER JOIN classes ON classes.id = staff_classes.class_id
                                    WHERE staff_classes.staff_id = ? AND staff_classes.staff_id IS NOT NULL
                                    FOR XML PATH(\'\')), 3, 1000) AS handling_classes', [$this->refer_user_id]);
        } else {
            return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
                ->selectRaw('SUBSTRING((SELECT \', \' + classes.name
                                    FROM staff_classes
                                    INNER JOIN classes ON classes.id = staff_classes.class_id
                                    WHERE staff_classes.staff_id = ? AND staff_classes.staff_id IS NOT NULL
                                    FOR XML PATH(\'\')), 3, 1000) AS handling_classes', [$this->id]);
        }
    }

    public function staffDocuments()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffDocument::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {
            return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function staffDocumentsPending()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffDocument::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('verification_status', 'pending');
        } else {

            return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status', 'pending');
        }
    }
    public function staffDocumentsApproved()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffDocument::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('verification_status', 'approved');
        } else {

            return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status', 'approved');
        }
    }

    public function staffExperienceDocPending()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('verification_status', 'pending');
        } else {

            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status', 'pending');
        }
    }

    public function staffExperienceDocApproved()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('verification_status', 'approved');
        } else {

            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status', 'approved');
        }
    }

    public function staffEducationDocPending()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('verification_status', 'pending');
        } else {

            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status', 'pending');
        }
    }

    public function staffEducationDocApproved()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('verification_status', 'approved');
        } else {

            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status', 'approved');
        }
    }


    public function aadhaar()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Adhaar')->orWhere('name', 'Aadhaar');
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Adhaar')->orWhere('name', 'Aadhaar');
        }
    }

    public function pan()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Pan Card');
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Pan Card');
        }
    }

    public function ration()
    {

        if ($this->status == 'transferred') {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Ration Card');
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Ration Card');
        }
    }

    public function driving_license()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Driving License');
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Driving License');
        }
    }

    public function voter()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Voter ID');
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Voter ID');
        }
    }

    public function passport()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Passport');
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Passport');
        }
    }

    public function personal()
    {
        // return $this->with([
        //     'personal' => function ($query) {
        //         if ($this->status === 'transferred') {
        //             $query->where('staff_id', $this->refer_user_id);
        //         } else {
        //             $query->where('staff_id', $this->id);
        //         }
        //     }
        // ]);
        // dd( $this );
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffPersonalInfo::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasOne(StaffPersonalInfo::class, 'staff_id', 'id');
        }
    }

    public function bank()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffBankDetail::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {

            return $this->hasOne(StaffBankDetail::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function pf()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffPfEsiDetail::class, 'staff_id', 'refer_user_id')->where('type', 'pf');
        } else {

            return $this->hasOne(StaffPfEsiDetail::class, 'staff_id', 'id')->where('type', 'pf');
        }
    }

    public function esi()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffPfEsiDetail::class, 'staff_id', 'refer_user_id')->where('type', 'esi');
        } else {

            return $this->hasOne(StaffPfEsiDetail::class, 'staff_id', 'id')->where('type', 'esi');
        }
    }

    public function position()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffProfessionalData::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasOne(StaffProfessionalData::class, 'staff_id', 'id');
        }
    }

    public function adhar()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('document_type_id', 1);
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->where('status', 'active')->where('document_type_id', 1);
        }
    }
    public function pancard()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffDocument::class, 'staff_id', 'refer_user_id')->where('status', 'active')->where('document_type_id', 2);
        } else {

            return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->where('status', 'active')->where('document_type_id', 2);
        }
    }


    public function studiedSubject()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffStudiedSubject::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffStudiedSubject::class, 'staff_id', 'id');
        }
    }

    public function studiedSubjectOnly()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffStudiedSubject::class, 'staff_id', 'refer_user_id')->selectRaw('count(*) as total, subject_id')->groupBy('subject_id');
        } else {

            return $this->hasMany(StaffStudiedSubject::class, 'staff_id', 'id')->selectRaw('count(*) as total, subject_id')->groupBy('subject_id');
        }
    }

    public function experiencedSubject()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffExperiencedSubject::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffExperiencedSubject::class, 'staff_id', 'id');
        }
    }

    public function handlingSubjectNames()
    {
        /*return $this->hasOne(StaffExperiencedSubject::class, 'staff_id', 'id')->join('subjects', 'subjects.id', '=', 'staff_experienced_subjects.subject_id')
        ->selectRaw('GROUP_CONCAT(subjects.name) AS handling_subjects'); */
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffExperiencedSubject::class, 'staff_id', 'id')->join('subjects', 'subjects.id', '=', 'staff_experienced_subjects.subject_id')
                ->selectRaw('SUBSTRING((SELECT \', \' + subjects.name
                                    FROM staff_experienced_subjects
                                    INNER JOIN subjects ON subjects.id = staff_experienced_subjects.subject_id
                                    WHERE staff_experienced_subjects.staff_id = ? AND staff_experienced_subjects.staff_id IS NOT NULL
                                    FOR XML PATH(\'\')), 3, 1000) AS handling_subjects', [$this->refer_user_id]);
        } else {

            return $this->hasOne(StaffExperiencedSubject::class, 'staff_id', 'id')->join('subjects', 'subjects.id', '=', 'staff_experienced_subjects.subject_id')
                ->selectRaw('SUBSTRING((SELECT \', \' + subjects.name
                                    FROM staff_experienced_subjects
                                    INNER JOIN subjects ON subjects.id = staff_experienced_subjects.subject_id
                                    WHERE staff_experienced_subjects.staff_id = ? AND staff_experienced_subjects.staff_id IS NOT NULL
                                    FOR XML PATH(\'\')), 3, 1000) AS handling_subjects', [$this->id]);
        }
    }

    public function institute()
    {
        return $this->hasOne(Institution::class, 'id', 'institute_id');
    }

    public function healthDetails()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffHealthDetail::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasOne(StaffHealthDetail::class, 'staff_id', 'id');
        }
    }

    public function appointment()
    {
        if ($this->status == 'transferred') {

            return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'refer_user_id')
                ->when(!empty(session()->get('academic_id')), function ($query) {
                    $query->where(function ($query1) {
                        $query1->where('academic_id', session()->get('academic_id'));
                        $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
                        $query1->orWhere('is_till_active', 'yes');
                    });
                })->orderBy('to_appointment', 'desc');
        } else {

            return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'id')
                ->when(!empty(session()->get('academic_id')), function ($query) {
                    $query->where(function ($query1) {
                        $query1->where('academic_id', session()->get('academic_id'));
                        $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
                        $query1->orWhere('is_till_active', 'yes');
                    });
                })->orderBy('to_appointment', 'desc');
        }
    }

    public function appointmentCount()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'id');
        }
    }

    public function allAppointment()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'id');
        }
    }

    public function firstAppointment()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'refer_user_id')->orderby('from_appointment', 'asc');
        } else {

            return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'id')->orderby('from_appointment', 'asc');
        }
    }

    public function reporting()
    {
        return $this->hasOne(User::class, 'id', 'reporting_manager_id');
    }

    public function reporting_managers()
    {
        return $this->hasMany(ReportingManager::class, 'manager_id', 'id');
    }

    public function roleMapped()
    {
        return $this->hasOne(RoleMapping::class, 'staff_id', 'id');
    }

    public function knownLanguages()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffKnownLanguage::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffKnownLanguage::class, 'staff_id', 'id');
        }
    }

    public function medicalRemarks()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffMedicalRemark::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffMedicalRemark::class, 'staff_id', 'id');
        }
    }

    public function familyMembers()
    {
        // return $this->hasMany(StaffFamilyMember::class, 'staff_id', 'id')->dd();

        if ($this->status == 'transferred') {
            return $this->hasMany(StaffFamilyMember::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasMany(StaffFamilyMember::class, 'staff_id', 'id');
        }
    }

    public function nominees()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffNominee::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasMany(StaffNominee::class, 'staff_id', 'id');
        }
    }

    public function education()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id');
        }
    }

    public function careers()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id');
        }
    }

    public function training()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffTrainingDetail::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffTrainingDetail::class, 'staff_id', 'id');
        }
    }

    public function invigilation()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffInvigilationDuty::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffInvigilationDuty::class, 'staff_id', 'id');
        }
    }

    public function loans()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffBankLoan::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffBankLoan::class, 'staff_id', 'id');
        }
    }

    public function insurance()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffInsurance::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffInsurance::class, 'staff_id', 'id');
        }
    }

    public function leaves()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffLeave::class, 'staff_id', 'id');
        }
    }

    public function salary()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffSalary::class, 'staff_id', 'refer_user_id');
        } else {

            return $this->hasMany(StaffSalary::class, 'staff_id', 'id');
        }
    }

    public function currentSalaryPattern()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffSalaryPattern::class, 'staff_id', 'refer_user_id')
                ->where('status', 'active')
                ->where('is_current', 'yes');
        } else {

            return $this->hasOne(StaffSalaryPattern::class, 'staff_id', 'id')
                ->where('status', 'active')
                ->where('is_current', 'yes');
        }
    }

    public function salaryApproved()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffSalary::class, 'staff_id', 'refer_user_id')->where('is_salary_processed', 'yes');
        } else {
            return $this->hasMany(StaffSalary::class, 'staff_id', 'id')->where('is_salary_processed', 'yes');
        }
    }

    public function salaryPending()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffSalary::class, 'staff_id', 'refer_user_id')->where('is_salary_processed', 'no');
        } else {
            return $this->hasMany(StaffSalary::class, 'staff_id', 'id')->where('is_salary_processed', 'no');
        }
    }

    public function leavesApproved()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'refer_user_id')->where('status', 'approved');
        } else {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status', 'approved');
        }
    }

    public function leavesPending()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'refer_user_id')->where('status', 'pending');
        } else {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status', 'pending');
        }
    }

    public function casualLeaves()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'refer_user_id')
                ->where('status', 'approved')
                ->where('leave_category', 'Casual Leave')
                ->where('academic_id', academicYearId());;
        } else {

            return $this->hasMany(StaffLeave::class, 'staff_id', 'id')
                ->where('status', 'approved')
                ->where('leave_category', 'Casual Leave')
                ->where('academic_id', academicYearId());
        }
    }

    public function earnedLeaves()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'refer_user_id')
                ->where('status', 'approved')
                ->where('leave_category', 'Casual Leave')
                ->where('academic_id', academicYearId());
        } else {

            return $this->hasMany(StaffLeave::class, 'staff_id', 'id')
                ->where('status', 'approved')
                ->where('leave_category', 'Casual Leave')
                ->where('academic_id', academicYearId());
        }
    }

    public function talents()
    {
        if ($this->status == 'transferred') {

            return $this->hasMany(StaffTalent::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {

            return $this->hasMany(StaffTalent::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function workingRelations()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffWorkingRelation::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {
            return $this->hasMany(StaffWorkingRelation::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    // DOCUMENT LOCKER RELATIONS

    public function StaffDocument()
    {

        if ($this->status == 'transferred') {
            return $this->hasMany(StaffDocument::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {
            return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function StaffEducationDetail()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {
            return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id')->where('status', 'active');
        }
    }
    public function StaffWorkExperience()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {

            return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function StaffLeave()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {
            return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function StaffSalary()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffSalary::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {

            return $this->hasMany(StaffSalary::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function StaffAppointmentDetail()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'refer_user_id')->where('status', 'active');
        } else {
            return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'id')->where('status', 'active');
        }
    }

    public function staffNationalPestion()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffDeduction::class, 'staff_id', 'refer_user_id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                ->where('tax_section_items.slug', 'national-pension-system-80-ccd-1b');
        } else {

            return $this->hasOne(StaffDeduction::class, 'staff_id', 'id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                ->where('tax_section_items.slug', 'national-pension-system-80-ccd-1b');
        }
    }

    public function staffMedicalPolicyDeduction()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffDeduction::class, 'staff_id', 'refer_user_id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                ->where('tax_section_items.slug', 'medical-insurance-for-assessee-or-any-member-of-the-family-medical-insurance');
        } else {

            return $this->hasOne(StaffDeduction::class, 'staff_id', 'id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                ->where('tax_section_items.slug', 'medical-insurance-for-assessee-or-any-member-of-the-family-medical-insurance');
        }
    }

    public function staffBankInterest80TTADedcution()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffDeduction::class, 'staff_id', 'refer_user_id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                ->where('tax_section_items.slug', 'savings-bank-interest-80tta');
        } else {

            return $this->hasOne(StaffDeduction::class, 'staff_id', 'id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                ->where('tax_section_items.slug', 'savings-bank-interest-80tta');
        }
    }

    public function staffRentByAcademic()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffRentDetail::class, 'staff_id', 'refer_user_id')->where('academic_id', academicYearId());
        } else {
            return $this->hasOne(StaffRentDetail::class, 'staff_id', 'id')->where('academic_id', academicYearId());
        }
    }

    public function staffRents()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffRentDetail::class, 'staff_id', 'refer_user_id');
        } else {
            return $this->hasOne(StaffRentDetail::class, 'staff_id', 'id');
        }
    }

    public function staffSeperation()
    {
        if ($this->status == 'transferred') {
            return $this->hasOne(StaffTaxSeperation::class, 'staff_id', 'refer_user_id')->where('academic_id', academicYearId());
        } else {
            return $this->hasOne(StaffTaxSeperation::class, 'staff_id', 'id')->where('academic_id', academicYearId());
        }
    }

    public function workedDays()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'refer_user_id')
                ->where('attendance_status', 'Present');
        } else {

            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id')
                ->where('attendance_status', 'Present');
        }
    }

    public function leaveDays()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'refer_user_id')->where('attendance_status', 'Absence');
        } else {

            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id')->where('attendance_status', 'Absence');
        }
    }

    function Attendance()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'refer_user_id');
        } else {
            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id');
        }
    }

    function AttendancePresent()
    {
        if ($this->status == 'transferred') {
            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'refer_user_id')->where('attendance_status', 'Present');
        } else {
            return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id')->where('attendance_status', 'Present');
        }
    }

    public function retirement() {
        return $this->belongsTo(StaffRetiredResignedDetail::class, 'id', 'staff_id');
    }
}
