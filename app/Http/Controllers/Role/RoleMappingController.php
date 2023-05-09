<?php

namespace App\Http\Controllers\Role;

use App\Exports\BankBranchExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Bank;
use App\Models\Master\BankBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role\Role;
use App\Models\Role\RoleMapping;
use Maatwebsite\Excel\Facades\Excel;

class RoleMappingController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Role Mapping',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Role Mapping'
                ),
            )
        );
        if($request->ajax())
        {
            $data = RoleMapping::select('*');
            // ->select('banks.name as bank_name','bank_branches.name','bank_branches.address','bank_branches.ifsc_code','bank_branches.created_at');
            $status = $request->get('role_mappings.status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                      //  $q->where('bank_branches.name','like',"%{$keywords}%")
                       // ->orWhere('banks.name','like',"%{$keywords}%")
                        //->orWhere('bank_branches.address','like',"%{$keywords}%")
                        //->orWhere('bank_branches.ifsc_code','like',"%{$keywords}%")
                       // ->orWhereDate('bank_branches.created_at',$date);
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
                $edit_btn = '<a href="javascript:void(0);" onclick="getRoleMappingModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteRoleMapping(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.role.role_mapping.index',compact('breadcrums'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'staff_id' => 'required',
            'role_id' => 'required',
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $request->bank_id;
            $ins['role_id'] = $request->branch_name;
            $ins['role_created_id'] = $request->branch_name;          
            if($request->status)
            {
                $ins['status'] = 'active';
            }
            else{
                $ins['status'] = 'inactive';
            }           
            $data = RoleMapping::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';          

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }

    public function getBankBranches(Request $request)
    {
        $bank_id = $request->bank_id;
        $branch_data = BankBranch::where('bank_id', $request->bank_id)->where('status', 'active')->get();

        return response()->json(['branch_data' => $branch_data ?? []]);
        
    }
    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Role Mapping';
        $from = 'role_mapping';
        $staff_details = User::where('is_super_admin', '=', null)->get(); 
       if(isset($id) && !empty($id))
        {
            $info = RoleMapping::find($id);
            $title = 'Update Bank Branch';
        }
         $content = view('pages.role.role_mapping.add_edit_form',compact('info','title', 'from','staff_details'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = BankBranch::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Bank Branch status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = BankBranch::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new BankBranchExport,'branch.xlsx');
    }

}
