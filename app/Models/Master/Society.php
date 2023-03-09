<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'contact_no',
        'landline_no1',
        'landline_no2',
        'fax',
        'email',
        'address',
        'status'
    ];
}
