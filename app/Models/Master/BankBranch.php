<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BankBranch extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
