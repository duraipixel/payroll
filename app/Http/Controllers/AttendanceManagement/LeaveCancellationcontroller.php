<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\LeaveMappingExport;
use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\Master\NatureOfEmployment; 
use App\Models\AttendanceManagement\LeaveHead;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use App\Models\Master\TeachingType;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Leave\StaffLeave;
class LeaveCancellationcontroller extends Controller
{
    
    public function leaveCountDays(Request $request){
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
         return $value;
    }
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Leave Cancellation Management',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Leave List'
                ),
            )
        );
        if ($request->ajax()) {
            $institute_id=session()->get('staff_institute_id');
            $data = StaffLeave::select('staff_leaves.*', 'users.name as staff_name')->with(['staff_info'])
                ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
                ->where('staff_leaves.status','approved')->when($institute_id, function ($q) use($institute_id) {
            $q->Where('users.institute_id', $institute_id);
                 });
            $status = $request->get('status');
            $keywords = $request->datatable_search ?? '';

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($keywords) {
                        return $query->where(function ($q) use ($keywords) {
                            $q->where('staff_leaves.application_no', 'like', "%{$keywords}%")
                                ->orWhere('users.name', 'like', "%{$keywords}%");
                            
                        });
                    }
                })
                ->addIndexColumn()
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
                        $edit = '<a href="javascript:void(0);" onclick="editLeave(' . $row->id.')" class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" >
                        <i class="fa fa-edit"></i>
                        </a>';
                    return $edit;
                })
                ->rawColumns(['action', 'created_at', 'name']);
            return $datatables->make(true);
        }
        return view('pages.leave.cancellation.index', compact('breadcrums'));
    }
    public function add_edit(Request $request)
    {   
        $title = 'Add Leave Request';
        $id = $request->id;
        $info = '';
        $taken_leave  = [];
        $leave_count=0;
        $type='';
        if ($id) {
            $title = 'Edit Leave Request';
            $info = StaffLeave::find($id);
            $type = $request->type;
            $taken_leave = StaffLeave::where('staff_id', $info->staff_id)->where('from_date', '<', $info->from_date)->get();
            foreach($taken_leave as $leave){
                $leave_count+=$leave->granted_days;

            }
            
        }
        $leave_category = LeaveHead::where('status', 'active')->get();

        return view('pages.leave.cancellation.add_edit_form', compact('title', 'leave_category', 'info', 'taken_leave','leave_count','type'));
    }
    public function save(Request $request)
    { 
        $id = $request->id ?? '';
        $validator = Validator::make($request->all(), [
            'leave' => 'required|array'
        ],[
            'leave.required'=>'Cancellation toggle is required'
        ]);
    
        $check = StaffLeave::find($id);
        if($validator->passes()){
        if(isset($request->leave)){
        $leave_day=[];
        foreach(json_decode($check->leave_days) as $key=>$data){ 
        $leave_days['date']=$data->date;
        $leave_days['check']=$data->check;
        $leave_days['cancell']=$request->leave['cancell'][$key] ?? 0;
        $leave_days['type']=$data->type;
        $leave_day[]=$leave_days;
       
        }
         $check->leave_days=json_encode($leave_day);
         $check->status='pending';
        }
        $check->update();
        $error = 0;
        $message = 'Leave Request submit successfully';

        } else {
                $error = 1;
               $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }
   
}
