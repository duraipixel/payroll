<?php

namespace App\Models\PayrollManagement;

use App\Models\Master\NatureOfEmployment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryField extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'name',
        'short_name',
        'description',
        'added_by',
        'status',
        'salary_head_id',
        'entry_type', //'manual', 'calculation'
        'no_of_numerals',
        'order_in_salary_slip',
        'is_static',
        'nature_id'
    ];

    public function field_items()
    {
        return $this->hasOne(SalaryFieldCalculationItem::class, 'parent_field_id', 'id');
    }

    public function employeeNature() {
        return $this->hasOne(NatureOfEmployment::class, 'id', 'nature_id');
    }
    public function Fieldlogs()
    {
        return $this->hasMany(SalaryPercentageLog::class, 'salary_field_id', 'id');
    }
    public function PrecentageLog()
    {
        return $this->hasOne(SalaryPercentageLog::class, 'salary_field_id', 'id')->orderBy('id', 'desc');
    }
    
}
