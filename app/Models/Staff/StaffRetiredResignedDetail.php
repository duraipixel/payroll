<?php

namespace App\Models\Staff;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffRetiredResignedDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'last_working_date',	
        'types',	//'resigned', 'retired', 'death', 'illness'
        'subject',	
        'document',	
        'reason',	
        'status', //active, inactive
        'is_completed', //yes, no
        'institute_id'

    ];

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
