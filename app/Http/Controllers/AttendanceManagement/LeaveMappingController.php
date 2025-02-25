<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Exports\LeaveMappingExport;
use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\LeaveMapping;
use Illuminate\Http\Request;
use App\Models\Master\NatureOfEmployment; 
use App\Models\AttendanceManagement\LeaveHead;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use App\Models\Master\TeachingType;
use Maatwebsite\Excel\Facades\Excel;

class LeaveMappingController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Leave Mapping',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Leave Mapping'
                ),
            )
        );
         $teaching_types=TeachingType::where('status','active')->get();
        if($request->ajax())
        { 
            $academic_id=48;
            $data = LeaveMapping::select('leave_mappings.*','nature_of_employments.name as nature_emp_name','leave_heads.name as head_name')
            ->leftJoin('nature_of_employments','nature_of_employments.id','=','leave_mappings.nature_of_employment_id')
            ->leftJoin('leave_heads','leave_heads.id','=','leave_mappings.leave_head_id')->where('leave_mappings.academic_id',$academic_id);
            $status = $request->get('status');
            $teaching_type = $request->get('teaching_type');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords,$teaching_type) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){
                        $q->where('nature_of_employments.name','like',"%{$keywords}%")
                        ->orWhere('leave_heads.name','like',"%{$keywords}%")
                        ->orWhere('leave_days','like',"%{$keywords}%")
                        ->orWhere('carry_forward','like',"%{$keywords}%")
                        ->orWhereDate('leave_mappings.created_at',$date);
                    });
                }
                if($teaching_type && $teaching_type!=''){
                    return $query->where(function($q) use($teaching_type){
                         $q->where('teaching_type',$teaching_type);
                    });
                }

            })
            ->addIndexColumn()
             ->editColumn('teaching_type', function ($row) {
                return $row->teaching ? $row->teaching->name : '';
             })
            ->editColumn('status', function ($row) {
                 $route_name = request()->route()->getName(); 
                if( access()->buttonAccess($route_name,'add_edit') )
                {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return leaveMappingStatusChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            }else{
           $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="#">' . ucfirst($row->status) . '</a>';
                return $status;

            }
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $route_name = request()->route()->getName(); 
                if( access()->buttonAccess($route_name,'add_edit') )
                {
                    $edit_btn = '<a href="javascript:void(0);" onclick="getLeaveMappingModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                }
                else
                {
                    $edit_btn = '';
                }
                if( access()->buttonAccess($route_name,'delete') )
                {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteLeaveMappingStatus(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                }
                else
                {
                    $del_btn = '';
                }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.attendance_management.leave_mapping.index',compact('breadcrums','teaching_types'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'nature_of_employment_id' => 'required',
            'leave_head_id' => 'required',
            'leave_days' => 'required',
            'teaching_type' => 'required',
            'carry_forward' => 'required',
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['nature_of_employment_id'] = $request->nature_of_employment_id;
            $ins['leave_head_id'] = $request->leave_head_id;
            $ins['teaching_type'] = $request->teaching_type;
            $ins['leave_days'] = $request->leave_days;
            $ins['carry_forward'] = $request->carry_forward;
                if($request->status)
                {
                    $ins['status'] = 'active';
                }
                else{
                    $ins['status'] = 'inactive';
                }
            
            $data = LeaveMapping::updateOrCreate(['id' => $id], $ins);
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
        $title = 'Add Leave Mapping';
        $teaching_types=TeachingType::where('status','active')->get();
        $employment_nature = NatureOfEmployment::where('status','active')->get();
        $leave_heads = LeaveHead::where('status','active')->get();
        if(isset($id) && !empty($id))
        {
            $info = LeaveMapping::find($id);
            $title = 'Update Leave Mapping';
        }

         $content = view('pages.attendance_management.leave_mapping.add_edit_form',compact('info','title','employment_nature','leave_heads','teaching_types'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title','employment_nature','leave_heads','teaching_types'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = LeaveMapping::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Leave Status status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = LeaveMapping::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new LeaveMappingExport,'leave_mapping.xlsx');
    }
}
