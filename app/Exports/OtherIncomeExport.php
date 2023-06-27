<?php

namespace App\Exports;

use App\Models\Master\OtherSchool;
use App\Models\PayrollManagement\OtherIncome;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OtherIncomeExport implements FromCollection,WithHeadings
{
  
    public function collection()
    {
        return OtherIncome::select('name','status','created_at')->get();
    }
    public function headings(): array
    {
        return [
        'Name',
        'Status',
        'Created At',
        ]; 
    }
}
