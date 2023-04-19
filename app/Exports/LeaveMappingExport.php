<?php

namespace App\Exports;

use App\Models\AttendanceManagement\LeaveHead;
use App\Models\AttendanceManagement\LeaveMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveMappingExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return LeaveHead::select('name','status','created_at')->get();
        return LeaveMapping::select('nature_of_employments.name as nature_emp_name','leave_heads.name as head_name',
        'leave_mappings.leave_days','leave_mappings.carry_forward','leave_mappings.status','leave_mappings.created_at')
        ->leftJoin('nature_of_employments','nature_of_employments.id','=','leave_mappings.nature_of_employment_id')
        ->leftJoin('leave_heads','leave_heads.id','=','leave_mappings.leave_head_id')->get();
    }
    public function headings(): array
    {
        return [
        'Nature of employment ',
        'Leave Heads',
        'No of Leave Days',
        'Is Carry Forward',
        'Status',
        'Created At'
        ]; 
    }
}
