<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'society_id',
        'academic_id',
        'code',
        'flag',
        'short_name',
        'email',
        'contact_no',
        'landline_no1',
        'landline_no2',
        'city',
        'district',
        'state',
        'country',
        'post_code',
        'gstin_no',
        'school_recognise',
        'fax',
        'address',
        'status'
    ];
}
