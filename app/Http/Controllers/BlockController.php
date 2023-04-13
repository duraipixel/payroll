<?php

namespace App\Http\Controllers;

use App\Exports\BlockExport;
use App\Models\Block;
use App\Models\BlockClasses;
use App\Models\Master\Classes;
use App\Models\Master\Institution;
use App\Models\Master\PlaceOfWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Blocks',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Blocks'
                ),
            )
        );
        if($request->ajax())
        {
            $data = Block::select('blocks.*','institutions.name as institute_name','place_of_works.name as place_of_works_name')
            ->leftJoin('institutions','institutions.id','=','blocks.institute_id')
            ->leftJoin('place_of_works','place_of_works.id','=','blocks.place_of_work_id');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($status)
                {
                    return $query->where('blocks.status','=',"$status");
                }
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('blocks.name','like',"%{$keywords}%")
                        ->orWhere('institutions.name','like',"%{$keywords}%")
                        ->orWhere('place_of_works.name','like',"%{$keywords}%")
                        ->orWhereDate('blocks.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return blocksChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $addHref = route('blocks.add_edit',$row->id);
                $edit_btn = '<a href="'.$addHref.'" onclick="getBlocksModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteBlocks(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.blocks.index',compact('breadcrums'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'block_name' => 'required|string|unique:blocks,name,' . $id .',id,deleted_at,NULL',
            'institute_id' => 'required',
            'class_id' => 'required',
        ]);
        
        if ($validator->passes()) {
            $ins['academic_id']         = academicYearId();
            $ins['name']                = $request->block_name;
            $ins['institute_id']        = $request->institute_id;
            $ins['place_of_work_id']    = $request->place_of_work_id;
            $ins['description']         = $request->description;
            $ins['added_by']            = Auth::user()->id;
            if($request->status)
            {
                $ins['status'] = 'active';
            }
            else{
                $ins['status'] = 'inactive';
            }
            $data = Block::updateOrCreate(['id' => $id], $ins);
            
            if(isset($request->class_id) && !empty($request->class_id))
            {
                $dataCls = BlockClasses::where('block_id',$id)->get();
                foreach($dataCls as $key=>$val)
                {
                    $val['status'] = 'inactive';
                    $val->save();
                }
                foreach($request->class_id as $key=>$val)
                {
                    $insClass['academic_id']         = academicYearId();
                    $insClass['block_id']            = $data->id;
                    $insClass['class_id']            = $val;
                    $insClass['added_by']            = Auth::user()->id;
                    if($request->status)
                    {
                        $insClass['status'] = 'active';
                    }
                    else{
                        $insClass['status'] = 'inactive';
                    }
                    $classData = BlockClasses::updateOrCreate(['block_id' => $data->id,'class_id' => $val], $insClass);
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
    public function add_edit(Request $request)
    {
        $breadcrums = array(
            'title' => 'Block',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Block Add'
                ),
            )
        );
        $id = $request->id;
        $info = [];
        $content = '';
        $title = 'Add Block';
        $institution = Institution::where('status','active')->get();
        $placeOfWork = PlaceOfWork::where('status','active')->get();
        $class = Classes::where('status','active')->orderBy('id','desc')->get();
        if(isset($id) && !empty($id))
        {
            $info = Block::find($id);
            if(isset($info->class) && !empty($info->class))
            {
                $temp = [];
                foreach($info->class as $key=>$val)
                {
                    $temp[] = $val->class_id;
                }
            }
            $info['class'] = $temp;
            $breadcrums = array(
                'title' => 'Block',
                'breadcrums' => array(
                    array(
                        'link' => '', 'title' => 'Block Update'
                    ),
                )
            );
        }

        //  $content = view('pages.blocks.add_edit_form',compact('info','title','institution','placeOfWork','class'));
        //  return view('layouts.modal.add_edit_form', compact('content', 'title'));
        return view('pages.blocks.add_edit_form',compact('info','content', 'title','breadcrums','institution','placeOfWork','class'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Block::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Block status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Block::find($id);
        $infoClass      = BlockClasses::where('block_id',$id)->delete();
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new BlockExport,'blocks.xlsx');
    }
}
