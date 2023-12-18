<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\Master\Bank;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\Staff\StaffInsuranceEmi;
use App\Models\Staff\StaffLoanEmi;
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
        $employees = User::where('status', 'active')->get();
        return view('pages.payroll_management.loan.index', compact('breadcrums', 'employees'));
    }

    function getFormAndList(Request $request)
    {
        $id = $request->id;
        if ($id) {

            $bank = Bank::where('status', 'active')->get();
            $load_details = StaffBankLoan::where('staff_id', $id)->get();
            $user_info = User::find($id);

            return view('pages.payroll_management.loan.staff_loan_details', compact('bank', 'id', 'load_details', 'user_info'));
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

            // dd( $request->all() );
            $id = $request->id ?? '';
            $staff_id = auth()->user()->is_super_admin ? $request->staff_id : auth()->user()->id;
            $staff_info = User::find($staff_id);
            $bank_info = Bank::find($request->bank_id);
            $ins['staff_id'] = $staff_id;
            $ins['bank_id'] = $request->bank_id;
            $ins['bank_name'] = $bank_info->name;
            $ins['ifsc_code'] = $request->ifsc_code;
            $ins['loan_ac_no'] = $request->account_no;
            // $ins['loan_type_id'] = $request->staff_id;
            $ins['loan_due'] = $request->loan_type;
            $ins['every_month_amount'] = $request->every_month_amount;
            $ins['loan_amount'] = $request->amount;
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

            $loan_info = StaffBankLoan::updateOrCreate(['id' => $id], $ins);

            $emi_month = $request->emi_month;
            $emi_amount = $request->emi_amount;

            if (count($emi_month) > 0 && count($emi_amount) > 0) {
                StaffLoanEmi::where('staff_loan_id', $loan_info->id)->update(['status' => 'inactive']);
                for ($i = 0; $i < count($emi_month); $i++) {

                    $emi_date = $emi_month[$i];
                    $check_date = date('Y-m-01', strtotime($emi_date));
                    $ins = [];
                    $ins['staff_id'] = $staff_id;
                    $ins['staff_loan_id'] = $loan_info->id;
                    $ins['emi_date'] = $emi_date;
                    $ins['emi_month'] = $check_date;
                    $ins['amount'] = $emi_amount[$i] ?? 0;
                    $ins['loan_mode'] = $request->loan_type;
                    $ins['loan_type'] = 'Bank Loan';
                    $ins['status'] = 'active';

                    StaffLoanEmi::updateOrCreate(['staff_loan_id' => $loan_info->id, 'emi_month' => $check_date], $ins);
                }
            }


            $error = 0;
            $message = 'Bank Loan added successfully';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'staff_id' => $staff_id ?? '']);
    }

    function editLoanForm(Request $request)
    {
        $id = $request->id;
        $loan_info = StaffBankLoan::find($id);
        $bank = Bank::where('status', 'active')->get();
        $user_info = User::find($loan_info->staff_id);
        return view('pages.payroll_management.loan.form', compact('loan_info', 'bank', 'user_info'));
    }

    function deleteLoan(Request $request)
    {

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
        $employees = User::where('status', 'active')->orderBy('name', 'asc')->get();
        return view('pages.payroll_management.lic.index', compact('breadcrums', 'employees'));
    }

    function getFormAndListInsurance(Request $request)
    {
        $id = $request->id;
        if ($id) {

            $bank = Bank::where('status', 'active')->get();
            $details = StaffInsurance::where('staff_id', $id)->get();
            $staff_id = $id;
            $user_info = User::find($id);
            return view('pages.payroll_management.lic.staff_lic_details', compact('bank', 'details', 'staff_id', 'user_info'));
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
            $staff_id = auth()->user()->is_super_admin ? $request->staff_id : auth()->user()->id;
            $staff_info = User::find($staff_id);

            $ins['staff_id'] = $staff_id;
            $ins['insurance_name'] = $request->insurance_name;
            $ins['policy_no'] = $request->policy_no;
            $ins['maturity_date'] = $request->policy_date;
            $ins['amount'] = $request->amount;
            $ins['insurance_due_type'] = $request->insurance_due_type;
            $ins['period_of_loans'] = $request->period_of_loans;
            $ins['every_month_amount'] = $request->every_month_amount;
            $ins['start_date'] = $request->start_date;
            $ins['end_date'] = $request->end_date;

            $ins['status'] = 'active';
            if ($request->hasFile('document')) {

                $files = $request->file('document');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/insurance';
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['file'] = $filename;
            }

            $ins_info = StaffInsurance::updateOrCreate(['id' => $id], $ins);

            $emi_month = $request->emi_month;
            $emi_amount = $request->emi_amount;

            if (count($emi_month) > 0 && count($emi_amount) > 0) {
                StaffInsuranceEmi::where('staff_insurance_id', $ins_info->id)->update(['status' => 'inactive']);
                for ($i = 0; $i < count($emi_month); $i++) {

                    $emi_date = $emi_month[$i];
                    $check_date = date('Y-m-01', strtotime($emi_date));
                    $ins = [];
                    $ins['staff_id'] = $staff_id;
                    $ins['staff_insurance_id'] = $ins_info->id;
                    $ins['emi_date'] = $emi_date;
                    $ins['emi_month'] = $check_date;
                    $ins['amount'] = $emi_amount[$i] ?? 0;
                    $ins['insurance_mode'] = $request->loan_type;
                    $ins['insurance_type'] = 'lic';
                    $ins['status'] = 'active';

                    StaffInsuranceEmi::updateOrCreate(['staff_insurance_id' => $ins_info->id, 'emi_month' => $check_date], $ins);
                }
            }
            $error = 0;
            $message = 'Insurance added successfully';
        } else {

            $error = 1;
            $message = $validator->errors()->all();
        }

        return response()->json(['error' => $error, 'message' => $message, 'staff_id' => $staff_id ?? '']);
    }

    function editLicForm(Request $request)
    {
        $id = $request->id;
        $info = StaffInsurance::find($id);

        $user_info = User::find($info->staff_id);

        return view('pages.payroll_management.lic.form', compact('info', 'user_info'));
    }

    function deleteLic(Request $request)
    {

        $id = $request->id;
        $info = StaffInsurance::find($id);
        $staff_id = $info->staff_id;
        $info->delete();

        return response()->json(['staff_id' => $staff_id ?? '']);
    }


    public function getEmiDetails(Request $request)
    {

        $period_of_loan = $request->period_of_loan;
        $loan_start_date = $request->loan_start_date;
        $amount = $request->amount;
        $loan_type = $request->loan_type;

        $emi_details = [];

        if ($loan_start_date && $period_of_loan) {
            for ($i = 0; $i < $period_of_loan; $i++) {
                $emi_details[] = array(
                    's_no' => $i + 1,
                    'month' => date('Y-m-d', strtotime($loan_start_date . '+' . $i . 'month')),
                    'amount' => $amount
                );
            }
        }
        if ($loan_type == 'fixed') {
            return view('pages.payroll_management.loan._emi', compact('emi_details'));
        } else {

            return view('pages.payroll_management.loan._emi_variable', compact('emi_details'));
        }
    }

    public function getInsuranceEmiDetails(Request $request)
    {

        $period_of_loan = $request->period_of_loan;
        $loan_start_date = $request->loan_start_date;
        $amount = $request->amount;
        $loan_type = $request->loan_type;

        $emi_details = [];

        if ($loan_start_date && $period_of_loan) {
            for ($i = 0; $i < $period_of_loan; $i++) {
                $emi_details[] = array(
                    's_no' => $i + 1,
                    'month' => date('Y-m-d', strtotime($loan_start_date . '+' . $i . 'month')),
                    'amount' => $amount
                );
            }
        }
        if ($loan_type == 'fixed') {
            return view('pages.payroll_management.lic._emi', compact('emi_details'));
        } else {

            return view('pages.payroll_management.lic._emi_variable', compact('emi_details'));
        }
    }
}
