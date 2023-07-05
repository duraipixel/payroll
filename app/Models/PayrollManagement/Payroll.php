<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_date',
        'modified_date',
        'from_date',
        'to_date',
        'name',
        'employee_loc_date',
        'employee_it_view_lock_date',
        'payroll_input_loc_date',
        'payroll_lock_date',
        'payroll_release_date',
        'payroll_input_release_date',
        'employee_release_date',
        'employee_it_view_release_date',
        'locked',
        'added_by'
    ];

}
