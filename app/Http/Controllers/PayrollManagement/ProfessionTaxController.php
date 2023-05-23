<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalTaxSlab;
use Illuminate\Http\Request;

class ProfessionTaxController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Professional Tax',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Professional Tax Slabs'
                ),
            )
        );
        $details = ProfessionalTaxSlab::all();
        
        return view('pages.payroll_management.pt.index', compact('breadcrums', 'details'));
    }

    public function save(Request $request)
    {
        
        $above_salary = $request->above_salary;
        $lq_salary = $request->lq_salary;
        $tax_amount = $request->tax_amount;

        $data = [];
        for ($i=0; $i < count($above_salary); $i++) { 
            $data[] = array('above_salary' => $above_salary[$i], 'lq_salary' => $lq_salary[$i], 'tax_amount' => $tax_amount[$i]);
        }

        if( !empty( $data ) ) {
            ProfessionalTaxSlab::where('status', 'active')->delete();
            foreach ($data as $key => $value) {
                
                $ins = [];
                $ins['from_amount'] = $value['above_salary'] ?? 0;
                $ins['to_amount'] = $value['lq_salary'] ?? 0;
                $ins['tax_fee'] = $value['tax_amount'] ?? 0;
                $ins['status'] = 'active';
                ProfessionalTaxSlab::create($ins);
            }
        }

        return array('error' => 1, 'message' => 'Success');
    }
}
