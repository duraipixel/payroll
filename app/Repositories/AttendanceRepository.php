<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use Carbon\Carbon;
use DataTables;

class AttendanceRepository extends Controller
{

    public function getAttendanceDatatable($request)
    {
        
        $attendance_date = $request['dates'];
        $start_date = date('Y-m-1',  strtotime($attendance_date ));
        $ends_date = date('Y-m-t',  strtotime($attendance_date ));
        $attendance_status = $request['attendance_status'] ?? '';
        
        $data = AttendanceManualEntry::select('attendance_manual_entries.*', 'users.name as staff_name', 'leave_statuses.name as leave_status_name')
            ->leftJoin('users', 'users.id', '=', 'attendance_manual_entries.employment_id')
            ->leftJoin('leave_statuses', 'leave_statuses.id', '=', 'attendance_manual_entries.attendance_status_id')
            ->where('attendance_date', '>=', $start_date )
            ->where('attendance_date', '<=', $ends_date )
            ->when(!empty( $attendance_status), function($q) use($attendance_status) {
                $q->where('attendance_status', $attendance_status);
            })
            ->where('users.institute_id', session()->get('staff_institute_id'));

     
        $datatable_search = $request['datatable_search'] ?? '';
        $keywords = $datatable_search;

        $datatables = Datatables::of($data)
            ->filter(function ($query) use ($keywords) {
                if ($keywords) {
                    $date = date('Y-m-d', strtotime($keywords));
                    return $query->where(function ($q) use ($keywords, $date) {

                        $q->where('users.name', 'like', "%{$keywords}%")
                            ->orWhere('users.institute_emp_code', 'like', "%{$keywords}%")
                            ->orWhere('leave_statuses.name', 'like', "%{$keywords}%")
                            ->orWhere('reason', 'like', "%{$keywords}%")
                            ->orWhereDate('attendance_date', $date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return leaveMappingStatusChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
            ->editColumn('reporting_manager', function($row) {
                return $row->reportingManager()->name ?? '';
            } )
            ->addColumn('leave_type', function($row){
                $text = '-';
                $class = 'danger';
                if( $row->attendance_status == 'Absence') {
                    
                    $text = getStaffLeaveRequestType($row->employment_id, $row->attendance_date);
                    if( $text == 'Pending' ) {
                        $class = 'warning';
                    } else if( $text == 'Approved') {
                        $class = 'success';
                    }
                    

                }
                $leave_type = '<a href="javascript:void(0);" class="small btn btn-sm btn-light-'.$class.'">'.$text.'</a>';
                return $leave_type;
            })
             ->addColumn('leave_status', function($row){
                $text = '-';
                 $class = 'danger';
                if( $row->attendance_status == 'Absence') {
                    
                    $text = getStaffLeaveRequestStatus($row->employment_id, $row->attendance_date);
                    if( $text == 'Pending' ) {
                        $class = 'warning';
                    } else if( $text == 'Approved') {
                        $class = 'success';
                    }
                   

                }
                 $leave_status = '<a href="javascript:void(0);" class="small btn btn-sm btn-light-'.$class.'">'.$text.'</a>';
                return $leave_status;
            })
            ->addColumn('action', function ($row) {
                $route_name = request()->route()->getName();
                $edit_btn = $del_btn = '';
                if (access()->buttonAccess('att-manual-entry', 'add_edit')) {
                    $edit_btn = '<a href="javascript:void(0);" onclick="getLeaveMappingModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-edit"></i>
                            </a>';
                }
                if (access()->buttonAccess('att-manual-entry', 'delete')) {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteLeaveMappingStatus(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                                <i class="fa fa-trash"></i></a>';
                }

                return $edit_btn . $del_btn;
            })
            ->rawColumns(['action', 'status', 'leave_status','leave_type']);
        return $datatables->make(true);
    }
}
