<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Exports\AttendanceManualEntryExport;
use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\Staff\StaffAppointmentDetail;
use Illuminate\Http\Request;
use App\Models\Master\NatureOfEmployment; 
use App\Models\AttendanceManagement\LeaveStatus;
use App\Models\AttendanceManagement\LeaveHead;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceManualEntryController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Attendance Manual Entry',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Attendance Manual Entry'
                ),
            )
        );
        if($request->ajax())
        {
            //$data = LeaveMapping::select('*');
            $data = AttendanceManualEntry::select('attendance_manual_entries.*','users.name as staff_name','leave_statuses.name as leave_status_name')
            ->leftJoin('users','users.id','=','attendance_manual_entries.employment_id')
            ->leftJoin('leave_statuses','leave_statuses.id','=','attendance_manual_entries.attendance_status');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('users.name','like',"%{$keywords}%") 
                        ->orWhere('leave_statuses.name','like',"%{$keywords}%")
                        ->orWhere('reason','like',"%{$keywords}%")
                        ->orWhereDate('attendance_date',$date)
                        ->orWhereDate('attendance_manual_entries.created_at',$date);
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
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="javascript:void(0);" onclick="getLeaveMappingModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteLeaveMappingStatus(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.attendance_management.attendance_manual_entry.index',compact('breadcrums'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'employee_id' => 'required',
            'attendance_date' => 'required',
            'reporting_id' => 'required',
            'leave_status_id' => 'required',
            'reason' => 'required',
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['employment_id'] = $request->employee_id;
            $ins['attendance_date'] = $request->attendance_date;
            $ins['from_time'] = $request->from_time;
            $ins['to_time'] = $request->to_time;
            $ins['reporting_manager'] = $request->reporting_id;
            $ins['attendance_status'] = $request->leave_status_id;
            $leave_status=LeaveStatus::find($request->leave_status_id);   
                
            if( $leave_status->name==='Absent')
            {              
                $ins['absent_status'] ='Pending';
            }
            else
            {
                $ins['absent_status'] ='';  
            }
            $ins['reason'] = $request->reason;
                if($request->status)
                {
                    $ins['status'] = 'active';
                }
                else{
                    $ins['status'] = 'inactive';
                }
            //dd($ins);
            $data = AttendanceManualEntry::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {

            $error = 1;
            $message = $validator->errors()->all();

        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }
    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Attendance Manual Entry';
        $employee_details = User::where('is_super_admin', '=', null)->get();
        $leave_status = LeaveStatus::where('status','active')->get();
        $leave_heads = LeaveHead::where('status','active')->get();
        if(isset($id) && !empty($id))
        {
            $info = AttendanceManualEntry::find($id);
            $title = 'Update Attendance Manual Entry';
        }

         $content = view('pages.attendance_management.attendance_manual_entry.add_edit_form',compact('info','title','employee_details','leave_status','leave_heads'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title','employee_details','leave_status','leave_heads'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = AttendanceManualEntry::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Leave Status status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = AttendanceManualEntry::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new AttendanceManualEntryExport,'AttendanceManualEntryExport.xlsx');
    }
    public function getStaffLeaveDetails(Request $request)
    {
        $staff_id=$request->staff_id;
        $staff_nature=StaffAppointmentDetail::with('employment_nature')->where('staff_id',$staff_id)->first();
        if($staff_nature)
        {
            $staff_employment_nature=$staff_nature->employment_nature->name;
            $nemp_id=$staff_nature->nature_of_employment_id;
            $academic_id=academicYearId();
            $get_leave_details=LeaveMapping::with('leave_head')->where('nature_of_employment_id',$nemp_id)->where('leave_mappings.academic_id',$academic_id)->get();
            $staff_taken_leave=AttendanceManualEntry::where('employment_id',$staff_id)->where('academic_id',$academic_id)->get();
            return response()->json([ 'status' => 1]);
        }        
    }
}
