<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'institute_id',
        'place_of_work_id',
        'name',
        'description',
        'status',
        'added_by',
    ];
}
