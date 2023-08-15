<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Exports\PayrollStatementExport;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\Master\NatureOfEmployment;
use App\Models\PayrollManagement\Payroll;
use App\Models\PayrollManagement\PayrollPermission;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryField;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\Staff\StaffInsuranceEmi;
use App\Models\Staff\StaffLoanEmi;
use App\Models\User;
use App\Repositories\PayrollChecklistRepository;
use App\Repositories\PayrollRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class OverviewController extends Controller
{

    private $checklistRepository;
    private $payrollRepository;

    public function __construct(PayrollChecklistRepository $checklistRepository, PayrollRepository $payrollRepository)
    {
        $this->checklistRepository = $checklistRepository;
        $this->payrollRepository = $payrollRepository;
    }

    public function index()
    {

        $breadcrums = array(
            'title' => 'Payroll Overview',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Payroll Overview'
                ),
            )
        );

        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;

        $date = $start_year;
        $from_date = date('Y-m-01', strtotime($date));
        $to_date = date('Y-m-t', strtotime($date));
        $working_days = date('t', strtotime($date));

        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->first();
        $previous_month_start = date('Y-m-01', strtotime($date . ' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($date . ' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->first();

        return view('pages.payroll_management.overview.index', compact('breadcrums', 'date', 'payroll', 'working_days', 'previous_payroll', 'from_year'));
    }

    public function getMonthData(Request $request)
    {
        $academic_id = session()->get('academic_id');

        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;


        $dates = $request->dates;
        $month_no = $request->month_no;
        $start_year = date('Y-m-01', strtotime($start_year));
        $payout_date = date('Y-m-01', strtotime($dates));

        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $working_days = date('t', strtotime($to_date));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->first();

        $previous_month_start = date('Y-m-01', strtotime($dates . ' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($dates . ' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->first();
        if ($start_year == $payout_date) {
            $previous_payroll = 'yes';
        }
        $lock_info = PayrollPermission::where(['academic_id' => academicYearId(), 'payout_month' => $payout_date])->first();
        /** 
         * check previous month payroll created
         */
        $params = array(
            'date' => $dates,
            'lock_info' => $lock_info,
            'payroll' => $payroll,
            'working_days' => $working_days,
            'previous_payroll' => $previous_payroll
        );

        return view('pages.payroll_management.overview._ajax_month_view', $params);
    }

    public function setPermission(Request $request)
    {

        $status = $request->status;
        $mode = $request->mode;
        $payout_date = $request->payout_date;
        $payout_date = date('Y-m-01', strtotime($payout_date));
        $payout_id = $request->payout_id;

        $ins['academic_id'] = academicYearId();
        $ins['payout_month'] = $payout_date;
        $ins['payroll_id'] = $payout_id;

        if ($mode == 'payroll_inputs') {
            $ins['payroll_inputs'] = $status;
            $message = 'Payroll Input Permission set Successfully';
        }
        if ($mode == 'payroll_lock') {
            if ($status == 'lock') {
                $ins['payroll_lock'] = date('Y-m-d H:i:d');
                $message = 'Payroll Process locked Successfully';
            } else {
                $ins['payroll_lock'] = null;
                $message = 'Payroll Process unlocked Successfully';
            }
        }

        if ($mode == 'emp_view_release') {
            $message = 'Employee View Release Permission set Successfully';
            $ins['emp_view_release'] = $status;
        }
        if ($mode == 'it_statement_view') {
            $message = 'IT Statement Employee View set Successfully';
            $ins['it_statement_view'] = $status;
        }
        if ($mode == 'payroll') {
            $message = 'Payroll process ' . $status . ' Successfully';
            $ins['payroll'] = $status;
        }
        PayrollPermission::updateOrCreate(['payout_month' => $payout_date, 'academic_id' => academicYearId()], $ins);
        $error = 0;
        return array('error' => $error, 'message' => $message);
    }

    public function openPermissionModal(Request $request)
    {

        $status = $request->status;
        $mode = $request->mode;
        $payout_date = $request->payout_date;
        $payout_id = $request->payout_id;
        $title = ucfirst(str_replace('_', ' ', $mode));
        $params = array(
            'status' => $status,
            'title' => $title,
            'payout_date' => $payout_date,
            'mode' => $mode,
            'payout_id' => $payout_id
        );

        $content = view('pages.payroll_management.overview._payroll_input_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function createPayroll(Request $request)
    {

        $payroll_date = $request->payroll_date;
        $from_date = date('Y-m-01', strtotime($payroll_date));
        $to_date = date('Y-m-t', strtotime($payroll_date));

        $ins['from_date'] = $from_date;
        $ins['to_date'] = $to_date;
        $ins['name'] = date('F Y', strtotime($from_date));
        $ins['locked'] = 'no';
        $ins['added_by'] = auth()->id();

        $id = Payroll::create($ins)->id;

        $ins_roll['academic_id'] = academicYearId();
        $ins_roll['payout_month'] = $from_date;
        $ins_roll['payroll_id'] = $id;
        $ins_roll['payroll_inputs'] = 'unlock';
        $ins_roll['emp_view_release'] = 'lock';
        $ins_roll['it_statement_view'] = 'lock';
        $ins_roll['payroll'] = 'unlock';

        PayrollPermission::create($ins_roll);

        $error = 0;
        $date = $request->payroll_date;
        $month_no = date('m', strtotime($request->payroll_date));
        return array('date' => $date, 'month_no' => $month_no, 'error' => $error, 'message' =>   date('F Y', strtotime($from_date)) . '  payroll created successfully');
    }

    public function processPayrollModal(Request $request)
    {

        $date = $request->date;
        $payout_id = $request->payout_id;

        /**
         * 1. Employee it declaration Pending
         * 2. New Employee added with pending verification and salary creation
         * 3. Leave Day Finalized
         * 4. Resigned Staff
         * 5. Salary Hold Finalized
         * 6. Hold due Discipline Action
         */

        /**
         * select * from users where verification_status = 'approved';
         */

        $leave_data = $this->checklistRepository->getPendingRequestLeave($date);
        $employee_data = $this->checklistRepository->getEmployeePendingPayroll();
        $income_tax_data = $this->checklistRepository->getPendingITEntry();
        $hold_salary_employee = $this->checklistRepository->getHoldSalaryEmployee($date);
        
        $is_entried_min_attendance = $leave_data['total_present'] ?? 0;

        $title = 'Payroll Process Confirmation';
        $params = array(
            'date' => $date,
            'payout_id' => $payout_id,
            'leave_data' => $leave_data,
            'title' => $title,
            'employee_data' => $employee_data,
            'income_tax_data' => $income_tax_data,
            'hold_salary_employee' => $hold_salary_employee,
            'is_entried_min_attendance' => $is_entried_min_attendance
        );

        return view('pages.payroll_management.overview._payroll_form', $params);
    }

    public function setPayrollProcessing(Request $request)
    {

        $date = $request->date;
        $payout_id = $request->payout_id;
        $payroll_points = $request->payroll_points;
        $process_it = $request->process_it;
        $payroll_date = date('Y-m-d', strtotime($date . '-1 month'));
        $month_start = date('Y-m-01', strtotime($payroll_date));
        $month_end = date('Y-m-t', strtotime($payroll_date));

        $payout_data = $this->checklistRepository->getToPayEmployee($date);
        // dd( $payout_data );
        $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', 3)->get();
        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere('nature_id', 3);
            })->get();

        // dd( $payout_data[0]->workedDays->count() );
        $params = array(
            'date' => $date,
            'payout_id' => $payout_id,
            'payroll_points' => $payroll_points,
            'process_it' => $process_it,
            'payout_data' => $payout_data,
            'earings_field' => $earings_field,
            'deductions_field' => $deductions_field,
            'working_day' => date('d', strtotime($month_end))
        );

        // dd( $params );

        return view('pages.payroll_management.overview._payroll_process', $params);
    }

    public function continuePayrollProcessing(Request $request)
    {

        /**
         * 1. Need to generate salary pdf for every staff
         * 2. Make entries in database         
         * 3. Make Payroll Log for payroll generation History
         */
        $total_net_pay = $request->total_net_pay;
        $working_day = $request->working_day;
        $payout_id = $request->payout_id;
        $date = $request->date;

        $month = date('F', strtotime($date));
        $month_length = date('t', strtotime($date));

        $payroll_date = date('Y-m-d', strtotime($date . '-1 month'));
        $month_start = date('Y-m-01', strtotime($payroll_date));
        $month_end = date('Y-m-t', strtotime($payroll_date));
        $working_day = date('t', strtotime($payroll_date));
        $payroll_info = Payroll::find($payout_id);
        $payout_data = $this->checklistRepository->getToPayEmployee($date);
        $error = '1';
        $message = 'Error occurred while generating payroll';
        /** 
         * 1. staff salary
         */
        $salary_month = date('F', strtotime($payroll_date));
        $salary_year = date('Y', strtotime($payroll_date));

        $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', 3)->get();
        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere('nature_id', 3);
            })->get();

        // $month_length = date('t', strtotime($payroll_date));
        if (isset($payout_data) && count($payout_data)) {

            StaffSalary::where('payroll_id', $payout_id)->update(['status' => 'inactive']);
            $used_loans = [];
            $used_insurance = [];
            foreach ($payout_data as $key => $value) {
                $staff_info = User::find($value->id);
                $other_description = '';
                // if ($value->appointment->employment_nature->id) {

                    // $nature_id = $value->appointment->employment_nature->id;
                    // $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', $nature_id)->get();
                    // $deductions_field = SalaryField::where('salary_head_id', 2)
                    //     ->where(function ($query) use ($nature_id) {
                    //         $query->where('is_static', 'yes');
                    //         $query->orWhere('nature_id', $nature_id);
                    //     })->get();

                    $gross = $value->currentSalaryPattern->gross_salary;
                    $deduction = 0;
                    $earnings = 0;
                    $used_fields = [];
                    if (isset($earings_field) && !empty($earings_field)) {
                        foreach ($earings_field as $eitem) {
                            $tmp = [];
                            $tmp = ['field_id' => $eitem->id, 'field_name' => $eitem->name, 'reference_type' => 'EARNINGS', 'reference_id' => 1, 'short_name' => $eitem->short_name];
                            $amounts = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '',$eitem->name, 'EARNINGS', $eitem->short_name);
                            if ($amounts > 0) {
                                $tmp['amount'] = $amounts;
                                $used_fields[] = $tmp;
                                $earnings += $amounts;
                            }
                        }
                    }

                    if (isset($deductions_field) && !empty($deductions_field)) {

                        foreach ($deductions_field as $sitem) {
                            $tmp = [];
                            $deduct_amount = 0;
                            $tmp = ['field_id' => $sitem->id, 'field_name' => $sitem->name, 'reference_type' => 'DEDUCTIONS', 'reference_id' => 2, 'short_name' => $sitem->short_name];
                            if ($sitem->short_name == 'IT') {

                                $deduct_amount = staffMonthTax($value->id, strtolower($month));

                                if ($deduct_amount > 0) {
                                    $tmp['amount'] = $deduct_amount;
                                    $used_fields[] = $tmp;
                                }

                                $deduction += $deduct_amount;

                            } else if( trim( strtolower( $sitem->short_name ) ) == 'other' ) {

                                $other_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                /**
                                 * get leave deduction amount
                                 */
                                $leave_amount_day = getStaffLeaveDeductionAmount( $value->id, $date ) ?? 0;
                                $leave_amount = 0;
                                if( $leave_amount_day ) {
                                    $leave_amount = getDaySalaryAmount($gross, $month_length);
                                    $leave_amount = $leave_amount * $leave_amount_day;
                                    $other_description = $leave_amount_day > 1 ? $leave_amount_day.' days' : $leave_amount_day.'day';
                                    $other_description .= ' leave amount deducted';
                                }
                                $other_amount += $leave_amount;

                                if( $other_amount > 0 ) {
                                    $tmp = [];
                                    $tmp = ['field_id' => $sitem->id, 'field_name' => $sitem->name, 'reference_type' => 'DEDUCTIONS', 'reference_id' => 2, 'short_name' => $sitem->short_name];
                                    $tmp['amount'] = $other_amount;
                                    $used_fields[] = $tmp;
                                }

                                $deduction += $other_amount;
                            } else if(trim(strtolower($sitem->short_name)) == 'bank loan'){
                                $bank_loan_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                /**
                                 * get leave deduction amount
                                 */
                                $other_bank_loan_amount = getBankLoansAmount($value->id, $date);
                                
                                $bank_loan_amount += $other_bank_loan_amount['total_amount'] ?? 0;
                                if( !empty( $other_bank_loan_amount['emi']) ) {
                                    $used_loans[] = $other_bank_loan_amount['emi'];
                                }
                                if( $bank_loan_amount > 0 ) {
                                    $tmp = [];
                                    $tmp = ['field_id' => $sitem->id, 'field_name' => $sitem->name, 'reference_type' => 'DEDUCTIONS', 'reference_id' => 2, 'short_name' => $sitem->short_name];
                                    $tmp['amount'] = $bank_loan_amount;
                                    $used_fields[] = $tmp;
                                }

                                $deduction += $bank_loan_amount;
                            }  else if(trim(strtolower($sitem->short_name)) == 'lic') {
                                
                                $insurance_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                /**
                                 * get leave deduction amount
                                 */
                                $other_insurance_amount = getInsuranceAmount($value->id, $date);
                                
                                $insurance_amount += $other_insurance_amount['total_amount'] ?? 0;
                                if( !empty( $other_insurance_amount['emi']) ) {
                                    $used_insurance[] = $other_insurance_amount['emi'];
                                }
                                if( $insurance_amount > 0 ) {
                                    $tmp = [];
                                    $tmp = ['field_id' => $sitem->id, 'field_name' => $sitem->name, 'reference_type' => 'DEDUCTIONS', 'reference_id' => 2, 'short_name' => $sitem->short_name];
                                    $tmp['amount'] = $insurance_amount;
                                    $used_fields[] = $tmp;
                                }

                                $deduction += $insurance_amount;
                            } else {
                                $deduct_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                $deduction += $deduct_amount;

                                if ($deduct_amount > 0) {
                                    $tmp['amount'] = $deduct_amount;
                                    $used_fields[] = $tmp;
                                }
                            }
                        }
                    }

                    $net_pay = $gross - $deduction;
                // }

                if ($earnings == $gross && !empty($used_fields)) {

                    $staff_id = $value->id;

                    $sal['staff_id'] = $staff_id;
                    $sal['payroll_id'] = $payout_id;
                    $sal['salary_month'] = $salary_month;
                    $sal['salary_year'] = $salary_year;
                    $sal['is_salary_processed'] = 'yes';
                    $sal['status'] = 'active';
                    $sal['salary_pattern_id'] = $value->currentSalaryPattern->id;
                    $sal['working_days'] = $working_day;
                    $sal['worked_days'] = $value->workedDays->count();
                    $sal['other_description'] = $other_description;
                    $salary_info = StaffSalary::updateOrCreate(['staff_id' => $staff_id, 'payroll_id' => $payout_id], $sal);

                    /**
                     * insert in salary fields
                     */
                    foreach ($used_fields as $pay_items) {

                        $field = [];
                        $field['staff_id'] = $staff_id;
                        $field['staff_salary_id'] = $salary_info->id;
                        $field['field_id'] = $pay_items['field_id'];
                        $field['field_name'] = $pay_items['field_name'];
                        $field['short_name'] = $pay_items['short_name'] ?? '';
                        $field['amount'] = $pay_items['amount'];
                        $field['reference_type'] = $pay_items['reference_type'];
                        $field['reference_id'] = $pay_items['reference_id'];
                        $field['percentage'] = 0;
                        StaffSalaryField::updateOrCreate(['staff_salary_id' => $salary_info->id, 'reference_type' => $pay_items['reference_type'], 'staff_id' => $staff_id, 'field_id' => $pay_items['field_id']], $field);
                    }
                    /**
                     * update in bank loans
                     */
                    if( !empty( $used_loans ) ) {
                        $staff_loan_id = [];
                        foreach($used_loans as $loan_items ) {
                            if( isset( $loan_items['details'] ) && !empty( $loan_items['details'] ) ) {

                                $info = StaffLoanEmi::find( $loan_items['details']->id );
                                $info->status = 'paid';
                                $info->save();

                                $staff_loan_id[]  = $loan_items['details']->staff_loan_id;
                            }
                        }
                        /**
                         * 1. For case 1 loan paid by all month
                         * 2. If loan close by half duration - need to do 
                         */
                        if( !empty( $staff_loan_id ) ) {
                            $staff_loan_id = array_unique($staff_loan_id);
                            foreach($staff_loan_id as $loan_ids ) {
                                $loan_info = StaffBankLoan::with('paid_emi')->find( $loan_ids );
                                if( $loan_info && $loan_info->period_of_loans == $loan_info->paid_emi()->count() ) {
                                    $loan_info->status = 'completed';
                                    $loan_info->save();
                                }
                            }
                        }
                    }
                    /**
                     * update in insurances
                     */
                    if( !empty( $used_insurance ) ) {
                        $staff_ins_id = [];
                        foreach($used_insurance as $loan_items ) {
                            if( isset( $loan_items['details'] ) && !empty( $loan_items['details'] ) ) {

                                $info = StaffInsuranceEmi::find( $loan_items['details']->id );
                                $info->status = 'paid';
                                $info->save();

                                $staff_ins_id[]  = $loan_items['details']->staff_ins_id;
                            }
                        }
                        /**
                         * 1. For case 1 loan paid by all month
                         * 2. If loan close by half duration - need to do 
                         */
                        if( !empty( $staff_ins_id ) ) {
                            $staff_ins_id = array_unique($staff_ins_id);
                            foreach($staff_ins_id as $loan_ids ) {
                                $loan_info = StaffInsurance::with('paid_emi')->find( $loan_ids );
                                if( $loan_info && $loan_info->period_of_loans == $loan_info->paid_emi()->count() ) {
                                    $loan_info->status = 'completed';
                                    $loan_info->save();
                                }
                            }
                        }
                    }

                    $salary_info->salary_no = salaryNo();
                    $salary_info->total_earnings = $gross;
                    $salary_info->total_deductions = $deduction;
                    $salary_info->gross_salary = $gross;
                    $salary_info->net_salary = $net_pay ?? 0;
                    $salary_info->is_salary_processed = 'yes';
                    $salary_info->salary_processed_on = date('Y-m-d H:i:s');

                    /**
                     * generate document for staff salary
                     */
                    $salary_info->save();
                    // dump( $salary_info );
                    $salary_info->document = $this->payrollRepository->generateSalarySlip($salary_info);
                    $salary_info->save();
                }
            }
            $payroll_info->payroll_date = date('Y-m-d');
            $payroll_info->save();

            $info = Payroll::with('salaryStaff')->find($payout_id);
            $error = '0';
            $message = 'Payroll processed successfully!';
            $params = [
                'info' => $info
            ];
            $html = view('pages.payroll_management.overview._ajax_success_payroll', $params);
        }

        return ['error' => $error, 'message' => $message, 'html' => "$html" ?? ''];
        
    }

    public function payrollStatement(Request $request)
    {

        $id = $request->id;
        $payroll_info = Payroll::find($id);

        $employee_nature = NatureOfEmployment::where('status', 'active')->get();
        $employees = User::where('status', 'active')->orderBy('name', 'asc')->whereNull('is_super_admin')->get();

        $params = [
            'employees' => $employees,
            'payroll_info' => $payroll_info,
            'employee_nature' => $employee_nature
        ];

        return view('pages.payroll_management.overview.statement.index', $params);
    }

    public function payrollStatementList(Request $request)
    {

        $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', 3)->get();
        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere('nature_id', 3);
            })->get();
        
        $payroll_id = $request->payroll_id;
        $staff_id = $request->staff_id;
        // $nature_id = $request->nature_id;

        $salary_info = StaffSalary::
                        where('payroll_id', $payroll_id)
                        ->when( !empty( $staff_id ), function( $query ) use($staff_id) {
                            $query->where('staff_id', $staff_id);
                        } )
                        ->where('status', 'active')
                        ->get();

        $params = [
            'earings_field' => $earings_field,
            'deductions_field' => $deductions_field,
            'salary_info' => $salary_info
        ];

        return view('pages.payroll_management.overview.statement._list', $params);
    }

    public function exportStatement(Request $request) {

        $payroll_id = $request->payroll_id;
        $staff_id = $request->staff_id;

        return Excel::download(new PayrollStatementExport($payroll_id, $staff_id), 'payroll_statement.xlsx');

    }
}
