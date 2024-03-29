<?php

namespace App\Models\Master;

use App\Models\Staff\StaffProfessionalData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Designation extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'name',
        'sort_order',	
        'status',
        'can_assign_report_manager'
    ];

    public function staffEnrollments()
    {
        return $this->hasMany(StaffProfessionalData::class, 'designation_id', 'id');
    }
    
}
