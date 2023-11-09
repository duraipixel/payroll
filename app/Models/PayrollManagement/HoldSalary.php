<?php

namespace App\Models\PayrollManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class HoldSalary extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'staff_id',
        'academic_id',
        'hold_reason',
        'remarks',
        'hold_at',
        'release_at',
        'release_remarks',
        'status',
        'hold_by',
        'released_by',
        'hold_month',
        'institute_id'
    ];

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
