<?php

namespace App\Http\Controllers\Announcement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role\Role;
use App\Models\Role\RoleMapping;
use App\Exports\RoleMappingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\Institution;
use DB;
use Yajra\DataTables\Contracts\DataTable;
use App\Models\Announcement\Announcement;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Announcement',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Announcement'
                ),
            )
        );
        if($request->ajax())
        {
            $data=Announcement::leftJoin('institutions','institutions.id','=','announcements.institute_id')
            ; 

            $data=Announcement::leftJoin('institutions as ins','ins.id','=','announcements.institute_id')
            ->leftJoin('users as created','created.id','=','announcements.announcement_created_id')         
            ->select('created.name as created_by_name','ins.name as ins_name','announcements.*'); 

            $status = $request->get('announcements.status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  DataTables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('institutions.name','like',"%{$keywords}%")
                        ->orWhere('announcement_type','like',"%{$keywords}%")
                        ->orWhere('from_date','like',"%{$keywords}%")
                        ->orWhere('to_date','like',"%{$keywords}%")
                        ->orWhere('message','like',"%{$keywords}%")
                        ->orWhereDate('announcements.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return roleMappingChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $route_name = request()->route()->getName(); 
                if( access()->buttonAccess($route_name,'add_edit') )
                {
                    $edit_btn = '<a href="javascript:void(0);" onclick="getAnnouncementModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                }
                else
                {
                    $edit_btn = '';
                }
                if( access()->buttonAccess($route_name,'delete') )
                {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteAnnouncement(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
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
        return view('pages.announcement.index',compact('breadcrums'));
    }
    public function save(Request $request)
    {
        
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'institute_id' => 'required',
            'type' => 'required',
            'from_date' => 'required_if:type,==,Short Period',
            'to_date' => 'required_if:type,==,Short Period',
            'an_message' => 'required',
        ]);
        
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['institute_id'] = $request->institute_id;
            $ins['announcement_type'] = $request->type;
            $ins['from_date'] = $request->from_date;
            $ins['to_date'] = $request->to_date;
            $ins['message'] = $request->an_message;
            $ins['announcement_created_id'] = Auth::user()->id;          
            if($request->status)
            {
                $ins['status'] = 'active';
            }
            else{
                $ins['status'] = 'inactive';
            }           
            $data = Announcement::updateOrCreate(['id' => $id], $ins);
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
        $title = 'Add Announcement';
        $from = 'announcement';
        $institute=Institution::where('status','active')->get();
      
       if(isset($id) && !empty($id))
        {
            $info = Announcement::find($id);
            $title = 'Update Announcement';
        }
         $content = view('pages.announcement.add_edit_form',compact('info','title', 'from','institute'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Announcement::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Bank Branch status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Announcement::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new RoleMappingExport,'Role_Mapping.xlsx');
    }

}
