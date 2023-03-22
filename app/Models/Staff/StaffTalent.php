<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTalent extends Model
{
    use HasFactory;
    protected $table = 'staff_talents';
    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'talent_fields',	
        'talent_descriptions',	
        'status'
    ];
}
