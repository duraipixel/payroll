<?php

namespace App\Exports;

use App\Models\Master\Bank;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bank::select('name','bank_code','short_name','status','created_at')->get();
    }
    public function headings(): array
    {
        return [
        'Bank name',
        'Bank code',
        'Bank short name',
        'Status',
        'Created At',
        ]; 
    }
}
