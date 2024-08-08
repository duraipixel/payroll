<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPercentageLog extends Model
{
    use HasFactory;

    protected $fillable = ['salary_field_id',
    'initial_percentage',
    'new_percentage',
    'effective_from',
    'remarks',
    'payout_month'
     ];
    public function sallery_fields()
    {
        return $this->hasOne(SalaryField::class, 'id', 'salary_field_id');
    }

}
