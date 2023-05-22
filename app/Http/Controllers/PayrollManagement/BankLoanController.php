<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\Master\Bank;
use App\Models\User;
use Illuminate\Http\Request;

class BankLoanController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Bank Loan',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Bank Loan'
                ),
            )
        );
        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();
        return view('pages.payroll_management.loan.index', compact('breadcrums', 'employees'));
    }

    function getFormAndList(Request $request) {
        $id = $request->id;
        if( $id ) {

            $bank = Bank::where('status', 'active')->get();
    
            return view('pages.payroll_management.loan.staff_loan_details', compact('bank'));
        } else {
            return '';
        }
    }

    public function insurance(Request $request)
    {
        $breadcrums = array(
            'title' => 'Insurance',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Insurance'
                ),
            )
        );
        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();
        return view('pages.payroll_management.lic.index', compact('breadcrums', 'employees'));
    }

    function getFormAndListInsurance(Request $request) {
        $id = $request->id;
        if( $id ) {

            $bank = Bank::where('status', 'active')->get();
    
            return view('pages.payroll_management.lic.staff_lic_details', compact('bank'));
        } else {
            return '';
        }
    }
}
