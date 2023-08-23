<?php

namespace App\Http\Controllers\Master;

use App\Exports\CommunityExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Community',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Community'
                ),
            )
        );
        if ($request->ajax()) {
            $perPage = $request->length ?? 10;
            $page = 1; // Change this to the desired page number
            $offset = $request->start ?? 0;
            $datatable_search = $request->datatable_search ?? '';

            $baseQuery = Community::select('communities.*')
                ->whereNull('communities.deleted_at')
                ->when( !empty( $datatable_search ), function($query) use($datatable_search){
                    return $query->where('name', 'like', "%{$datatable_search}%");
                })
                ->orderBy('id', 'desc');

            $totalFilteredRecord = clone $baseQuery;
            $totalFilteredRecord = $totalFilteredRecord
                ->selectRaw('ROW_NUMBER() OVER (ORDER BY id DESC) AS row_num')
                ->offset($offset)
                ->limit($perPage)
                ->get();

            $recordsFiltered = $totalDataRecordCount = $baseQuery->count();
            
            $data_val = [];
            foreach ($totalFilteredRecord as $items) {
                $tmp = [];
                $tmp['name'] = $items->name;
                $tmp['status'] = '<a href="javascript:void(0);" class="badge badge-light-' . (($items->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($items->status) . '" onclick="return communityChangeStatus(' . $items->id . ',\'' . ($items->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($items->status) . '</a>';

                $route_name = request()->route()->getName();
                if (access()->buttonAccess($route_name, 'add_edit')) {
                    $edit_btn = '<a href="javascript:void(0);" onclick="getCommunityModal(' . $items->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
                </a>';
                } else {
                    $edit_btn = '';
                }
                if (access()->buttonAccess($route_name, 'delete')) {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteCommunity(' . $items->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';
                } else {
                    $del_btn = '';
                }
                $tmp['action'] = $edit_btn . $del_btn;
                $data_val[] = $tmp;
            }

            $draw_val = $request->input('draw');
            $get_json_data = [
                "draw"            => intval($draw_val),
                "recordsTotal"    => intval($totalDataRecordCount),
                "recordsFiltered" => intval($recordsFiltered),
                "data"            => $data_val,
            ];

            return response()->json($get_json_data);
        }
        return view('pages.masters.community.index', compact('breadcrums'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'community' => 'required|string|unique:communities,name,' . $id . ',id,deleted_at,NULL',
        ]);

        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->community;
            if (isset($request->form_type)) {
                if ($request->status) {
                    $ins['status'] = 'active';
                } else {
                    $ins['status'] = 'inactive';
                }
            } else {
                $ins['status'] = 'active';
            }
            $data = Community::updateOrCreate(['id' => $id], $ins);
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
        $title = 'Add Community';
        $from = 'master';
        if (isset($id) && !empty($id)) {
            $info = Community::find($id);
            $title = 'Update Community';
        }

        $content = view('pages.masters.community.add_edit_form', compact('info', 'title', 'from'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Community::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Community status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Community::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted state!", 'status' => 1]);
    }
    public function export()
    {
        return Excel::download(new CommunityExport, 'community.xlsx');
    }
}
