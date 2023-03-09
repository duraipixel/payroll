<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_year',
        'to_year',
        'from_month',
        'to_month',
        'is_current',
        'order_by',
        'status'
    ];
}
