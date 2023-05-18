<?php

namespace App\Models\PayrollManagement;

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
        'order_in_salary_slip'
    ];

    public function field_items()
    {
        return $this->hasMany(SalaryFieldCalculationItem::class, 'parent_field_id', 'id');
    }
}
