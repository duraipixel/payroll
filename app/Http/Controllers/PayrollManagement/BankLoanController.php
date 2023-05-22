<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\Master\Bank;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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

    function getFormAndList(Request $request)
    {
        $id = $request->id;
        if ($id) {

            $bank = Bank::where('status', 'active')->get();
            $load_details = StaffBankLoan::where('staff_id', $id)->get();

            return view('pages.payroll_management.loan.staff_loan_details', compact('bank', 'id', 'load_details'));
        } else {
            return '';
        }
    }

    public function save(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'ifsc_code' => 'required',
            'account_no' => 'required',
            'amount' => 'required|numeric',
            'period_of_loan' => 'required|integer'
        ]);

        if ($validator->passes()) {
            $id = $request->id ?? '';
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);
            $bank_info = Bank::find($request->bank_id);
            $ins['staff_id'] = $request->staff_id;
            $ins['bank_id'] = $request->bank_id;
            $ins['bank_name'] = $bank_info->name;
            $ins['ifsc_code'] = $request->ifsc_code;
            $ins['loan_ac_no'] = $request->account_no;
            // $ins['loan_type_id'] = $request->staff_id;
            $ins['loan_due'] = $request->loan_type;
            $ins['every_month_amount'] = $request->amount;
            $ins['period_of_loans'] = $request->period_of_loan;
            $ins['status'] = 'active';
            if ($request->hasFile('document')) {

                $files = $request->file('document');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/loans';
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['file'] = $filename;
            }
            if ($request->loan_start_date) {
                $ins['loan_start_date'] = date('Y-m-d', strtotime($request->loan_start_date));
            }
            if ($request->loan_end_date) {
                $ins['loan_end_date'] = date('Y-m-d', strtotime($request->loan_end_date));
            }

            StaffBankLoan::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Bank Loan added successfully';
            
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'staff_id' => $staff_id ?? '']);

    }

    function editLoanForm(Request $request) {
        $id = $request->id;
        $loan_info = StaffBankLoan::find($id);
        $bank = Bank::where('status', 'active')->get();
        return view('pages.payroll_management.loan.form', compact('loan_info', 'bank'));
    }

    function deleteLoan(Request $request) {

        $id = $request->id;
        $info = StaffBankLoan::find($id);
        $staff_id = $info->staff_id;
        $info->delete();

        return response()->json(['staff_id' => $staff_id ?? '']);
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

    function getFormAndListInsurance(Request $request)
    {
        $id = $request->id;
        if ($id) {

            $bank = Bank::where('status', 'active')->get();
            $details = StaffInsurance::where('staff_id', $id)->get();
            return view('pages.payroll_management.lic.staff_lic_details', compact('bank', 'details'));
        } else {
            return '';
        }
    }

    public function saveInsurance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'insurance_name' => 'required',
            'policy_no' => 'required',
            'policy_date' => 'required',
            'amount' => 'required|numeric',
        ]);
        
        if ($validator->passes()) {
            $id = $request->id ?? '';
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);
            
            $ins['staff_id'] = $request->staff_id;
            $ins['insurance_name'] = $request->insurance_name;
            $ins['policy_no'] = $request->policy_no;
            $ins['maturity_date'] = $request->policy_date;
            $ins['amount'] = $request->amount;
            
            $ins['status'] = 'active';
            if ($request->hasFile('document')) {

                $files = $request->file('document');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/insurance';
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['file'] = $filename;
            }

            StaffInsurance::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Insurance added successfully';
            
        } else {

            $error = 1;
            $message = $validator->errors()->all();

        }

        return response()->json(['error' => $error, 'message' => $message, 'staff_id' => $staff_id ?? '']);

    }

    function editLicForm(Request $request) {
        $id = $request->id;
        $info = StaffInsurance::find($id);
        
        return view('pages.payroll_management.lic.form', compact('info'));
    }

    function deleteLic(Request $request) {

        $id = $request->id;
        $info = StaffInsurance::find($id);
        $staff_id = $info->staff_id;
        $info->delete();

        return response()->json(['staff_id' => $staff_id ?? '']);
    }
}
