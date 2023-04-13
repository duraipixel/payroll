<?php

namespace App\Models\AttendanceManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'title',
        'academic_year',
        'date',
        'day',
        'is_open_to_all',
        'status',
        'added_by',
    ];
}
