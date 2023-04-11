<?php

namespace App\Http\Controllers;

use App\Exports\BlockExport;
use App\Models\Block;
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
                $edit_btn = '<a href="javascript:void(0);" onclick="getBlocksModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
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
        $title = 'Add Block';
        $institution = Institution::where('status','active')->get();
        $placeOfWork = PlaceOfWork::where('status','active')->get();
        if(isset($id) && !empty($id))
        {
            $info = Block::find($id);
            $title = 'Update Block';
        }

         $content = view('pages.blocks.add_edit_form',compact('info','title','institution','placeOfWork'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
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
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new BlockExport,'blocks.xlsx');
    }
}
