<?php

namespace App\Models\Staff;

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
}
