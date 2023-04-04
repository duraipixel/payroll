<?php

namespace App\Exports;

use App\Models\Master\BankBranch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankBranchExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BankBranch::join('banks','banks.id','=','bank_branches.bank_id')
        ->select('banks.name as bank_name','bank_branches.name','bank_branches.ifsc_code','bank_branches.address','bank_branches.status','bank_branches.created_at')
        ->get();
    }
    public function headings(): array
    {
        return [
        'Bank name',
        'Branch',
        'IFSC code',
        'Address',
        'Status',
        'Created At',
        ]; 
    }
}
