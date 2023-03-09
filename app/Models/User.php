<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'is_super_admin'
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
    
}
