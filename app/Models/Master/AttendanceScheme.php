<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceScheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'name',
        'sort_order',	
        'status'
    ];
}