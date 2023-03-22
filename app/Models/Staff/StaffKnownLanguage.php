<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffKnownLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'language_id',	
        'read',	
        'write',	
        'speak',	
        'status'
    ];
}
