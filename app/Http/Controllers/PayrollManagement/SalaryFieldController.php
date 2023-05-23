<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Exports\SalaryFieldExport;
use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\SalaryFieldCalculationItem;
use App\Models\PayrollManagement\SalaryHead;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SalaryFieldController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Salary Field',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Salary Field'
                ),
            )
        );
        if ($request->ajax()) {
            $data = SalaryField::select('salary_fields.*', 'salary_heads.name as salary_head')->join('salary_heads', 'salary_heads.id', '=', 'salary_fields.salary_head_id');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables = Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($status) {
                        return $query->where('salary_fields.status', '=', "$status");
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('salary_fields.name', 'like', "%{$keywords}%")
                                ->where('salary_heads.name', 'like', "%{$keywords}%")
                                ->orWhereDate('salary_fields.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return salaryFieldChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    if( $row->is_static == 'yes') {
                        $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" >' . ucfirst($row->status) . '</a>';
                    }
                    return $status;
                })
                ->editColumn('entry_type', function($row){
                    return ucfirst(str_replace('_', " ", $row->entry_type));
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    $edit_btn = $del_btn = '';
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getSalaryFieldModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    }

                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteSalaryField(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    }

                    if( $row->is_static == 'yes') {
                        $edit_btn = $del_btn = '';
                        $edit_btn = 'Non Editable';
                    }

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.payroll_management.salary_field.index', compact('breadcrums'));
    }

    public function add_edit(Request $request)
    {

        $id = $request->id;
        $info = [];
        $title = 'Add Salary Fields';
        $heads = SalaryHead::where('status', 'active')->get();
        $from = 'master';
        if (isset($id) && !empty($id)) {
            $info = SalaryField::find($id);
            $title = 'Update Salary Fields';
        }

        $content = view('pages.payroll_management.salary_field.add_edit_form', compact('info', 'title','heads', 'from'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request)
    {
       
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'name' => 'required|unique:salary_fields,name,' . $id . ',id,deleted_at,NULL',
            'entry_type' => 'required',
            'no_of_numerals' => 'required_if:entry_type,==,manual',
            'percentage' => 'required_if:entry_type,==,calculation|array',
            'percentage.*' => 'required_if:entry_type,==,calculation'
        ]);

        if ($validator->passes()) {
            
            $ins['academic_id'] = academicYearId();
            $ins['name']        = $request->name;
            $ins['short_name']  = $request->short_name;
            $ins['description'] = $request->description;
            $ins['added_by']    = Auth::user()->id;
            $ins['salary_head_id'] = $request->salary_head_id;
            $ins['status'] = $request->status;
            $ins['order_in_salary_slip'] = $request->order_in_salary_slip;
            $ins['entry_type'] = $request->entry_type;
            $ins['no_of_numerals'] = $request->entry_type == 'manual' ? $request->no_of_numerals : null;

            $data = SalaryField::updateOrCreate(['id' => $id], $ins);

            if( $request->field_name && !empty( $request->field_name ) ) {
                /**
                 * Insert in SalaryfieldCalculationItems
                 */
                SalaryFieldCalculationItem::where('parent_field_id', $data->id)->forceDelete();
                for ($i=0; $i < count($request->field_name); $i++) { 
                    $salary_field_info = SalaryField::find($_POST['field_name'][$i]);
                    if( $salary_field_info ) {

                        $field_ins = [];
                        $field_ins['parent_field_id'] = $data->id;
                        $field_ins['field_id'] = $salary_field_info->id;
                        $field_ins['field_name'] = $salary_field_info->name;
                        $field_ins['percentage'] = $_POST['percentage'][$i];
                        
                        SalaryFieldCalculationItem::create($field_ins);
                    }
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
        $info           = SalaryField::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Salary field status!", 'status' => 1]);

    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = SalaryField::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted state!", 'status' => 1]);
    }

    public function export()
    {
        return Excel::download(new SalaryFieldExport, 'SalaryField.xlsx');
    }

    public function getHeadBasedFields(Request $request)
    {
        
        $head_id = $request->head_id;
        $fields = SalaryField::select('id', 'name')->where('salary_head_id', $head_id)->where('status', 'active')
                    ->orderBy('order_in_salary_slip')->get()->toArray();

        return $fields;
    }

    

}
