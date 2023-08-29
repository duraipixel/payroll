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

    public function hra() {
        return $this->hasOne(StaffSalaryPatternField::class, 'staff_salary_pattern_id', 'id')->where('field_name', 'HRA');
    }

    public function basic() {
        return $this->hasOne(StaffSalaryPatternField::class, 'staff_salary_pattern_id', 'id')->where('field_name', 'basic');
    }

    public function pba() {
        return $this->hasOne(StaffSalaryPatternField::class, 'staff_salary_pattern_id', 'id')->where('field_name', 'Performance based Allowance')
                    ->orWhere('field_name', 'pba');
    }

    public function pbada() {
        return $this->hasOne(StaffSalaryPatternField::class, 'staff_salary_pattern_id', 'id')
                        ->where('field_name', 'PBADA');
                    
    }

    public function da() {
        return $this->hasOne(StaffSalaryPatternField::class, 'staff_salary_pattern_id', 'id')->where('field_name', 'Dearance Allowance');
    }

    public function salaries() {
        return $this->hasMany(StaffSalary::class, 'salary_pattern_id', 'id');
    }

}
