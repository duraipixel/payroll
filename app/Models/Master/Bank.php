<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'name',
        'bank_code',
        'short_name',
        'sort_order',
        'status'
    ];
    
}
