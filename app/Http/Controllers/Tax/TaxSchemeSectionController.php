<?php

namespace App\Http\Controllers\Tax;

use App\Exports\TaxSectionExport;
use App\Http\Controllers\Controller;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaxSchemeSectionController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Tax Sections',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Tax Sections'
                ),
            )
        );
        if ($request->ajax()) {
            $data = TaxSection::with('scheme')->selectRaw('tax_sections.*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($status) {
                        return $query->where('tax_sections.status', '=', "$status");
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('tax_sections.name', 'like', "%{$keywords}%")
                                ->orWhereDate('tax_sections.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('name', function($row){
                    return $row->name;
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return taxSectionChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getTaxSectionModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteTaxSection(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'name']);
            return $datatables->make(true);
        }
        return view('pages.tax.sections.index', compact('breadcrums'));
    }

    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Tax Sections';
        
        $schemes = TaxScheme::where('status', 'active')->get();
        if (isset($id) && !empty($id)) {
            $info = TaxSection::find($id);
            $title = 'Update Tax Sections';
        }

        $content = view('pages.tax.sections.add_edit', compact('info', 'title', 'schemes'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $scheme_id = $request->scheme_id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            
            'name' => ['required','string',
                        Rule::unique('tax_sections')->where(function ($query) use($scheme_id, $id) {
                            return $query->where('deleted_at', NULL)
                            ->where('tax_scheme_id', $scheme_id)
                            ->when($id != '', function($q) use($id){
                                return $q->where('id', '!=', $id);
                            });
                        }),
                    ],
            'scheme_id' => 'required'
        ]);

        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['tax_scheme_id'] = $request->scheme_id;
            $ins['name'] = $request->name;
            $ins['slug'] = Str::slug($request->name);
            $ins['maximum_limit'] = $request->maximum_limit;
            $ins['status'] = $request->status;
            $ins['added_by'] = auth()->id();
            $ins['updated_by'] = auth()->id();

            $data = TaxSection::updateOrCreate(['id' => $id], $ins);
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
        $info           = TaxSection::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Tax Section status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = TaxSection::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted!", 'status' => 1]);
    }

    public function export()
    {
        return Excel::download(new TaxSectionExport, 'TaxSection.xlsx');
    }
}
