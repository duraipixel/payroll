<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Master\Institution;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffBankDetail;
use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffExperiencedSubject;
use App\Models\Staff\StaffHealthDetail;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffPfEsiDetail;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffStudiedSubject;
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
        'addedBy'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function staffClasses()
    {
        return $this->hasMany(StaffClass::class, 'staff_id', 'id');
    }

    public function staffDocuments() {
        return $this->hasMany(StaffDocument::class, 'staff_id', 'id');
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
        return $this->hasOne(StaffBankDetail::class, 'staff_id', 'id');
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

    
}
