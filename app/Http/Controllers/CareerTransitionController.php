<?php

namespace App\Http\Controllers;

use App\Exports\CareerExport;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CareerTransitionController extends Controller
{
    public function index(Request $request)
    {

        $page_type = $request->type;
        $title = ucwords(str_replace('_', ' ', $page_type));
        $breadcrums = array(
            'title' => ucwords(str_replace('_', ' ', $page_type)),
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => ucwords(str_replace('_', ' ', $page_type))
                ),
            )
        );

        if ($request->ajax()) {
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $data = StaffRetiredResignedDetail::with(['staff'])
                ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                    $date = date('Y-m-d', strtotime($datatable_search));
                    return $query->where(function ($q) use ($datatable_search, $date) {

                        $q->whereHas('staff', function($jq) use($datatable_search){
                                $jq->where('name', 'like', "%{$datatable_search}%")
                                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                            })
                            ->orWhere('reason', 'like', "%{$datatable_search}%")
                            ->orWhereDate('last_working_date', $date);
                    });
                })->where('types', $page_type);

            $datatables =  Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return carreerChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
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
                        $edit_btn = '<a href="javascript:void(0);" onclick="getAddModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteCareer(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }

        return view('pages.career.index', compact('breadcrums', 'title', 'page_type'));
    }

    public function addEdit(Request $request)
    {

        $id = $request->id;
        $page_type = $request->page_type;
        $info = [];
        $title = 'Add ' . ucfirst($page_type) . ' Staff';
        $users = User::where('status', 'active')
            ->where('verification_status', 'approved')
            ->InstituteBased()
            ->whereNull('is_super_admin')->get();

        if (isset($id) && !empty($id)) {
            $info = StaffRetiredResignedDetail::find($id);
            $title = 'Update ' . ucfirst($page_type) . ' Staff';
        }
        $content = view('pages.career.add_edit_form', compact('info', 'title', 'users', 'page_type'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request)
    {

        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'staff_id' => 'required|string|unique:staff_retired_resigned_details,staff_id,' . $id . ',id,deleted_at,NULL',
            'last_working_date' => 'required'
        ]);

        if ($validator->passes()) {
            
            $last_working_date = date('Y-m-d', strtotime($request->last_working_date));
            if( isset( $request->is_completed ) ) {
                if( $last_working_date > date('Y-m-d') ) {
                    return response()->json(['error' => 1, 'message' => ['Can not Completed, Last working date does not satisfied'] ]);
                }
            }
            $staff_id = $request->staff_id;
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['last_working_date'] = $last_working_date;
            $ins['types'] = $request->page_type;
            $ins['reason'] = $request->reason;
            $ins['status'] = $request->status;
            $ins['is_completed'] = $request->is_completed ?? 'no';

            if ($request->hasFile('document')) {
                $staff_info = User::find($staff_id);
                $files = $request->file('document');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'resigned_retired/' . $staff_info->institute_emp_code;
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['document'] = $filename;
            }

            $data = StaffRetiredResignedDetail::updateOrCreate(['id' => $id], $ins);

            $user_info = User::find( $staff_id);
            if( isset( $request->is_completed ) ) {
                $user_info->transfer_status = $request->page_type;
                $user_info->save();
            } else {
                if( $user_info->transfer_status != 'active' ) {
                    $user_info->transfer_status = 'active';
                    $user_info->save();
                }
            }

            $error = 0;
            $message = 'Added successfully';
        } else {

            $error = 1;
            $message = $validator->errors()->all();
        }

        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = StaffRetiredResignedDetail::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "Status Changed successfully!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = StaffRetiredResignedDetail::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted!", 'status' => 1]);
    }
    
    public function export(Request $request)
    {
        return Excel::download(new CareerExport( $request->type), date('ymdhis').'_list.xlsx');
    }
}
