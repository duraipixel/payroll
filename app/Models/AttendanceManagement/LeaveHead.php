<?php

namespace App\Models\AttendanceManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveHead extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'name',
        'code',
        'is_static',
        'sort_order',
        'status'
    ];
     public function leave_day()
    {
        return $this->hasOne(LeaveMapping::class, 'leave_head_id','id');
    }
}
