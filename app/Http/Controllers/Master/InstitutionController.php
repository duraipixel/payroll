<?php

namespace App\Http\Controllers\Master;

use App\Exports\InstitutionExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Institution;
use App\Models\Master\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $society = Society::where('status', 'active')->get();
        $breadcrums = array(
            'title' => 'Institution',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Institution'
                ),
            )
        );
        if($request->ajax())
        {
            $data = Institution::with('society');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables =  Datatables::of($data)
            ->filter(function ($query) use ($keywords, $status) {
                if ($status) {
                    return $query->where('institutions.status', '=', "$status");
                }
                if ($keywords) {
                    $date = date('Y-m-d', strtotime($keywords));
                    return $query->where(function ($q) use ($keywords, $date) {

                        $q->where('institutions.name', 'like', "%{$keywords}%")
                            ->orWhere('institutions.code', 'like', "%{$keywords}%")
                            ->orWhereDate("institutions.created_at", $date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('name', function($row) {
                $img = '';
                if (isset($row->logo) && !empty($row->logo)) {

                    $profile_image = Storage::url($row->logo);
                    $img = '
                        <img src="'.asset('public' . $profile_image) .'" alt="" width="100"
                            style="border-radius:10%">
                    ';
                }
                return $img. $row->name;
            })
            ->addColumn('last_updated', function ($row) {
                $society_emp_code = $row->lastUpdatedBy->society_emp_code ?? ''; 
                $updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['updated_at'])->format('d/M/Y H:i A');
                $updated_html = '<div><div>'.$updated_at.'</div><div>'.($society_emp_code ? 'By '.$society_emp_code: '').'</div></div>';
                return $updated_html;
            })
            ->orderColumn('last_updated', function ($query, $order) {
                $query->orderBy('updated_at', $order);
            })
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return institutionChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->addColumn('society',function($row){
                $society = $row->society->name;
                return $society;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $route_name = request()->route()->getName(); 
                if( access()->buttonAccess($route_name,'add_edit') )
                {
                    $edit_btn = '<a href="javascript:void(0);" onclick="getInstituteModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                }
                else
                {
                    $edit_btn = '';
                }
                if( access()->buttonAccess($route_name,'delete') )
                {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteInstitution(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                }
                else
                {
                    $del_btn = '';
                }

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status','society', 'last_updated', 'name']);
            return $datatables->make(true);

        }
        return view('pages.masters.institutes.index',compact('society','breadcrums'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'society_id' => 'required',
            'institute_name' => 'required|string|unique:institutions,name,' . $id.',id,deleted_at,NULL',
            'institute_code' => 'required|string|unique:institutions,code,'.$id.',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {
          
            $ins['academic_id'] = academicYearId();
            $ins['society_id'] = $request->society_id;
            $ins['name'] = $request->institute_name;
            $ins['code'] = $request->institute_code;
            $ins['website'] = $request->website;
            $ins['address'] = $request->address;
            $ins['status'] = $request->status ?? 'active';
            if( isset( $id ) && !empty( $id )) {
                $ins['updatedBy'] = auth()->user()->id;
            } else {
                $ins['addedBy'] = auth()->user()->id;
            }
            
            $data = Institution::updateOrCreate(['id' => $id], $ins);

            if ($request->hasFile('logo')) {

                $files = $request->file('logo');
                $imageName = uniqid() . Str::replace([' ', '  '], "-", $files->getClientOriginalName());

                $directory              = 'institute/' . $data->code ;
                $filename               = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                // $ins['image'] = $filename;
                $data->logo = $filename;
                $data->save();
            }

            if( !$id ) {
                $id = $data->id;
            } 
            $error = 0;
            $message = 'Added successfully';
            $code = getStaffInstitutionCode($id);

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data, 'code' => $code ?? '' ]);
    }

    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Institutions';
        $from = 'master';
        if( isset( $id ) && !empty( $id ) ) {
            $info = Institution::find($id);
            $title = 'Update Institutions';

        }
        $society = Society::where('status', 'active')->get();
        $content = view('pages.masters.institutes.add_edit_form', compact('society', 'info','from'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function getInstituteStaffCode(Request $request)
    {
        $institute_id = $request->institute_id;
        $instituteInfo = Institution::find($institute_id);
        return getStaffInstitutionCode( $instituteInfo->code );
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Institution::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Institution status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Institution::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }

    public function export()
    {
        return Excel::download(new InstitutionExport,'institution.xlsx');
    }

}
