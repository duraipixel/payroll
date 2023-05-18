<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryFieldCalculationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_field_id',
        'field_id',
        'field_name',
        'percentage',
        'order_by'
    ];

}
