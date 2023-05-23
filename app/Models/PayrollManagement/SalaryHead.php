<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryHead extends Model
{

    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'name',
        'description',
        'sort_order',
        'added_by',
        'status',
        'is_static'
    ];

    public function fields()
    {
        return $this->hasMany(SalaryField::class, 'salary_head_id', 'id')->orderBy('order_in_salary_slip', 'asc');
    }
    
}
