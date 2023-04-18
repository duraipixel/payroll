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
        'description',
        'added_by',
        'status'
    ];
}
