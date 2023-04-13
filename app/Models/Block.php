<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_id',
        'institute_id',
        'place_of_work_id',
        'name',
        'description',
        'status',
        'added_by',
    ];
    public function class()
    {
        return $this->hasMany(BlockClasses::class,'block_id','id')->where('status','active')->select('class_id');
    }
}
