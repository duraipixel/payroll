<?php

namespace App\Exports;

use App\Models\PayrollManagement\SalaryField;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryFieldExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SalaryField::select( 'nature_of_employments.name as nature', 'salary_heads.name as head_name', 'salary_fields.name', 'short_name', 'entry_type', 'order_in_salary_slip', 'salary_fields.status')
                    ->join('nature_of_employments', 'nature_of_employments.id', '=', 'salary_fields.nature_id')
                    ->join('salary_heads', 'salary_heads.id', '=', 'salary_fields.salary_head_id')
                    ->get();
    }
    public function headings(): array
    {
        return [
        'Employee Nature',
        'Salary Head',
        'Salary Field Name',
        'Code',
        'Entry Type',
        'Sort Order',
        'Status'
        ]; 
    }
}
