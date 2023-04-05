<?php

namespace App\Http\Controllers\Master;

use App\Exports\OtherSchoolExport;
use App\Http\Controllers\Controller;
use App\Models\Master\OtherSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class OtherSchoolController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Other School',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Other School'
                ),
            )
        );
        if($request->ajax())
        {
            $data = OtherSchool::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('other_schools.name','like',"%{$keywords}%")
                        ->orWhereDate('other_schools.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return otherSchoolChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="javascript:void(0);" onclick="getOtherSchoolModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteOtherSchool(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.masters.other_schools.index',compact('breadcrums'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|unique:other_schools,name,' . $id,
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->school_name;
            if(isset($request->form_type))
            {
                if($request->status)
                {
                    $ins['status'] = 'active';
                }
                else{
                    $ins['status'] = 'inactive';
                }
            }
            else{
                $ins['status'] = 'active';
            }
            $data = OtherSchool::updateOrCreate(['id' => $id], $ins);
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
        $title = 'Add School';
        $from = 'master';
        if(isset($id) && !empty($id))
        {
            $info = OtherSchool::find($id);
            $title = 'Update School';
        }

         $content = view('pages.masters.other_schools.add_edit_form',compact('info','title', 'from'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = OtherSchool::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the School status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = OtherSchool::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new OtherSchoolExport,'other_school.xlsx');
    }
}
