<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Exports\SalaryFieldExport;
use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\SalaryField;
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
        if($request->ajax())
        {
            $data = SalaryField::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($status)
                {
                    return $query->where('salary_heads.status','=',"$status");
                }
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('salary_fields.name','like',"%{$keywords}%")
                        ->orWhereDate('salary_fields.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return salaryFieldChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
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
                    $edit_btn = '<a href="javascript:void(0);" onclick="getSalaryFieldModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                }
                else
                {
                    $edit_btn = '';
                }
                if( access()->buttonAccess($route_name,'delete') )
                {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteSalaryField(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
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
        return view('pages.payroll_management.salary_field.index',compact('breadcrums'));
    }
    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Salary Field';
        $from = 'master';
        if(isset($id) && !empty($id))
        {
            $info = SalaryField::find($id);
            $title = 'Update Salary Field';
        }

         $content = view('pages.payroll_management.salary_field.add_edit_form',compact('info','title', 'from'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'field_name' => 'required|string|unique:salary_fields,name,' . $id .',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {
            $ins['academic_id'] = academicYearId();
            $ins['name']        = $request->field_name;
            $ins['description'] = $request->description;
            $ins['added_by']            = Auth::user()->id;
          
                if($request->status)
                {
                    $ins['status'] = 'active';
                }
                else{
                    $ins['status'] = 'inactive';
                }
           
            $data = SalaryField::updateOrCreate(['id' => $id], $ins);
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
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new SalaryFieldExport,'SalaryField.xlsx');
    }
}
