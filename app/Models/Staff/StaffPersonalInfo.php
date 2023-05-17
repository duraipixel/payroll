<?php

namespace App\Models\Staff;

use App\Models\Master\Caste;
use App\Models\Master\Community;
use App\Models\Master\Language;
use App\Models\Master\Nationality;
use App\Models\Master\OtherSchoolPlace;
use App\Models\Master\Religion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffPersonalInfo extends Model implements Auditable
{

    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'staff_personal_info';

    protected $fillable = [
        'academic_id',
        'staff_id',
        'dob',
        'mother_tongue',
        'gender',
        'marital_status',
        'marriage_date',
        'email',
        'phone_no',
        'mobile_no1',
        'mobile_no2',
        'whatsapp_no',
        'emergency_no',
        'birth_place',
        'nationality_id',	
        'religion_id',	
        'caste_id',	
        'community_id',	
        'contact_address',	
        'permanent_address',	
        'status'       
    ];

    public function motherTongue()
    {
        return $this->hasOne(Language::class, 'id', 'mother_tongue');
    }

    public function birthPlace()
    {
        return $this->hasOne(OtherSchoolPlace::class, 'id', 'birth_place');
    }

    public function nationality()
    {
        return $this->hasOne(Nationality::class, 'id', 'nationality_id');
    }

    public function religion()
    {
        return $this->hasOne(Religion::class, 'id', 'religion_id');
    }

    public function caste()
    {
        return $this->hasOne(Caste::class, 'id', 'caste_id');
    }

    public function community()
    {
        return $this->hasOne(Community::class, 'id', 'community_id');
    }

}
