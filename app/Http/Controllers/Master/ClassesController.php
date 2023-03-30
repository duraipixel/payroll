<?php

namespace App\Http\Controllers\Master;

use App\Exports\ClassExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ClassesController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Classes',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Classes'
                ),
            )
        );
        if($request->ajax())
        {
            $data = Classes::orderBy('id','desc');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($status)
                {
                    return $query->where('classes.status','=',"$status");
                }
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('classes.name','like',"%{$keywords}%")
                        ->orWhereDate('classes.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return classChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="javascript:void(0);" onclick="getClassModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteClass(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status','society']);
            return $datatables->make(true);
        }
        return view('pages.masters.classes.index',compact('breadcrums'));
    }
    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Class';
        $from = 'master';
        if(isset($id) && !empty($id))
        {
            $info = Classes::find($id);
            $title = 'Update Class';
        }

         $content = view('pages.masters.classes.add_edit_form',compact('info','title','from'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'class_name' => 'required|string|unique:classes,name,' . $id,
        ]);
        
        if ($validator->passes()) {
            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->class_name;
            $ins['status'] = 'active';
            $data = Classes::updateOrCreate(['id' => $id], $ins);
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
        $info           = Classes::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Class status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Classes::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new ClassExport,'class.xlsx');
    }

}
