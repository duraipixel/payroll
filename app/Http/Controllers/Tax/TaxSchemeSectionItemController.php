<?php

namespace App\Http\Controllers\Tax;

use App\Exports\TaxSectionItemExport;
use App\Http\Controllers\Controller;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaxSchemeSectionItemController extends Controller
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
            $data = TaxSectionItem::with(['section', 'section.scheme'])->selectRaw('tax_section_items.*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($status) {
                        return $query->where('tax_section_items.status', '=', "$status");
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('tax_section_items.name', 'like', "%{$keywords}%")
                                ->orWhereDate('tax_section_items.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('name', function($row){
                    return $row->name;
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return taxSectionItemChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getTaxSectionItemModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteTaxSectionItem(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'name']);
            return $datatables->make(true);
        }
        return view('pages.tax.section_items.index', compact('breadcrums'));
    }

    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Tax Section Items';
        
        $sections = TaxSection::where('status', 'active')->get();
        if (isset($id) && !empty($id)) {
            $info = TaxSectionItem::find($id);
            $title = 'Update Tax Section Items';
        }

        $content = view('pages.tax.section_items.add_edit', compact('info', 'title', 'sections'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $section_id = $request->section_id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'name' => ['required','string',
                        Rule::unique('tax_section_items')->where(function ($query) use($section_id, $id) {
                            return $query->where('deleted_at', NULL)
                            ->where('tax_section_id', $section_id)
                            ->when($id != '', function($q) use($id){
                                return $q->where('id', '!=', $id);
                            });
                        }),
                    ],
            'section_id' => 'required'
        ]);
        
        if ($validator->passes()) {
            $section_info = TaxSection::find($request->section_id);
            $ins['academic_id'] = academicYearId();
            $ins['tax_scheme_id'] = $section_info->tax_scheme_id;
            $ins['tax_section_id'] = $request->section_id;
            $ins['name'] = $request->name;
            $ins['slug'] = Str::slug($request->name.' '.$section_info->name);
            $ins['added_by'] = auth()->id();
            $ins['updated_by'] = auth()->id();

            $data = TaxSectionItem::updateOrCreate(['id' => $id], $ins);
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
        $info           = TaxSectionItem::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Tax Section Item status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = TaxSectionItem::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted!", 'status' => 1]);
    }

    public function export()
    {
        return Excel::download(new TaxSectionItemExport, 'TaxSectionItem.xlsx');
    }
}
