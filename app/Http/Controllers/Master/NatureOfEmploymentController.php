<?php

namespace App\Http\Controllers\Master;

use App\Exports\NatureOfEmploymentExport;
use App\Http\Controllers\Controller;
use App\Models\Master\NatureOfEmployment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
// use DataTables;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class NatureOfEmploymentController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Nature Of Employment',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Nature Of Employment'
                ),
            )
        );
        if ($request->ajax()) {

            $query = NatureOfEmployment::select('*');
            // Sort the data in descending order based on the 'id' column
            $data = $query->get()->sortByDesc('id')->values();

            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $data = $data->sortByDesc('id')->values();
            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('nature_of_employments.name', 'like', "%{$keywords}%")
                                ->orWhereDate('nature_of_employments.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return natureOfEmployeementChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    $edit_btn = '';
                    $del_btn = '';
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getNatureOfEmployeementModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteNatureOfEmployeement(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            // $datatables->orderBy('id', 'desc');
            return $datatables->make(true);
        }
        return view('pages.masters.nature_of_employeement.index', compact('breadcrums'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'nature_of_employeement' => 'required|string|unique:nature_of_employments,name,' . $id . ',id,deleted_at,NULL',
        ]);

        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->nature_of_employeement;
            if (isset($request->form_type)) {
                if ($request->status) {
                    $ins['status'] = 'active';
                } else {
                    $ins['status'] = 'inactive';
                }
            } else {
                $ins['status'] = 'active';
            }
            $data = NatureOfEmployment::updateOrCreate(['id' => $id], $ins);
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
        $title = 'Add Profession Type';
        $from = 'master';
        if (isset($id) && !empty($id)) {
            $info = NatureOfEmployment::find($id);
            $title = 'Update Profession Type';
        }

        $content = view('pages.masters.nature_of_employeement.add_edit_form', compact('info', 'title', 'from'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = NatureOfEmployment::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Nature Of Employment status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = NatureOfEmployment::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted state!", 'status' => 1]);
    }
    public function export()
    {
        return Excel::download(new NatureOfEmploymentExport, 'nature_of_employment.xlsx');
    }
}
