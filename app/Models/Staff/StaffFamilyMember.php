<?php

namespace App\Models\Staff;

use App\Models\Master\BloodGroup;
use App\Models\Master\Nationality;
use App\Models\Master\Qualification;
use App\Models\Master\RelationshipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffFamilyMember extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'staff_family_members';
    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'relation_type_id',	
        'first_name',	
        'last_name',	
        'dob',	
        'gender',	
        'age',	
        'qualification_id',	
        'profession_type_id',	
        'blood_group_id',	
        'nationality_id',	
        'premises',	
        'remarks',	
        'residential_address',	
        'occupational_address',	
        'status',	
        'profession',
        'contact_no',
        'registration_no',
        'standard'
    ];

    public function relationship()
    {
        return $this->hasOne(RelationshipType::class, 'id', 'relation_type_id');
    }

    public function qualification()
    {
        return $this->hasOne(Qualification::class, 'id', 'qualification_id');
    }

    public function bloodGroup()
    {
        return $this->hasOne(BloodGroup::class, 'id', 'blood_group_id');
    }

    public function nationality()
    {
        return $this->hasOne(Nationality::class, 'id', 'nationality_id');
    }
}
