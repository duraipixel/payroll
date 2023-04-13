<?php

namespace App\Exports;

use App\Models\AttendanceManagement\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HolidayExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Holiday::select('academic_year','title','date','day','status','created_at')->get();
    }
    public function headings(): array
    {
        return [
            'Academic Year',
            'Title',
            'Date',
            'Day',
            'Status',
            'Created At',
        ]; 
    }
}
