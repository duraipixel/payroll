<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffTalent extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'staff_talents';
    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'talent_fields',	
        'talent_descriptions',	
        'status'
    ];
}
