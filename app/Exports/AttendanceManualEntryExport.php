<?php

namespace App\Exports;

use App\Models\AttendanceManagement\LeaveHead;
use App\Models\AttendanceManagement\LeaveMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\AttendanceManagement\AttendanceManualEntry;

class AttendanceManualEntryExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return LeaveHead::select('name','status','created_at')->get();
        return AttendanceManualEntry::select('users.name as staff_name','attendance_date','from_time','to_time','reporting_manager',
        'leave_statuses.name as leave_status_name','reason','attendance_manual_entries.status','attendance_manual_entries.created_at')
        ->leftJoin('users','users.id','=','attendance_manual_entries.employment_id')
        ->leftJoin('leave_statuses','leave_statuses.id','=','attendance_manual_entries.attendance_status')->get();
    }
    public function headings(): array
    {
        return [
        'Staff Name',
        'Attendance Date',
        'From Time',
        'To Time',
        'Reporting Manager',
        'Leave Status Name',
        'Reason',
        'Status',
        'Created At'
        ]; 
    }
}
