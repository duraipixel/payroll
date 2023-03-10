<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'bank_id',
        'name',
        'ifsc_code',
        'email',
        'mobile_no',
        'fax',
        'address',
        'sort_order',
        'status'
    ];
}
