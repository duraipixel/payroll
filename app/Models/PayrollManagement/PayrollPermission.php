<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'payout_month',
        'payroll_inputs',
        'emp_view_release',
        'it_statement_view',
        'payroll',
        'added_by',
        'updated_by',
        'payroll_id',
        'payroll_lock'
    ];

}
