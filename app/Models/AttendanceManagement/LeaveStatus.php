<?php

namespace App\Models\AttendanceManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveStatus extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'name',
        'sort_order',
        'status'
    ];
}
