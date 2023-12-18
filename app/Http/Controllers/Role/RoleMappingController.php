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
use App\Exports\RoleMappingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\Contracts\DataTable;

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
        if ($request->ajax()) {

            $status = $request->get('role_mappings.status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $data = RoleMapping::leftJoin('users as staff', 'staff.id', '=', 'role_mappings.staff_id')
                ->leftJoin('users as created', 'created.id', '=', 'role_mappings.role_created_id')
                ->leftJoin('roles', 'roles.id', '=', 'role_mappings.role_id')
                ->where('staff.status', 'active')
                ->select('staff.name as staff_name', 'staff.society_emp_code', 'created.name as created_by_name', 'roles.name as role_name', 'role_mappings.*')
                ->when(!empty( $keywords ), function($query) use($keywords) {
                    $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('staff.name', 'like', "%{$keywords}%")
                                ->orWhere('created.name', 'like', "%{$keywords}%")
                                ->orWhere('roles.name', 'like', "%{$keywords}%")
                                ->orWhere('staff.society_emp_code', 'like', "%{$keywords}%")
                                ->orWhereDate('role_mappings.created_at', $date);

                        });
                });
            

            $datatables =  DataTables::of($data)
                
                ->addIndexColumn()
                ->editColumn('staff_name', function ($row) {
                    return $row->staff_name . ' - ' . $row->society_emp_code;
                })
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
                    $edit_btn = $del_btn = '';
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getRoleMappingModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteRoleMapping(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    }

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.role.role_mapping.index', compact('breadcrums'));
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
            $ins['staff_id'] = $request->staff_id;
            $ins['role_id'] = $request->role_id;
            $ins['role_created_id'] = Auth::user()->id;
            if ($request->status) {
                $ins['status'] = 'active';
            } else {
                $ins['status'] = 'inactive';
            }
            $data = RoleMapping::updateOrCreate(['id' => $id], $ins);
            if($request->role_id==2){
                $user=User::find($request->staff_id);
                $user->is_super_admin=1;
                $user->update();
            }
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
        $title = 'Add Role Mapping';
        $from = 'role_mapping';
        $staff_details = User::where('users.status', 'active')
                            ->where('users.transfer_status', 'active')
                            ->orderBy('name', 'asc')->get();
        $role = Role::where('status', 'active')->get();
        if (isset($id) && !empty($id)) {
            $info = RoleMapping::find($id);
            $title = 'Update Bank Branch';
        }
        $content = view('pages.role.role_mapping.add_edit_form', compact('info', 'title', 'role', 'from', 'staff_details'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = RoleMapping::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Bank Branch status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = RoleMapping::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted state!", 'status' => 1]);
    }
    public function export()
    {
        return Excel::download(new RoleMappingExport, 'Role_Mapping.xlsx');
    }
}
