<?php

namespace App\Models\PayrollManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StaffSalaryPattern extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'salary_no',
        'total_earnings',
        'total_deductions',
        'gross_salary',
        'net_salary',
        'salary_month',
        'salary_year',
        'effective_from',
        'is_salary_processed',
        'salary_approved_by',
        'salary_processed_on',
        'status',
        'payout_month',
        'remarks',
        'employee_remarks',
        'verification_status',
        'addedBy',
        'lastUpdatedBy',
        'is_current',
        'approved_on',
        'rejected_on',
        'rejectedBy',
        'approved_remarks',
        'removed_remarks'
    ];

    public function patternFields() {
        return $this->hasMany(StaffSalaryPatternField::class, 'staff_salary_pattern_id', 'id');
    }

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
