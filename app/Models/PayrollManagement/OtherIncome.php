<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherIncome extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'academic_id',	
        'financial_start',	
        'financial_end',	
        'name',	
        'slug',	
        'maximum_limit',	
        'status',	
        'added_by',	
        'updated_by'
    ];

}
