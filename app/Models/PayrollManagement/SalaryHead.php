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
        'status'
    ];
}
