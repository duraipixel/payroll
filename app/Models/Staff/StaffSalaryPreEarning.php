<?php

namespace App\Models\Staff;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StaffSalaryPreEarning extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'salary_month',
        'amount',
        'remarks',
        'earnings_type', //'bonus', 'allowance', 'arrear', 'other'
        'status', //'active', 'inactive', 'paid'
        'added_by',
        'is_verified'
    ];

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
