<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRetiredResignedDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	'staff_id',	
        'last_working_date',	
        'types',	//'resigned', 'retired', 'death', 'illness'
        'subject',	
        'document',	
        'reason',	
        'status'
    ];

}
