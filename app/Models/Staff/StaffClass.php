<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'class_id'
    ];
}
