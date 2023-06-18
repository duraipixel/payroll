<?php

namespace App\Models\Staff;

use App\Models\Master\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffStudiedSubject extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'staff_id',
        'subject_id',
        'class_id',	
        'status',
        'subjects',
        'classes'
    ];
    
    public function subjects() {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
