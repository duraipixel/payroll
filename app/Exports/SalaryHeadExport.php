<?php

namespace App\Exports;

use App\Models\PayrollManagement\SalaryHead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryHeadExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SalaryHead::select('name','description','status','created_at')->get();
    }
    public function headings(): array
    {
        return [
        'Name',
        'Description',
        'Status',
        'Created At',
        ]; 
    }
}
