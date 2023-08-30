<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Exports\AttendanceManualEntryExport;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\Staff\StaffAppointmentDetail;
use Illuminate\Http\Request;
use App\Models\AttendanceManagement\LeaveStatus;
use App\Models\AttendanceManagement\LeaveHead;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceManualEntryController extends Controller
{
    private AttendanceRepository $repository;

    public function __construct(AttendanceRepository $repository) {
        $this->repository = $repository;
    }

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
        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        return view('pages.attendance_management.attendance_manual_entry.index', compact('breadcrums', 'from_year'));

    }

    public function ajax_view(Request $request) {
        
        $month_no = $request->month_no;
        $dates = $request->dates;
       
        return view('pages.attendance_management.attendance_manual_entry._ajax_month_data', compact('dates'));

    }

    public function ajaxDatatable(Request $request) {

        if ($request->ajax()) {

            $data = $request->all();
            
            return $this->repository->getAttendanceDatatable($data);
           
        }
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'employee_id' => 'required',
            'attendance_date' => 'required',
            // 'reporting_id' => 'required',
            'leave_status_id' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->passes()) {
            $user_info = User::find($request->employee_id);
            $ins['academic_id'] = academicYearId();
            $ins['employment_id'] = $request->employee_id;
            $ins['institute_emp_code'] = $user_info->institute_emp_code;
            $ins['attendance_date'] = $request->attendance_date;
            $ins['from_time'] = $request->from_time;
            $ins['to_time'] = $request->to_time;
            $ins['institute_id'] = session()->get('staff_institute_id');
            $ins['attendance_status_id'] = $request->leave_status_id;
            $leave_status = LeaveStatus::find($request->leave_status_id);
            $ins['attendance_status'] = $leave_status->name;
            $ins['reason'] = $request->reason;
            $ins['status'] = $request->status;
            // dd( $ins );
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
        $employee_details = User::where('is_super_admin', '=', null)
                            ->where(['status' => 'active', 'transfer_status' => 'active'])
                            ->InstituteBased()->get();
        $leave_status = LeaveStatus::where('status', 'active')->get();
        $leave_heads = LeaveHead::where('status', 'active')->get();

        if (isset($id) && !empty($id)) {
            $info = AttendanceManualEntry::find($id);
            $title = 'Update Attendance Manual Entry';
        }

        $content = view('pages.attendance_management.attendance_manual_entry.add_edit_form', compact('info', 'title', 'employee_details', 'leave_status', 'leave_heads'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title', 'employee_details', 'leave_status', 'leave_heads'));
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

        return response()->json(['message' => "Successfully deleted state!", 'status' => 1]);
    }

    public function export()
    {
        return Excel::download(new AttendanceManualEntryExport, 'AttendanceManualEntryExport.xlsx');
    }

    public function getStaffLeaveDetails(Request $request)
    {
        $staff_id = $request->staff_id;
        $staff_nature = StaffAppointmentDetail::with('employment_nature')->where('staff_id', $staff_id)->first();
        if ($staff_nature) {
            $staff_employment_nature = $staff_nature->employment_nature->name;
            $nemp_id = $staff_nature->nature_of_employment_id;
            $academic_id = academicYearId();
            $get_leave_details = LeaveMapping::with('leave_head')->where('nature_of_employment_id', $nemp_id)->where('leave_mappings.academic_id', $academic_id)->get();
            $staff_taken_leave = AttendanceManualEntry::where('employment_id', $staff_id)->where('academic_id', $academic_id)->get();
            return response()->json(['status' => 1]);
        }
    }
}
