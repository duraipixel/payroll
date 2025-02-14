<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\Holiday;
use App\Models\AttendanceManagement\LeaveHead;
use App\Models\CalendarDays;
use App\Models\CalenderYear;
use App\Models\Leave\StaffLeave;
use App\Models\PayrollManagement\Payroll;
use App\Models\User;
use App\Models\Staff\StaffLeaveMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Master\StaffCategory;
use App\Models\Master\Designation;
use Illuminate\Support\Facades\Session;
use App\Models\AcademicYear;
use App\Helpers\NotificationHelper;
use App\Models\Staff\StaffRetiredResignedDetail;
class LeaveController extends Controller
{   
    public function Leavedocument(Request $request,$id){
        $data=generateLeaveForm($id,'download');
        return $data;
    }
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
        if(isset($request->leave_id)){
         $staff_leave=StaffLeave::find($request->leave_id);
        $value=number_format($staff_leave->granted_days,1);
        foreach(json_decode($staff_leave->leave_days) as $key=>$data){
            if($data->type=='afternoon' && $data->check=="1" && isset($request->leave['cancell'][$key])){
                $value-=0.5;
            }elseif($data->type=='both' && $data->check=="1" && isset($request->leave['cancell'][$key])){
                $value -=1;
            }elseif($data->type=='forenoon'&& $data->check=="1" && isset($request->leave['cancell'][$key])){
                $value -=0.5;
            }
           }
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
        
           
       }
  
       return number_format($value,1);
    }
        
      

       
      
    }
    public function previouesLeave(Request $request)
    {
        $id = $request->id;
        $taken_leave = [];
        $title = 'Leave';
        $leave_count=0;
        $academic=AcademicYear::find(academicYearId());
        $month_data=date('d',strtotime($request->month));
       if(isset($request->month)){
        $start_array=array('04','05','06','07','08','09','10','11','12');
        if(in_array($month_data,$start_array)){
            $year=$academic->from_year;
        }else{
            $year=$academic->to_year;
        }
       }
        else{
            $year=date('Y');
        }
     
        if (isset($id) && !empty($id)) {
            $taken_leave = StaffLeave::where('staff_id', $id)->whereYear('from_date',$year)->get();
            foreach($taken_leave as $leave){
                $leave_count+=$leave->granted_days;

            }
          
        }
        return view('pages.leave.request_leave.Leave_previous', compact('title','taken_leave'));
    }
    public function leaveAvailableDays(Request $request){

        if ($request->ajax()) {
            $staff_id = $request->staff_id;
            $resigned=StaffRetiredResignedDetail::where('last_working_date','<=',$request->leave_start)->pluck('staff_id');
            if(count($resigned)>0 && in_array((int)$staff_id,$resigned->toArray())){
                return response()->json(['type'=>'retired']);   
            }
                $period = CarbonPeriod::create($request->leave_start, $request->leave_end);
                $period->toArray();

            // $periods= CarbonPeriod::create($request->leave_start, $request->leave_end);
            //     $period= $periods->filter(function ($date){
            //     return !$date->isSaturday() && !$date->isSunday();
            //     });
            //     $period->toArray();
            
            

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
            $all_days =  sizeof($days);
            $leave_days = sizeof($days) - ($holidays->count());
          if($request->leave_type !=3 && $request->leave_type !=2 && $request->leave_type !=4){
            $total_days=array_diff($days,$leave);
            
           }else{
            $total_days =$days;
           }
            return response()->json(['type'=>'leave' ,'leave_days' => $leave_days, 'total_days' => $total_days]);
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
            $institute_id=session()->get('staff_institute_id');
            $academic=AcademicYear::find(academicYearId());
            $startDate = $request->get('from_date') ?? Carbon::createFromDate(date('Y'), 1, 1)->toDateString();
            $endDate =$request->get('to_date') ??  Carbon::createFromDate(date('Y'), 12, 31)->toDateString();
            $data = StaffLeave::whereBetween('from_date',[$startDate,$endDate])->select('staff_leaves.*', 'users.name as staff_name','users.institute_emp_code as institute_code')->with(['staff_info'])
                ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
             ->when($institute_id, function ($q) use($institute_id) {
            $q->Where('users.institute_id', $institute_id);
                 });
            $status = $request->get('status');
            $keywords = $request->datatable_search ?? '';
            $leave_status = $request->leave_status ?? '';
            $datatables =  Datatables::of($data)
           
                ->filter(function ($query) use ($status, $keywords,$leave_status) {
                    if ($keywords) {
                        // $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords) {
                          $q->where('users.name', 'like', "%{$keywords}%")->orWhere('users.institute_emp_code', 'like', "%{$keywords}%")->orWhere('staff_leaves.application_no', 'like', "%{$keywords}%");
                            // ->orWhereDate('staff_leaves.created_at', $date);
                        });
                    }
                    if($leave_status && $leave_status!=''&& $leave_status!='all'){
                    return $query->where(function($q) use($leave_status){
                         $q->where('staff_leaves.status',$leave_status);
                    });
                  }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'approved') ? 'success' : (($row->status == 'rejected') ? 'danger' : 'primary')) . '" )">' . ucfirst($row->status) . '</a>';
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
                    $url='';
                   
                    if(isset($row->document)&& !empty($row->document)){
                     $document = storage_path('app/'.$row->document);
                      if(file_exists($document)){
                        $url = Storage::url('app/'.$row->document);

                      }

                    }
                   
                    $approve_btn = '';
                    $edit = '';
                    if (isset($row->approved_document) && !empty($row->approved_document)) {
if(access()->buttonAccess('leaves.list', 'add_edit')){
                        $approved_doc = Storage::url($row->approved_document);
                        $approve_btn = '<a href="' . asset('public' . $approved_doc) . '" tooltip="Approved Document" target="_blank"  class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                        }
                    }
                    if ($row->status == 'pending') {
                       if(access()->buttonAccess('leaves.list', 'add_edit')){
                         $approve_btn ='<a href="' . url("/leaves/add", ['id' => $row->id,'type' => 'approved']) . '" class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px">
    <i class="fa fa-check"></i>
</a>';
                         $edit = '<a href="' . url("/leaves/add", ['id' => $row->id,'type' => 'edit']) . '" class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px">
    <i class="fa fa-edit"></i>
</a>';
                    }else{
                         $approve_btn = '';
                        $edit='';
                         
                    }
                       
                    }else{
                        if(access()->buttonAccess('leaves.list', 'add_edit')){
                        $edit='<a href="javascript:void(0);"class="btn btn-icon btn-active-secondary btn-light-secondary mx-1 w-30px h-30px">
                        <i class="fa fa-edit"></i>
                        </a>';
                    }

                    }
                    if (access()->buttonAccess('leaves.list', 'add_edit')) {

                        if(isset($url) && $url!=''){
                    $edit_btn = '<a href="' . url('leave/document/' . $row->id) . '" target="_blank" tooltip="Leave form"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                        }else{
                            $edit_btn = '<a href="' . url('leave/document/' . $row->id) . '" target="_blank" tooltip="Leave form"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                        }
                        

                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess('leaves.list', 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteLeave(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                                <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }
                    return $edit.$edit_btn .$approve_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'created_at', 'name']);
            return $datatables->make(true);
        }
        return view('pages.leave.request_leave.index', compact('breadcrums'));
    }

    public function addEditModal(Request $request,$id='',$type='')
    {   

        $title = 'Add Leave Request';
        $id = $id;
        $info = '';
        $taken_leave  = [];
        $leave_count=0;
        if ($id) {
            $title = 'Approve Leave Request';
            $info = StaffLeave::find($id);
            $type = $type;
            $taken_leave = StaffLeave::where('staff_id', $info->staff_id)->whereYear('from_date',date('Y', strtotime($info->from_date)))->get();
            foreach($taken_leave as $leave){
                $leave_count+=$leave->granted_days;

            }
            
        }
        $leave_category = LeaveHead::where('status', 'active')->get();

        return view('pages.leave.request_leave.add_edit_form', compact('title', 'leave_category', 'info', 'taken_leave','leave_count','type'));
    }

    public function saveLeaveRequest(Request $request)
    { 
      

        $id = $request->id ?? '';
        $type = $request->type ?? '';
        $validate_array = [
            'leave_category_id' => 'required',
            'staff_id' => 'required',
            'requested_date' => 'required',
            'no_of_days' => 'required',
            'reason' => 'required',
        ];

        if (isset($id) && !empty($id) && $type=='approved') {
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
            if(empty($id)){
            $leave_head= LeaveHead::find($request->leave_category_id);
            $staffleavesHead=StaffleaveAllocated($request->staff_id,date('Y',strtotime($from_date)));
            $used_leave=leaveData($request->staff_id,date('Y',strtotime($from_date)),$leave_head->name);
            $key = $staffleavesHead->firstWhere('leave_head_id', $request->leave_category_id);
            if(isset($used_leave) && isset($leave_head) && isset($key)){
                if($request->leave_category_id==2){
                    $remaining_leave = $key['carry_forward_count'] - $used_leave;
                }else{
                    $remaining_leave = $key['no_of_leave'] - $used_leave;
                }
            
                if ($request->no_of_days > $remaining_leave) {
                    $error = 1;
                    $message = [
                      'You have only ' . $remaining_leave . ' day(s) of leave left for this year. You cannot apply for ' . $request->no_of_days . ' day(s). Please contact the administrator.'
                    ];
                    return response()->json(['error' => $error, 'message' => $message]);
                }
            }
        }
   
            /**
             * Check already request to that date
             */
             $user = User::find($request->staff_id);
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

                if (isset($id) && !empty($id) && $type=='approved') {

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
                    //dd($request->leave);
                    if(isset($request->leave)){
                        $leave_day=[];
                        foreach(json_decode($leave_info->leave_days) as $key=>$data){
                            if(isset($request->leave_id)){
                            $leave_days['date']=$data->date;
                            $leave_days['type']=$data->type;
                            if(isset($request->leave['cancell'][$key])){
                                $leave_days['check']=($request->leave['cancell'][$key]==1)?0:1;
                            }else{
                                $leave_days['check']=$data->check;
                            }
                            
                            $leave_day[]=$leave_days;

                            }else{
                            $leave_days['date']=$data->date;
                            $leave_days['check']=$request->leave['check'][$key] ?? 0;
                            $leave_days['type']=$data->type;
                            $leave_day[]=$leave_days;
                            }
                           
                            

                        }
                       
                     
                        $ins['leave_days']=json_encode($leave_day);
                    }
                  
                } elseif($type=='edit') {
                     $leave_info = StaffLeave::find($id);
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
 $leave_day=[];
                    if(isset($request->leave) && isset($request->leave['date'][0])){
                        $leave_day=[];
                        foreach($request->leave['radio'] as$key=>$data){
                            $leave_days['date']=$request->leave['date'][$key];
                            $leave_days['type']=$data;
                            $leave_day[]=$leave_days;
                        }
 
  
                        }else{
                   
                    if(isset($request->leave)){
                        $leave_day=[];
                        foreach(json_decode($leave_info->leave_days) as $key=>$data){
                           
                            $leave_days['date']=$data->date;
                            $leave_days['type']=$request->leave['radio'][$key];
                            $leave_day[]=$leave_days;

                        }
                       
                     
                      
                       }
                        }
                       
                       
                        $ins['leave_days']=json_encode($leave_day);

                    
                 
                }else{
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

                    $message=$user->name.' has applied the leave please approve';
              if($leave_category_info->name=="Casual Leave"){
            if(isset($user->reporting_manager_id) && !empty($user->reporting_manager_id)){
                NotificationHelper::createNotification($user->reporting_manager_id,$user->id,'Leave',NULL,$message);
                 }
            }
                $users=User::get();

                foreach($users as $staff){
                NotificationHelper::createNotification($staff->id,$user->id,'Leave',NULL,$message);
                }
                }
               
                /** generate leave form and send */
                $leave_info = StaffLeave::updateOrCreate(['id' => $id], $ins);
              if (isset($id) && !empty($id) && $type=='approved') {
                generateLeaveForm($leave_info->id);
               }

                $error = 0;
                $message = 'Leave Request submit successfully';
            }
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message,$type]);
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
    public function overviewList(Request $request)
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
        $leavehead=LeaveHead::where('academic_id',academicYearId())->where('status', 'active')->get();
       //dd($leavehead);
        $staff_category = StaffCategory::where('status', 'active')->get();
        $designation = Designation::where('status', 'active')->orderBy('name', 'asc')->get();
      if($request->ajax())
        {

             $data = User::select('users.*', 'institutions.name as institute_name')
                ->leftJoin('institutions', 'institutions.id', 'users.institute_id')
                ->with(['appointment.staffCategory','appointment','personal'])
                ->InstituteBased();

            $search = $request->global_search;
            $staff_type = $request->staff_type;
            $gender = $request->gender;
            $designation = $request->designation;
            $datatables =  DataTables::of($data)
            ->filter(function($query) use($search,$staff_type,$gender,$designation,) {
                if(isset($search))
                {
                    return $query->where(function($q) use($search){

                         $q->where('users.id',$search);
                           
                    });
                }
                if(isset($gender))
                {
                    return $query->whereHas('personal', function($q) use($gender){
                         $q->where('gender',$gender);
                           
                    });
                }
                if(isset($staff_type))
                {
                    return $query->whereHas('appointment',function($q) use($staff_type){

                         $q->where('category_id',$staff_type);
                           
                    });
                }
                if(isset($designation))
                {
        return $query->whereHas('personal',function($q) use($designation){

        $q->where('designation_id',$designation);
                           
                    });
                }
            })
  
                ->editColumn('emp_code', function ($row) {
                 
                    $emp_code = $row['appointment']['staffCategory']['name'] ?? '';
                    return $emp_code;

                })->editColumn('lop', function ($row) {
                 
                   return '<span class="badge">0</span>';

                })->editColumn('extened_leave', function ($row) {
                  return '<span class="badge">0</span>';


                })
               
                // ->addColumn('casual_leave', function ($row) {
                  
                //     $total=$row['appointment']['leaveAllocated'][0]['leave_days'] ?? 0;
                        
                //     $casual_leave = '<span class="badge badge-info">'.$total.'</span> of <span class="badge badge-info">7</span>';

                //     return $casual_leave;
                // })
                
            
                 ->editColumn('action', function ($row) {
                    $emp_code ='<a href="' . route('leaves.overview.view', ['id' => $row->id]) . '"  class="btn btn-icon mx-1 w-30px h-30px" > 
                                    <i class="fa fa-eye"></i>
                                </a>';
                    return $emp_code;
                })

          ->rawColumns(['action']);
         foreach($leavehead as $head){
            $datatables->addColumn($head->name, function ($row) use($head) {
         $leave=StaffLeave::where('staff_id',$row['id'])->where('leave_category',$head->name)->where('academic_id',academicYearId())->where('status','approved')->get();
        $as=0;
        foreach($leave as $leave_count){
            $as+=$leave_count->granted_days??0;
     
        }
           return '<span class="badge">'.($head->leave_day->leave_days ?? 0).'</span> of <span class="badge">'.($as ?? 0).'</span>';
        
            
            });
              
           $name[]=$head->name;
         }
          $name[]='action';
          $name[]='lop';
          $name[]='extened_leave';
            $datatables->rawColumns($name);
            return $datatables->make(true);

        }
        $pending=StaffLeave::where('academic_id',academicYearId())->where('status','pending')->count();
        $total=StaffLeave::where('academic_id',academicYearId())->count();
        return view('pages.leave.overview_list', compact('breadcrums', 'user','staff_category','designation','leavehead','total','pending'));
    }
     public function overviewView(Request $request,$id)
    {   
        $staff=User::find($id);
        $leavehead=LeaveHead::where('academic_id',academicYearId())->where('status', 'active')->get();
        foreach($leavehead as $head){
         $leave=StaffLeave::where('staff_id',$id)->where('leave_category',$head->name)->where('academic_id',academicYearId())->where('status','approved')->get();
          $head['count']=0;
        foreach($leave as $leave_count){
           $head['count']+=$leave_count->granted_days;
     
         }

         }

        $total=StaffLeave::where('staff_id',$id)->where('academic_id',academicYearId())->where('status','approved')->paginate(5);
       
        return view('pages.leave.view', compact('staff','leavehead','total'));
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
        $date = $request->date;
        $month_start = date('Y-m-01', strtotime($date));
        $month_end = date('Y-m-t', strtotime($date));
        $month =date('F', strtotime($date));
        /**
         * 1.get leave days
         * 2. get worked days
         */
        $working_days = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'working_day')->count();
        $holidays = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'holiday')->count();
        $week_off = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'week_off')->count();

        $user = User::find($staff_id);
        $leaves = StaffLeave::where('staff_id', $staff_id)->where('from_date', '>=', $month_start)
            ->where('to_date', '<=', $month_end)
            ->where('status', 'approved')
            ->groupBy('leave_category')
    ->select('leave_category',\DB::raw('SUM(granted_days) as leaves'))
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

       // if ($payroll_check) {

            $error = 0;
            $message = 'Successfully deleted';
            $info->delete();
        //} else {
            //$error = 1;
            //$message = 'Payroll already processed. Cannot delete Please contact administrator';
        //}

        return array('error' => $error, 'message' => $message);
    }
    public function StaffLeaveMapping(Request $request)
    {
    //     $users=User::where('status','active')->get();
    //     foreach($users as $user){
    // if(isset($user->appointment) && isset($user->appointment->leaveAllocated) && count($user->appointment->leaveAllocated)>0){
    //     foreach($user->appointment->leaveAllocated as $leaveAllocated){
    //     $new=new StaffLeaveMapping;
    //     $new->staff_id=$user->id;
    //     $new->leave_head_id=$leaveAllocated->leave_head_id;
    //     $new->no_of_leave_actual=$leaveAllocated->leave_days;
    //     if($leaveAllocated->carry_forward=='yes'){
    //     $new->carry_forward_count=$leaveAllocated->leave_days;
    //     }else{
    //     $new->carry_forward_count=0;
    //     }
    //     $new->no_of_leave=$leaveAllocated->leave_days;
    //     $new->save();
    //     }
    // }
    //     }
        $years=getYearsBetween(1984,2024);
        foreach($years as $year){
            $calander=new CalenderYear;
            $calander->year=$year;
            $calander->from_month=1;
            $calander->to_month=12;
            $calander->status='active';
            $calander->save();

        }
        dd(1);
    }
    
}
