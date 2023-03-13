<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'bank_id',	
        'bank_branch_id',	
        'account_number',	
        'passbook_image',	
        'cancelled_cheque',	
        'status',
        'account_name'
    ];
}
