<?php

namespace App\Http\Controllers\Tax;

use App\Exports\TaxSchemeExport;
use App\Http\Controllers\Controller;
use App\Models\Tax\TaxScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use App\Models\PayrollManagement\ItStaffStatement;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Repositories\TaxCalculationRepository;
use App\Models\Staff\StaffTaxSeperation;
class TaxSchemeController extends Controller
{   
    private $taxRepository; 
    public function __construct(TaxCalculationRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Tax Schemes / Regime',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Tax Schemes / Regime'
                ),
            )
        );
        if ($request->ajax()) {
            $data = TaxScheme::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($status) {
                        return $query->where('tax_schemes.status', '=', "$status");
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('tax_schemes.name', 'like', "%{$keywords}%")
                                ->orWhereDate('tax_schemes.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return taxSchemeChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('is_current', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->is_current == 'yes') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->is_current) . '" onclick="return taxSchemeSetCurrent(' . $row->id .')">' . ucfirst($row->is_current) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getTaxSchemeModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteTaxScheme(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'is_current']);
            return $datatables->make(true);
        }
        return view('pages.tax.schemes.index', compact('breadcrums'));
    }

    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Tax Schemes';
        $from = 'master';
        if (isset($id) && !empty($id)) {
            $info = TaxScheme::find($id);
            $title = 'Update Tax Schemes';
        }

        $content = view('pages.tax.schemes.add_edit', compact('info', 'title', 'from'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'scheme' => 'required|string|unique:tax_schemes,name,' . $id .',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->scheme;
            $ins['slug'] = Str::slug($request->scheme);
            $ins['status'] = $request->status;
            $ins['is_current'] = $request->is_current;
            $ins['added_by'] = auth()->id();
            $ins['updated_by'] = auth()->id();
            if( $ins['is_current'] == 'yes' ) {
                TaxScheme::where('status', 'active')->update(['is_current' => 'no']);
            }

            $data = TaxScheme::updateOrCreate(['id' => $id], $ins);
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
        $info           = TaxScheme::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Tax Scheme status!", 'status' => 1]);
    }

    public function setCurrent(Request $request)
    {
        $data='';
        $validator      = Validator::make($request->all(), [
            'scheme_id' => 'required',
        ],[
            'scheme_id.required'=>'Scheme is required']);
        
        if ($validator->passes()) {
            TaxScheme::where('status', 'active')->update(['is_current' => 'no']);
            $info           = TaxScheme::find($request->scheme_id);
            $info->is_current   = 'yes';
            $info->update();
            $staff=User::find($request->staff_id);
            $staff->tax_scheme_id=$request->scheme_id;
            $staff->update();
            ItStaffStatement::where('academic_id', academicYearId())->where('staff_id',$request->staff_id)->delete();
           StaffTaxSeperation::where('academic_id', academicYearId())->where('staff_id',$request->staff_id)->delete();
            $this->taxRepository->generateStatementForStaff($request->staff_id);
            $error = 0;
            $message = 'You set current Scheme!';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = TaxScheme::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted!", 'status' => 1]);
    }

    public function export()
    {
        return Excel::download(new TaxSchemeExport, 'TaxScheme.xlsx');
    }
}
