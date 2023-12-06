<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Exports\OtherIncomeExport;
use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\OtherIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class OtherIncomeController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Subject',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Subject'
                ),
            )
        );
        if($request->ajax())
        {
            $data = OtherIncome::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('other_incomes.name','like',"%{$keywords}%")
                        ->orWhereDate('other_incomes.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                if(access()->buttonAccess('other-income', 'add_edit')){
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return otherIncomeChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
            }else{
 $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="#">' . ucfirst($row->status) . '</a>';
                
            }
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
                    $edit_btn = '<a href="javascript:void(0);" onclick="getOtherIncomeModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                }
                else
                {
                    $edit_btn = '';
                }
                if( access()->buttonAccess($route_name,'delete') )
                {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteOtherIncome(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
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
        return view('pages.payroll_management.other_income.index',compact('breadcrums'));
    }
    
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        
        $validator      = Validator::make($request->all(), [
            'name' => 'required|string|unique:other_incomes,name,' . $id .',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->name;
            $ins['slug'] = Str::slug($request->name);
            $ins['status'] = $request->status;
            $ins['maximum_limit'] = $request->maximum_limit ?? null;
            $ins['added_by'] = auth()->id();
            $ins['updated_by'] = auth()->id();
            
            OtherIncome::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }
    
    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Other Incomes';
        
        if(isset($id) && !empty($id))
        {
            $info = OtherIncome::find($id);
            $title = 'Update Other Incomes';
        }

         $content = view('pages.payroll_management.other_income.add_edit',compact('info','title'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function changeStatus(Request $request)
    {

        $id             = $request->id;
        $status         = $request->status;
        $info           = OtherIncome::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Other Income status!", 'status' => 1]);

    }

    public function delete(Request $request)
    {
        
        $id         = $request->id;
        $info       = OtherIncome::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted other income!",'status'=>1]);
    }

    public function export()
    {
        return Excel::download(new OtherIncomeExport,'other_income.xlsx');
    }
}
