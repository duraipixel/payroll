<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReportingManager extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    public function havingStaffs() {
        return $this->hasMany(User::class, 'reporting_manager_id', 'manager_id');
    }

    public function havingManagers() {
        return $this->hasMany(ReportingManager::class, 'reportee_id', 'manager_id');
    }
}
