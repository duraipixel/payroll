<?php

namespace App\Models\Staff;

use App\Models\Master\Bank;
use App\Models\Master\BankBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffBankDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    public function bankDetails()
    {
        return $this->hasOne(Bank::class, 'id', 'bank_id');
    }

    public function bankBranch()
    {
        return $this->hasOne(BankBranch::class, 'id', 'bank_branch_id');
    }

    
}
