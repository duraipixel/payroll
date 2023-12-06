<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Exports\SalaryFieldExport;
use App\Http\Controllers\Controller;
use App\Models\Master\NatureOfEmployment;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\SalaryFieldCalculationItem;
use App\Models\PayrollManagement\SalaryHead;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
            $datatable_nature_id = $request->datatable_nature_id ?? '';
            $datatable_salary_head_id = $request->datatable_salary_head_id ?? '';
            $keywords = $datatable_search;
            $datatables = Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords, $datatable_nature_id, $datatable_salary_head_id) {
                    if ($status) {
                        return $query->where('salary_fields.status', '=', "$status");
                    }
                    if( $datatable_nature_id || $datatable_salary_head_id ) {
                        return $query->when( !empty( $datatable_nature_id ), function($q) use($datatable_nature_id){

                            return $q->where('salary_fields.nature_id', $datatable_nature_id);
                        })->when( !empty( $datatable_salary_head_id ), function($q) use($datatable_salary_head_id){

                            return $q->where('salary_fields.salary_head_id', $datatable_salary_head_id);
                        });
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
                       $route_name = request()->route()->getName(); 
                if( access()->buttonAccess($route_name,'add_edit') )
                {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return salaryFieldChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                }else{
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" >' . ucfirst($row->status) . '</a>';
                }
                    if( $row->is_static == 'yes') {
                        $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" >' . ucfirst($row->status) . '</a>';
                    }
                    return $status;
                })
                ->editColumn('entry_type', function($row){
                    return ucfirst(str_replace('_', " ", $row->entry_type));
                })
                ->addColumn('nature', function($row){
                    // dd($row->employeeNature);
                    return $row->employeeNature->name ?? '';
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
                ->rawColumns(['action', 'status', 'nature']);
            return $datatables->make(true);
        }
        $nature = NatureOfEmployment::where('status', 'active')->get();
        $heads = SalaryHead::where('status', 'active')->get();

        return view('pages.payroll_management.salary_field.index', compact('breadcrums', 'nature', 'heads'));
    }

    public function add_edit(Request $request)
    {

        $id = $request->id;
        $info = [];
        $title = 'Add Salary Fields';
        $heads = SalaryHead::where('status', 'active')->get();
        $nature = NatureOfEmployment::where('status', 'active')->get();
        $from = 'master';
        if (isset($id) && !empty($id)) {
            $info = SalaryField::find($id);
            $title = 'Update Salary Fields';
            
            $nature_id = $info->nature_id;
            $fields = SalaryField::select('id', 'name')
                    ->where('salary_head_id', 1)
                    ->where('nature_id', $nature_id)
                    ->where('status', 'active')
                    ->orderBy('order_in_salary_slip')->get();
            
            
        }

        $params = array(
            'info' => $info,
            'title' => $title,
            'heads' => $heads,
            'from' => $from,
            'nature' => $nature,
            'fields' => $fields ?? []
        );

        $content = view('pages.payroll_management.salary_field.add_edit_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request)
    {
       
        $id = $request->id ?? '';
        $nature_id = $request->nature_id ?? '';
        $salary_head_id = $request->salary_head_id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'name' => 'required|unique:salary_fields,name,' . $id . ',id,nature_id,'.$nature_id.',id,deleted_at,null',
            'name' => ['required','string',
                        Rule::unique('salary_fields')->where(function ($query) use($id, $nature_id, $salary_head_id) {
                            return $query->where('nature_id', $nature_id)->where('deleted_at', NULL)
                            ->where('salary_head_id', $salary_head_id)
                            ->when($id != '', function($q) use($id){
                                return $q->where('id', '!=', $id);
                            });
                        }),
                        ],
            'nature_id' => 'required',
            'entry_type' => 'required',
            'no_of_numerals' => 'required_if:entry_type,==,manual',
            'percentage' => 'required_if:entry_type,==,calculation',
            'multi_field' => 'required_if:entry_type,==,calculation'
        ]);

        if ($validator->passes()) {            

            $multi_field = $request->multi_field ?? [];
            $ins['academic_id'] = academicYearId();
            $ins['name']        = $request->name;
            $ins['nature_id']   = $nature_id;
            $ins['short_name']  = $request->short_name;
            $ins['description'] = $request->description;
            $ins['added_by']    = Auth::user()->id;
            $ins['salary_head_id'] = $request->salary_head_id;
            $ins['status'] = $request->status;
            $ins['order_in_salary_slip'] = $request->order_in_salary_slip;
            $ins['entry_type'] = $request->entry_type;
            $ins['no_of_numerals'] = $request->entry_type == 'manual' ? $request->no_of_numerals : null;

            $data = SalaryField::updateOrCreate(['id' => $id], $ins);

            if( count($multi_field) > 0 ) {

                $salaryCombineField = SalaryField::select('short_name')->whereIn('id', $multi_field)->get();
                $field_name = [];
                if( $salaryCombineField ) {
                    foreach ($salaryCombineField as $fo ) {
                        $field_name[] = $fo->short_name;
                    }
                }
                /**
                 * Insert in SalaryfieldCalculationItems
                 */
                $field_ins = [];
                $field_ins['parent_field_id'] = $data->id;
                $field_ins['multi_field_id'] = implode(',', $multi_field);
                $field_ins['field_name'] = implode(',', $field_name);
                $field_ins['percentage'] = $request->percentage ?? null;
                
                SalaryFieldCalculationItem::updateOrCreate(['parent_field_id' => $data->id], $field_ins);
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
        return Excel::download(new SalaryFieldExport, 'SalaryField_'.date('ymdhis').'.xlsx');
    }

    public function getHeadBasedFields(Request $request)
    {
        
        $head_id = $request->head_id;
        $nature_id = $request->nature_id;

        $fields = SalaryField::select('id', 'name')
                    ->where('salary_head_id', 1)
                    ->where('nature_id', $nature_id)
                    ->where('status', 'active')
                    ->orderBy('order_in_salary_slip')->get()->toArray();
        
        return $fields;
    }

    

}
