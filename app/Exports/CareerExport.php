<?php

namespace App\Exports;

use App\Models\Staff\StaffRetiredResignedDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CareerExport implements FromCollection, WithHeadings
{
    public $types;
    public function __construct($types) {
        $this->types = $types;
    }
    public function collection()
    {
        
        return StaffRetiredResignedDetail::select('last_working_date','users.name',
        'users.institute_emp_code','reason','types','staff_retired_resigned_details.created_at')
        ->leftJoin('users','users.id','=','staff_retired_resigned_details.staff_id')
        ->where('types', $this->types)
        ->get();
    }
    public function headings(): array
    {
        return [
            'Last Working Day',
            'Employee Name',
            'Employee Code',
            'Reason',
            'Leaving Type',
            'Created At'
        ]; 
    }
}
