<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\ItTabulation;
use App\Models\Tax\TaxScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItTabulationController extends Controller
{
    public function index(Request $request) {
        $title = 'Income Tax Tabulations';
      
        $slab = ItTabulation::selectRaw('from_amount, to_amount, Max(from_amount)')
                            ->groupBy('from_amount')
                            ->groupBy('to_amount')
                            ->get();
        
        $scheme = ItTabulation::selectRaw('scheme, slug, Max(slug)')
                            ->groupBy('slug')
                            ->groupBy('scheme')
                            ->get();
        
        $params = array(
            'title' => $title,
            'slab' => $slab,
            'scheme' => $scheme
        );
        return view('pages.payroll_management.it_tabulation.index', $params);
    }

    public function addEditModal(Request $request) {
        $title = 'Add New Tax Scheme';
        $slug = $request->slug;
        $tax_scheme = TaxScheme::where('status', 'active')->get();
        if( $slug ) {
            $details = ItTabulation::where('slug', $slug)->get();
        }
        $params = array(
            'details' => $details ?? '',
            'tax_scheme' => $tax_scheme
        );

        $content = view('pages.payroll_management.it_tabulation.add_edit_form', $params);

        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request) {
        
        $id = $request->id;
        $validator      = Validator::make($request->all(), [
            'scheme_id' => 'required',
            'slab_amount' => 'required' 
        ]);

        if ($validator->passes()) { 
            
            $scheme_id = $request->scheme_id;
            $scheme_info = TaxScheme::find($scheme_id);
            $slab_amount = $request->slab_amount;
            $from_amount = $request->from_amount;
            $to_amount = $request->to_amount;
            $percentage = $request->percentage;
        
            if( count( $from_amount)>0){
                if( $request->slug ) {
                    ItTabulation::where('slug', $request->slug)->delete();
                }
                for ($i=0; $i < count( $from_amount); $i++) { 
                    $ins = [];
                    $ins['scheme_id'] = $scheme_id;
                    $ins['scheme'] = $scheme_info->name;
                    $ins['slug'] = Str::slug($scheme_info->name);
                    $ins['slab_amount'] = $slab_amount;
                    $ins['from_amount'] = $from_amount[$i];
                    $ins['to_amount'] = $to_amount[$i];
                    $ins['percentage'] = $percentage[$i];
                    $ins['addedBy'] = auth()->id();
                    $ins['updatedBy'] = auth()->id();
                    ItTabulation::create($ins);
                }
            }
            $error = 0;
            $message = 'Data saved successfully';
        } else {
            $message = $validator->errors()->all();
            $error = 1;
        }
        return array( 'error' => $error, 'message' => $message );
    }

    public function changeStatus(Request $request) {
        
        $slug = $request->slug;
        $old_status = ItTabulation::where('slug', $slug)->first();
        if( $old_status->status == 'active'){
            $change_status = 'inactive';
        } else {
            $change_status = 'active';
        }
        ItTabulation::where('slug', $slug)->update(['status' => $change_status]);
        return array( 'error' => 0, 'message' => 'Successfully updated' );

    }
}
