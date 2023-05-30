<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
use App\Models\Staff\StaffTrainingDetail;
use App\Models\Staff\StaffWorkExperience;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable;
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
        'image'
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
        return $this->hasOne(StaffClass::class, 'staff_id', 'id')->join('classes', 'classes.id', '=', 'staff_classes.class_id')
                    ->selectRaw('GROUP_CONCAT(classes.name) AS handling_classes');
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
        return $this->hasOne(StaffDocument::class, 'staff_id', 'id')->select('staff_documents.*')->join('document_types', 'document_types.id', '=', 'staff_documents.document_type_id')->where('name', 'Adhaar');
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

    public function experiencedSubject()
    {
        return $this->hasMany(StaffExperiencedSubject::class, 'staff_id', 'id');
    }

    public function handlingSubjectNames()
    {
        return $this->hasOne(StaffExperiencedSubject::class, 'staff_id', 'id')->join('subjects', 'subjects.id', '=', 'staff_experienced_subjects.subject_id')
        ->selectRaw('GROUP_CONCAT(subjects.name) AS handling_subjects');

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
        return $this->hasOne(StaffAppointmentDetail::class, 'staff_id', 'id');
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

    public function leavesApproved()
    {
        return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status','approved');
    }

    public function leavesPending()
    {
        return $this->hasMany(StaffLeave::class, 'staff_id', 'id')->where('status','pending');
    }

    
}
