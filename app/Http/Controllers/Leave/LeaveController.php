<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\Holiday;
use App\Models\AttendanceManagement\LeaveHead;
use App\Models\CalendarDays;
use App\Models\Leave\StaffLeave;
use App\Models\PayrollManagement\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    public function leaveCountDays(Request $request){
       
       if($request->type=='grid'){
        $value=0;
       
        foreach($request->leave['radio'] as $data){
       
            if($data=='afternoon'){
                $value+=0.5;
            }elseif($data=='forenoon'){
                $value+=0.5;
            }else{
                $value+=1;
    
            }
       
       } 
      
       return number_format($value,1);
    }else{
        $value=0;
        
        foreach($request->leave['radio'] as $key=>$data){
            if($data=='afternoon' && isset($request->leave['check'][$key]) && $request->leave['check'][$key]==1){
                $value+=0.5;
            }elseif($data=='forenoon'  && isset($request->leave['check'][$key]) && $request->leave['check'][$key]==1){
                $value+=0.5;
            }elseif($data=='both' && isset($request->leave['check'][$key]) && $request->leave['check'][$key]==1){
                $value+=1;
    
            }
           
       }
  
       return number_format($value,1);
    }
        
      

       
      
    }
    public function leaveAvailableDays(Request $request){

        if ($request->ajax()) {
            $staff_id = $request->staff_id;
            $period = CarbonPeriod::create($request->leave_start, $request->leave_end);
            $period->toArray();

            $holidays = CalendarDays::whereBetween('calendar_date', [$request->leave_start, $request->leave_end])->whereIn('days_type',['holiday','week_off'])->select('calendar_date')->get();
            //$week_off = CalendarDays::whereBetween('calendar_date', [$request->leave_start, $request->leave_end])->where('days_type', 'week_off')->get();

            $leaves = StaffLeave::where('staff_id', $staff_id)
            ->where('from_date', '>=', $request->leave_start)
            ->where('to_date', '<=', $request->leave_end)
            ->where('status', 'approved')
            ->get();

            $days = [];
            foreach ($period as $date) {
            $days[]=$date->format('Y-m-d');       
            }
            $leave = [];
            foreach ($holidays as $holiday) {
            $leave[]=$holiday->calendar_date;       
            }
            $total_days=array_diff($days,$leave);
            $all_days =  sizeof($days);
            $leave_days = sizeof($days) - ($holidays->count());
            return response()->json(['leave_days' => $leave_days, 'total_days' => $total_days]);
            //return sizeof($days);
            // $age = array("dates"=>$days, "leaves"=>$leaves, "holidays"=>$holidays, "week_off"=>$week_off);
            // return json_encode($age);
        }
    }
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Leave Management',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Leave List'
                ),
            )
        );
        if ($request->ajax()) {

            $data = StaffLeave::select('staff_leaves.*', 'users.name as staff_name')->with(['staff_info'])
                ->join('users', 'users.id', '=', 'staff_leaves.staff_id');
            $status = $request->get('status');
            $keywords = $request->datatable_search ?? '';

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($keywords) {
                        // $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords) {
                            $q->where('staff_leaves.application_no', 'like', "%{$keywords}%")
                                ->orWhere('users.name', 'like', "%{$keywords}%");
                            // ->orWhereDate('staff_leaves.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" )">' . ucfirst($row->status) . '</a>';
                    return $status;
                })

                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->editColumn('no_of_days',function ($row) {
                    return number_format($row['no_of_days'],1);
                })
                ->editColumn('granted_days',function ($row) {
                    return number_format($row['granted_days'],1);
                })
                ->addColumn('action', function ($row) {
                    $url = Storage::url($row->document);
                    $approve_btn = '';
                    if (isset($row->approved_document) && !empty($row->approved_document)) {

                        $approved_doc = Storage::url($row->approved_document);
                        $approve_btn = '<a href="' . asset('public' . $approved_doc) . '" tooltip="Approved Document" target="_blank"  class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                    }

                    if ($row->status == 'pending') {

                        $approve_btn = '<a href="javascript:void(0);" onclick="approveLeave(' . $row->id . ')" class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                            <i class="fa fa-check"></i></a>';
                    }
                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="' . asset('public' . $url) . '" target="_blank" tooltip="Leave form"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteLeave(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                                <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }
                    return $edit_btn . $approve_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'created_at', 'name']);
            return $datatables->make(true);
        }
        return view('pages.leave.request_leave.index', compact('breadcrums'));
    }

    public function addEditModal(Request $request)
    {   
        $title = 'Add Leave Request';
        $id = $request->id;
        $info = '';
        $taken_leave  = [];
        if ($id) {
            $title = 'Approve Leave Request';
            $info = StaffLeave::find($id);
            $taken_leave = StaffLeave::where('staff_id', $info->staff_id)->where('from_date', '<', $info->from_date)->get();
        }
        $leave_category = LeaveHead::where('status', 'active')->get();

        return view('pages.leave.request_leave.add_edit_form', compact('title', 'leave_category', 'info', 'taken_leave'));
    }

    public function saveLeaveRequest(Request $request)
    { 
      

        $id = $request->id ?? '';
        $validate_array = [
            'leave_category_id' => 'required',
            'staff_id' => 'required',
            'requested_date' => 'required',
            'no_of_days' => 'required',
            'reason' => 'required',
        ];

        if (isset($id) && !empty($id)) {
            [
                'leave_category_id' => 'required',
                'staff_id' => 'required',
                'requested_date' => 'required',
                'no_of_days' => 'required',
                'reason' => 'required',
                'no_of_days_granted' => 'required|numeric',
                'application_file' => 'file|required',
                'leave_granted' => 'required'
                
            ];
        }

        $validator      = Validator::make($request->all(), $validate_array);
        

        if ($validator->passes()) {

            $req_dates = $request->requested_date;
            $req_dates = explode('-', $req_dates);

            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', current($req_dates))));
            $end_date = date('Y-m-d', strtotime(str_replace('/', '-', end($req_dates))));

            /**
             * Check already request to that date
             */
            $check = StaffLeave::where('staff_id', $request->staff_id)
                ->where('from_date', $from_date)
                ->when($id != '', function ($query) use ($id) {
                    $query->where('id', '!=', $id);
                })->first();

            if ($check) {
                $error = 1;
                $message = ['Leave Request already submit for this date'];
                return response()->json(['error' => $error, 'message' => $message]);
            } else {

                $staff_info = User::with('appointment.work_place')->find($request->staff_id);
                $leave_category_info = LeaveHead::find($request->leave_category_id);

                if (isset($id) && !empty($id)) {

                    $leave_info = StaffLeave::find($id);
                    if ($request->hasFile('application_file')) {

                        $files = $request->file('application_file');
                        $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                        $directory = 'leave/' . $leave_info->application_no;
                        $filename  = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($files));
                        $ins['approved_document'] = 'public/' . $filename;
                    } else {
                        $error = 1;
                        $message = ['Application document upload is required'];
                        return response()->json(['error' => $error, 'message' => $message]);
                    }
                    if(empty($request->leave_granted)){
                        $error = 1;
                        $message = ['Leave Granted Field is required'];
                        return response()->json(['error' => $error, 'message' => $message]);

                    }
                    $ins['is_granted'] = $request->leave_granted;
                    if ($request->leave_granted == 'yes') {
                        $approved_date = Carbon::now();
                        $ins['approved_date'] = $approved_date->toDateTimeString();
                    } else {
                        $rejected_date = Carbon::now();
                        $ins['rejected_date'] = $rejected_date->toDateTimeString();
                    }
                    $ins['granted_days'] = $request->no_of_days_granted ?? "0";
                    $ins['remarks']  = $request->remarks;
                    $ins['granted_designation']  = '';
                    $ins['granted_by']  = auth()->user()->id;
                    $ins['granted_start_date']  = $leave_info->from_date;
                    $ins['granted_end_date']  = $leave_info->to_date;
                    if(isset($request->leave)){
                        $leave_day=[];
                        foreach(json_decode($leave_info->leave_days) as $key=>$data){
                           
                            $leave_days['date']=$data->date;
                            $leave_days['check']=$request->leave['check'][$key] ?? 0;
                            $leave_days['type']=$data->type;
                            $leave_day[]=$leave_days;

                        }
                       
                     
                        $ins['leave_days']=json_encode($leave_day);
                    }
                  
                } else {
                    if(empty($request->no_of_days) || $request->no_of_days==0 || $request->no_of_days==0.0){
                        $error = 1;
                        $message = ['No Of Days Field is required'];
                        return response()->json(['error' => $error, 'message' => $message]);

                    }

                    $ins['academic_id'] = academicYearId();
                    $ins['application_no'] = leaveApplicationNo($request->staff_id, $leave_category_info->code);
                    $ins['staff_id'] = $request->staff_id;
                    $ins['designation'] = $request->designation;
                    $ins['place_of_work'] = $staff_info->appointment->work_place->name ?? null;
                    $ins['salary'] = $request->salary ?? null;
                    $ins['from_date'] = $from_date;
                    $ins['to_date'] = $end_date;
                    $ins['no_of_days'] = $request->no_of_days ?? "0";
                    $ins['reason'] = $request->reason;
                    if(isset($request->leave)){
                        $leave_day=[];
                        foreach($request->leave['radio'] as$key=>$data){
                            $leave_days['date']=$request->leave['date'][$key];
                            $leave_days['type']=$data;
                            $leave_day[]=$leave_days;

                        }
                       
                       
                        $ins['leave_days']=json_encode($leave_day);

                    }
                 
                }
                $ins['leave_category'] = $leave_category_info->name;
                $ins['leave_category_id'] = $leave_category_info->id;

                $ins['address'] = $request->address ?? null;
                $ins['addedBy'] = auth()->user()->id;
                $ins['reporting_id'] = $staff_info->reporting_manager_id ?? null;

                if ($request->leave_granted) {
                    if ($request->leave_granted == 'yes') {
                        $ins['status'] = 'approved';
                        $approved_date = Carbon::now();
                        $ins['approved_date'] = $approved_date->toDateTimeString();
                    } else {
                        $ins['status'] = 'rejected';
                        $rejected_date = Carbon::now();
                        $ins['rejected_date'] = $rejected_date->toDateTimeString();
                    }
                } else {
                    $ins['status'] = 'pending';
                }
               
                /** generate leave form and send */
                $leave_info = StaffLeave::updateOrCreate(['id' => $id], $ins);
                generateLeaveForm($leave_info->id);

                $error = 0;
                $message = 'Leave Request submit successfully';
            }
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function overview(Request $request)
    {
        $breadcrums = array(
            'title' => 'Leave Management Overview',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Overview'
                ),
            )
        );

        $user = User::where('status', 'active')
            ->InstituteBased()
            ->get();

        return view('pages.leave.overview', compact('breadcrums', 'user'));
    }

    public function setWorkingDays(Request $request)
    {
        $breadcrums = array(
            'title' => 'Set Working Days',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Set working Days'
                ),
            )
        );

        return view('pages.leave.working_days', compact('breadcrums'));
    }

    public function getStaffLeaveInfo(Request $request)
    {

        $staff_id = $request->staff_id;
        $month_start = date('Y-m-1');
        $month_end = date('Y-m-t');
        $month = date('F');
        /**
         * 1.get leave days
         * 2. get worked days
         */
        $working_days = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'working_day')->count();
        $holidays = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'holiday')->count();
        $week_off = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'week_off')->count();

        $user = User::find($staff_id);
        $leaves = StaffLeave::selectRaw('sum(no_of_days) as leaves, staff_leaves.*')
            ->where('staff_id', $staff_id)->where('from_date', '>=', $month_start)
            ->where('to_date', '<=', $month_end)
            // ->where('status', 'approved')
            ->groupBy('staff_leaves.leave_category')
            ->get();

        return view('pages.leave._staff_leave_details', compact('user', 'leaves', 'month', 'working_days', 'holidays', 'week_off'));
    }

    public function deleteLeave(Request $request)
    {

        $id = $request->id;
        $info = StaffLeave::find($id);
        /**
         *  1. Make sure payroll has done for that month
         * 
         */
        $payroll_check = Payroll::whereDate('from_date', '<=', $info->from_date)
            ->whereDate('to_date', '>=', $info->from_date)
            ->whereNull('payroll_date')->first();

        if ($payroll_check) {

            $error = 0;
            $message = 'Successfully deleted';
            $info->delete();
        } else {
            $error = 1;
            $message = 'Payroll already processed. Cannot delete Please contact administrator';
        }

        return array('error' => $error, 'message' => $message);
    }
}
