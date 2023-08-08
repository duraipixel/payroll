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
        'status',
        'is_super_admin',
        'addedBy',
        'is_top_level',
        'image',
        'updatedBy'
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
        if( session()->get('academic_id') && !empty( session()->get('academic_id') ) ){

            return $query->where('users.academic_id', session()->get('academic_id'));
        }
    }

    public function scopeInstituteBased($query)
    {
        if( session()->get('staff_institute_id') && !empty( session()->get('staff_institute_id') ) ){

            return $query->where('users.institute_id', session()->get('staff_institute_id'));
        }
    }

    public function staffClasses()
    {
        return $this->hasMany(StaffClass::class, 'staff_id', 'id');
    }

    public function handlingClassNames()
    {
        // return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
        //             ->selectRaw('GROUP_CONCAT(classes.name) AS handling_classes');

        /* this query for sql server above 2017
        return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
                ->selectRaw('STRING_AGG(classes.name, \', \') AS handling_classes');*/

        return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
                ->selectRaw('SUBSTRING((SELECT \', \' + classes.name
                                FROM staff_classes
                                INNER JOIN classes ON classes.id = staff_classes.class_id
                                WHERE staff_classes.staff_id = ? AND staff_classes.staff_id IS NOT NULL
                                FOR XML PATH(\'\')), 3, 1000) AS handling_classes', [$this->id]);
    }

    public function staffDocuments() {
        return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active');
    }

    public function staffDocumentsPending() {
        return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status','pending');
    }
    public function staffDocumentsApproved() {
        return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status','approved');
    }
    public function staffExperienceDocPending() {
        return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status','pending');
    }
    public function staffExperienceDocApproved() {
        return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status','approved');
    }
    public function staffEducationDocPending() {
        return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status','pending');
    }
    public function staffEducationDocApproved() {
        return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id')->where('status', 'active')->where('verification_status','approved');
    }

    
    public function aadhaar() {
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Adhaar')->orWhere('name', 'Aadhaar');
    }

    public function pan() {
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Pan Card');
    }

    public function ration() {
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Ration Card');
    }

    public function driving_license() {
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Driving License');
    }

    public function voter() {
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Voter ID');
    }

    public function passport() {
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Passport');
    }

    public function personal()
    {
        return $this->hasOne(StaffPersonalInfo::class, 'staff_id', 'id');
    }

    public function bank()
    {
        return $this->hasOne(StaffBankDetail::class, 'staff_id', 'id')->where('status', 'active');
    }

    public function pf()
    {
        return $this->hasOne(StaffPfEsiDetail::class, 'staff_id', 'id')->where('type', 'pf');
    }

    public function esi()
    {
        return $this->hasOne(StaffPfEsiDetail::class, 'staff_id', 'id')->where('type', 'esi');
    }

    public function position()
    {
        return $this->hasOne(StaffProfessionalData::class, 'staff_id', 'id');
    }

    public function studiedSubject()
    {
        return $this->hasMany(StaffStudiedSubject::class, 'staff_id', 'id');
    }

    public function studiedSubjectOnly()
    {
        return $this->hasMany(StaffStudiedSubject::class, 'staff_id', 'id')->selectRaw('count(*) as total, subject_id')->groupBy('subject_id');
    }

    public function experiencedSubject()
    {
        return $this->hasMany(StaffExperiencedSubject::class, 'staff_id', 'id');
    }

    public function handlingSubjectNames()
    {
        /*return $this->hasOne(StaffExperiencedSubject::class, 'staff_id', 'id')->join('subjects', 'subjects.id', '=', 'staff_experienced_subjects.subject_id')
        ->selectRaw('GROUP_CONCAT(subjects.name) AS handling_subjects'); */

        return $this->hasOne(StaffExperiencedSubject::class, 'staff_id', 'id')->join('subjects', 'subjects.id', '=', 'staff_experienced_subjects.subject_id')
                ->selectRaw('SUBSTRING((SELECT \', \' + subjects.name
                                FROM staff_experienced_subjects
                                INNER JOIN subjects ON subjects.id = staff_experienced_subjects.subject_id
                                WHERE staff_experienced_subjects.staff_id = ? AND staff_experienced_subjects.staff_id IS NOT NULL
                                FOR XML PATH(\'\')), 3, 1000) AS handling_subjects', [$this->id]);

    }

    public function institute()
    {
        return $this->hasOne(Institution::class, 'id', 'institute_id');
    }

    public function healthDetails()
    {
        return $this->hasOne(StaffHealthDetail::class, 'staff_id', 'id');
    }

    public function appointment() {
        return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'id')
            ->when( !empty(session()->get('academic_id')),function($query){
                $query->where(function($query1) {
                    $query1->where( 'academic_id', session()->get('academic_id') );
                    $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
                });
            });
    }
    
    public function appointmentCount() {
        return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'id');
    }

    public function allAppointment() {
        return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'id');
    }

    public function firstAppointment() {
        return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'id')->orderby('from_appointment', 'asc');
    }

    public function reporting()
    {
        return $this->hasOne(User::class, 'id', 'reporting_manager_id');
    }

    public function reporting_managers() {
        return $this->hasMany(ReportingManager::class, 'manager_id', 'id');
    }

    public function roleMapped()
    {
        return $this->hasOne(RoleMapping::class, 'staff_id', 'id');
    }
    
    public function knownLanguages()
    {
        return $this->hasMany(StaffKnownLanguage::class, 'staff_id', 'id');
    }

    public function medicalRemarks()
    {
        return $this->hasMany(StaffMedicalRemark::class, 'staff_id', 'id');
    }

    public function familyMembers()
    {
        return $this->hasMany(StaffFamilyMember::class, 'staff_id', 'id');
    }

    public function nominees()
    {
        return $this->hasMany(StaffNominee::class, 'staff_id', 'id');
    }

    public function education()
    {
        return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id');
    }

    public function careers()
    {
        return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id');
    }

    public function training()
    {
        return $this->hasMany(StaffTrainingDetail::class, 'staff_id', 'id');
    }

    public function invigilation()
    {
        return $this->hasMany(StaffInvigilationDuty::class, 'staff_id', 'id');
    }

    public function loans()
    {
        return $this->hasMany(StaffBankLoan::class, 'staff_id', 'id');
    }

    public function insurance()
    {
        return $this->hasMany(StaffInsurance::class, 'staff_id', 'id');
    }

    public function leaves()
    {
        return $this->hasMany(StaffLeave::class, 'staff_id', 'id');
    }

    public function salary()
    {
        return $this->hasMany(StaffSalary::class, 'staff_id', 'id');
    }

    public function currentSalaryPattern()
    {
        return $this->hasOne(StaffSalaryPattern::class, 'staff_id', 'id')->where('status', 'active');
    }
    
    public function salaryApproved()
    {
        return $this->hasMany(StaffSalary::class, 'staff_id', 'id')->where('is_salary_processed','yes');
    }
    public function salaryPending()
    {
        return $this->hasMany(StaffSalary::class, 'staff_id', 'id')->where('is_salary_processed','no');
    }

    public function leavesApproved()
    {
        return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status','approved');
    }

    public function leavesPending()
    {
        return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status','pending');
    }

    public function talents()
    {
        return $this->hasMany(StaffTalent::class, 'staff_id', 'id')->where('status', 'active');
    }

    public function workingRelations()
    {
        return $this->hasMany(StaffWorkingRelation::class, 'staff_id', 'id')->where('status', 'active');
    }

    // DOCUMENT LOCKER RELATIONS

    public function StaffDocument() {
        return $this->hasMany(StaffDocument::class, 'staff_id', 'id')->where('status', 'active');

    }
    public function StaffEducationDetail() {
        return $this->hasMany(StaffEducationDetail::class, 'staff_id', 'id')->where('status', 'active');

    }
    public function StaffWorkExperience() {
        return $this->hasMany(StaffWorkExperience::class, 'staff_id', 'id')->where('status', 'active');

    }
    public function StaffLeave() {
        return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status', 'active');

    }
    public function StaffSalary() {
        return $this->hasMany(StaffSalary::class, 'staff_id', 'id')->where('status', 'active');
    } 
    public function StaffAppointmentDetail() {
        return $this->hasMany(StaffAppointmentDetail::class, 'staff_id', 'id')->where('status', 'active');
    }

    public function staffNationalPestion() {
        return $this->hasOne(StaffDeduction::class, 'staff_id', 'id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
                    ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
                    ->where('tax_section_items.slug', 'national-pension-system-80-ccd-1b');
    }

    public function staffMedicalPolicyDeduction() {
        return $this->hasOne(StaffDeduction::class, 'staff_id', 'id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
        ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
        ->where('tax_section_items.slug', 'medical-insurance-for-assessee-or-any-member-of-the-family-medical-insurance');
    }

    public function staffBankInterest80TTADedcution() {
        return $this->hasOne(StaffDeduction::class, 'staff_id', 'id')->join('tax_section_items', 'tax_section_items.id', '=', 'staff_deductions.tax_section_item_id')
        ->where('tax_section_items.academic_id', academicYearId())->where('tax_section_items.tax_scheme_id', getCurrentTaxSchemeId())
        ->where('tax_section_items.slug', 'savings-bank-interest-80tta');
    }

    public function staffRentByAcademic() {
        return $this->hasOne(StaffRentDetail::class, 'staff_id', 'id')->where('academic_id', academicYearId());
    }

    public function staffRents() {
        return $this->hasOne(StaffRentDetail::class, 'staff_id', 'id');
    }

    public function staffSeperation() {
        return $this->hasOne(StaffTaxSeperation::class, 'staff_id', 'id')->where('academic_id', academicYearId());
    }

    public function workedDays() {
        return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id')
        ->where('attendance_status', 'Present');
    }

    public function leaveDays() {
        return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id')->where('attendance_status', 'Absence');
    }

    function Attendance() {
        return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id');
    }
    function AttendancePresent() {
        return $this->hasMany(AttendanceManualEntry::class, 'employment_id', 'id')->where('attendance_status','Present');
    } 
}
