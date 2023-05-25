<?php

namespace App\Models\Announcement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'institute_id',
        'announcement_type',
        'from_date',
        'to_date',
        'message',
        'announcement_created_id',
        'sort_order',
        'status'
    ];

}
