<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportingManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'reportee_id',	
        'manager_id',	
        'institute_id',	
        'assigned_date',	
        'end_date',	
        'status',
        'is_top_level'
    ];

    public function reportee()
    {
        return $this->hasOne(User::class, 'id', 'reportee_id');
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }
}
