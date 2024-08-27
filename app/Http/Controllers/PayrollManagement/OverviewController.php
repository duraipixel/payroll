<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Exports\PayrollStatementExport;
use App\Exports\PayrollTempExport;
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
use App\Models\Staff\StaffSalaryPreDeduction;
use App\Models\Staff\StaffSalaryPreEarning;
use App\Models\User;
use App\Repositories\PayrollChecklistRepository;
use App\Repositories\PayrollRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Staff\StaffTaxSeperation;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PayrollManagement\ItStaffStatement;
use DB;
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

        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $previous_month_start = date('Y-m-01', strtotime($date . ' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($date . ' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->where('institute_id',session()->get('staff_institute_id'))->first();

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
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();

        $previous_month_start = date('Y-m-01', strtotime($dates . ' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($dates . ' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->where('institute_id',session()->get('staff_institute_id'))->first();
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

    // public function setPermission2(Request $request)
    // {

    //     $status = $request->status;
    //     $mode = $request->mode;
    //     $payout_date = $request->payout_date;
    //     $payout_date = date('Y-m-01', strtotime($payout_date));
    //     $payout_id = $request->payout_id;

    //     $ins['academic_id'] = academicYearId();
    //     $ins['payout_month'] = $payout_date;
    //     $ins['payroll_id'] = $payout_id;

    //     if ($mode == 'payroll_inputs') {
    //         $ins['payroll_inputs'] = $status;
    //         $message = 'Payroll Input Permission set Successfully';
    //     }
    //     if ($mode == 'payroll_lock') {
    //         if ($status == 'lock') {
    //             $ins['payroll_lock'] = date('Y-m-d H:i:d');
    //             $message = 'Payroll Process locked Successfully';
    //         } else {
    //             $ins['payroll_lock'] = null;
    //             $message = 'Payroll Process unlocked Successfully';
    //         }
    //     }

    //     if ($mode == 'emp_view_release') {
    //         $message = 'Employee View Release Permission set Successfully';
    //         $ins['emp_view_release'] = $status;
    //     }
    //     if ($mode == 'it_statement_view') {
    //         $message = 'IT Statement Employee View set Successfully';
    //         $ins['it_statement_view'] = $status;
    //     }
    //     if ($mode == 'payroll') {
    //         if( $status == 'lock' ) {
    //             $ins['payroll'] = $status;
    //             $ins['payroll_lock'] = date('Y-m-d H:i:d');
    //         } else {
    //             $ins['payroll'] = $status;
    //             $ins['payroll_lock'] = null;
    //         }
    //         $message = 'Payroll process ' . $status . ' Successfully';
    //     }
    //     if ($mode == 'tax_lock_calculation') {
    //     if ($status == 'lock') {
    //         $incomes =User::where('institute_id',session()->get('staff_institute_id'))->where('status','active')->where('verification_status','approved')->where('transfer_status','active')->get();
    //         foreach($incomes as $income){
    //         $income_info=ItStaffStatement::where('staff_id',$income->id)->first();
    //         if ($income_info) {
    //         $total_income_tax_payable=$income_info->total_income_tax_payable??0;
    //         $tax_amount=($total_income_tax_payable/4);
    //         $ins['academic_id'] = academicYearId();
    //         $ins['staff_id'] = $income->id;
    //         $ins['income_tax_id'] = $income_info->id;
    //         $ins['april'] =0;
    //         $ins['may'] = 0;
    //         $ins['june'] = 0;
    //         $ins['july'] = 0;
    //         $ins['august'] = 0;
    //         $ins['september'] = 0;
    //         $ins['october'] = 0;
    //         $ins['november'] = 0;
    //         $ins['december'] = $tax_amount??0;
    //         $ins['january'] = $tax_amount??0;
    //         $ins['february'] = $tax_amount??0;
    //         $ins['march'] = $tax_amount??0;
    //         $ins['total_tax'] = $total_income_tax_payable;
    //         StaffTaxSeperation::updateOrCreate(['staff_id' => $income->id, 'income_tax_id' => $income_info->id], $ins);
    //         ItStaffStatement::where('id', $income_info->id)->update(['is_staff_calculation_done' => 'yes']);
    //         }
    //         }
    //         $message = 'Tax Lock Calculation locked Successfully';

    //         } else {
    //             ItStaffStatement::where('academic_id',academicYearId())->update(['lock_calculation'=>'no','is_staff_calculation_done' => 'no']);
    //             $message = 'Tax Lock Calculation unlocked Successfully';
    //         }
    //         $ins['tax_lock_calculation'] =$status;
    //     }
    //     PayrollPermission::updateOrCreate(['payout_month' => $payout_date, 'academic_id' => academicYearId()], $ins);
    //     $error = 0;
    //     return array('error' => $error, 'message' => $message);
    // }
    public function setPermission(Request $request)
    {
        try {
            $status = $request->status;
            $mode = $request->mode;
            $payout_date = date('Y-m-01', strtotime($request->payout_date));
            $payout_id = $request->payout_id;
    
            $academicId = academicYearId();
            $currentDate = now();
    
            $ins = [
                'academic_id' => $academicId,
                'payout_month' => $payout_date,
                'payroll_id' => $payout_id
            ];
    
            $message = '';
    
            switch ($mode) {
                case 'payroll_inputs':
                    $ins['payroll_inputs'] = $status;
                    $message = 'Payroll Input Permission set Successfully';
                    break;
    
                case 'payroll_lock':
                    $ins['payroll_lock'] = ($status === 'lock') ? $currentDate : null;
                    $message = ($status === 'lock') ? 'Payroll Process locked Successfully' : 'Payroll Process unlocked Successfully';
                    break;
    
                case 'emp_view_release':
                    $ins['emp_view_release'] = $status;
                    $message = 'Employee View Release Permission set Successfully';
                    break;
    
                case 'it_statement_view':
                    $ins['it_statement_view'] = $status;
                    $message = 'IT Statement Employee View set Successfully';
                    break;
    
                case 'payroll':
                    $ins['payroll'] = $status;
                    $ins['payroll_lock'] = ($status === 'lock') ? $currentDate : null;
                    $message = 'Payroll process ' . $status . ' Successfully';
                    break;
    
                case 'tax_lock_calculation':
                    if ($status === 'lock') {
                        User::where('institute_id', session()->get('staff_institute_id'))
                            ->where('status', 'active')
                            ->where('verification_status', 'approved')
                            ->where('transfer_status', 'active')
                            ->chunk(100, function($incomes) use ($ins,$academicId) {
                                foreach ($incomes as $income) {
                                    $income_info = ItStaffStatement::where('staff_id', $income->id)->first();
                                    if ($income_info) {
                                        $total_income_tax_payable = $income_info->total_income_tax_payable ?? 0;
                                        $tax_amount = $total_income_tax_payable / 4;
    
                                        $ins_tax = [
                                            'academic_id' => $academicId,
                                            'staff_id' => $income->id,
                                            'income_tax_id' => $income_info->id,
                                            'april' => 0,
                                            'may' => 0,
                                            'june' => 0,
                                            'july' => 0,
                                            'august' => 0,
                                            'september' => 0,
                                            'october' => 0,
                                            'november' => 0,
                                            'december' => $tax_amount,
                                            'january' => $tax_amount,
                                            'february' => $tax_amount,
                                            'march' => $tax_amount,
                                            'total_tax' => $total_income_tax_payable
                                        ];
    
                                        StaffTaxSeperation::updateOrCreate(
                                            ['staff_id' => $income->id, 'income_tax_id' => $income_info->id],
                                            $ins_tax
                                        );
                                        $income_info->update(['is_staff_calculation_done' => 'yes']);
                                    }
                                }
                            });
                        $message = 'Tax Lock Calculation locked Successfully';
                    } else {
                        ItStaffStatement::where('academic_id', $academicId)
                            ->update(['lock_calculation' => 'no', 'is_staff_calculation_done' => 'no']);
                        $message = 'Tax Lock Calculation unlocked Successfully';
                    }
                    $ins['tax_lock_calculation'] = $status;
                    break;
    
                default:
                    throw new \Exception('Invalid mode specified');
            }
    
            PayrollPermission::updateOrCreate(
                ['payout_month' => $payout_date, 'academic_id' => $academicId],
                $ins
            );
    
            return ['error' => 0, 'message' => $message];
    
        } catch (\Exception $e) {
            \Log::error('Error in setPermission function: ' . $e->getMessage());
            return ['error' => 1, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
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
        $ins['academic_id'] = academicYearId();
        $ins['institute_id'] = session()->get('staff_institute_id')??null;
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
        ini_set("max_execution_time", 0);
        ini_set('memory_limit', '-1');
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
        $resigned_or_retired = $this->checklistRepository->getResignedRetired($date);

        $is_entried_min_attendance = $leave_data['total_present'] ?? 0;

        $title = 'Payroll Process Confirmation';

        $params = array(
            'date' => $date,
            'payout_id' => $payout_id,
            'leave_data' => $leave_data??'',
            'title' => $title,
            'employee_data' => $employee_data,
            'income_tax_data' => $income_tax_data,
            'hold_salary_employee' => $hold_salary_employee,
            'is_entried_min_attendance' => $is_entried_min_attendance,
            'resigned_or_retired' => $resigned_or_retired
        );
        
        return view('pages.payroll_management.overview._payroll_form', $params);
    }

    public function setPayrollProcessing(Request $request)
    {
        ini_set("max_execution_time", 0);
        ini_set('memory_limit', '-1');
        $date = $request->date;
        $batchSize = 4000;
        $payout_id = $request->payout_id;
        $payroll_date = date('Y-m-d', strtotime($date . '-1 month'));
        $salary_month = date('F', strtotime($payroll_date));
        $salary_year = date('Y', strtotime($payroll_date));
        $month_length = date('t', strtotime($payroll_date));
        $total_net_pay = $request->total_net_pay;
        $working_day = $request->working_day;
        $month_start = date('Y-m-01', strtotime($payroll_date));
        $month_end = date('Y-m-t', strtotime($payroll_date));
        $working_day = date('t', strtotime($payroll_date));
        try {
        DB::transaction(function() use ($date,$payout_id,$payroll_date,$salary_month,$salary_year,$month_length,$total_net_pay,
        $working_day,$month_start,$month_end,$batchSize
        ) {
        $earings_field = SalaryField::where('salary_head_id', 1)
            ->where(function ($query) {
                $query->where('is_static', 'yes')
                    ->orWhere(function ($q) {
                        $q->where('nature_id', 3)
                            ->where('short_name', '!=', 'ARR');
                    });
            })
            ->orderBy('order_in_salary_slip')
            ->get();

        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes')
                    ->orWhere(function ($q) {
                        $q->where('nature_id', 3)
                            ->where('short_name', '!=', 'CONTRIBUTION')
                            ->where('short_name', '!=', 'OTHER');
                    });
            })
            ->get();

        $payout_data = $this->checklistRepository->getToPayEmployee($date);
       
        if (isset($payout_data) && count($payout_data)) {

            StaffSalary::where('payroll_id', $payout_id)->update(['status' => 'inactive']);
            $used_loans = [];
            $used_earnings = [];
            $used_deductions = [];
            $used_insurance = [];
            $ins=[];
            foreach ($payout_data as $key => $value) {

                $staff_info = User::find($value->id);
                $other_description = '';

                $gross = $value->currentSalaryPattern->gross_salary;
                $deductions = 0;
                $earnings = 0;
                $used_field_datas = [];
                if (isset($earings_field) && !empty($earings_field)) {
                    foreach ($earings_field as $eitem) {
                        $amounts = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $eitem->name, 'EARNINGS', $eitem->short_name);
                        $e_name = strtolower(Str::singular($eitem->short_name)) === 'bonus' ? 'bonus' : strtolower($eitem->short_name);
                        $other_earnings = getEarningInfo($value->id, $e_name, $date);
            
                        if (is_object($other_earnings) && isset($other_earnings->amount)) {
                            $amounts += $other_earnings->amount;
                        }
            
                        if ($amounts > 0) {
                            $used_fields[] = [
                                'percentage' => 0,
                                'staff_id' => $value->id,
                                'field_id' => $eitem->id,
                                'field_name' => $eitem->name,
                                'reference_type' => 'EARNINGS',
                                'reference_id' => 1,
                                'short_name' => $eitem->short_name,
                                'amount' => $amounts,
                            ];
                            $earnings += $amounts;
                            if (isset($other_earnings->amount) && $other_earnings->amount > 0) {
                                $used_earnings[] = array_merge(end($used_fields), [
                                    'earnings_type' => $e_name,
                                    'staff_id' => $value->id,
                                ]);
                            }
                        }
                    }
                }

                if (isset($deductions_field) && !empty($deductions_field)) {

                    foreach ($deductions_field as $sitem) {
                        $tmp = [
                            'field_id' => $sitem->id,
                            'field_name' => $sitem->name,
                            'reference_type' => 'DEDUCTIONS',
                            'reference_id' => 2,
                            'short_name' => $sitem->short_name,
                        ];
            
                        switch (strtolower(trim($sitem->short_name))) {
                            case 'it':
                                $deduct_amount = staffMonthTax($value->id, strtolower($salary_month));
                                break;
                            case 'other':
                                $other_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                $leave_amount_day = getStaffLeaveDeductionAmount($value->id, $date) ?? 0;
                                $leave_amount = $leave_amount_day ? getDaySalaryAmount($gross, $month_length) * $leave_amount_day : 0;
                                $deduct_amount = $other_amount + $leave_amount;
                                break;
                            case 'bank loan':
                                $bank_loan_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                $other_bank_loan_amount = getBankLoansAmount($value->id, $date);
                                $bank_loan_amount += $other_bank_loan_amount['total_amount'] ?? 0;
                                if (!empty($other_bank_loan_amount['emi'])) {
                                    $used_loans[] = $other_bank_loan_amount['emi'];
                                }
                                $deduct_amount = $bank_loan_amount;
                                break;
                            case 'lic':
                                $insurance_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                $other_insurance_amount = getInsuranceAmount($value->id, $date);
                                $insurance_amount += $other_insurance_amount['total_amount'] ?? 0;
                                if (!empty($other_insurance_amount['emi'])) {
                                    $used_insurance[] = $other_insurance_amount['emi'];
                                }
                                $deduct_amount = $insurance_amount;
                                break;
                            default:
                                $deduct_amount = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                $other_deductions = getDeductionInfo($value->id, strtolower(Str::singular($sitem->short_name)), $date);
                                $deduct_amount += isset($other_deductions->amount) ? $other_deductions->amount : 0;
                                break;
                        }
            
                        if ($deduct_amount > 0) {
                            $tmp['amount'] = $deduct_amount;
                            $used_fields[] = $tmp;
                            $deductions += $deduct_amount;
                            if (isset($other_deductions->amount) && $other_deductions->amount > 0) {
                                $used_deductions[] = array_merge($tmp, [
                                    'staff_id' => $value->id,
                                    'deduction_type' => strtolower(Str::singular($sitem->short_name)),
                                ]);
                            }
                        }
                    }
                }
                $net_pay = $earnings - $deductions;
                if (!empty($used_fields)) {
                  
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
                    $sal['salary_date'] = $payroll_date;
                    $sal['salary_no'] =  salaryNo();
                    $sal['total_earnings'] = $earnings;
                    $sal['total_deductions'] = $deductions;
                    $sal['gross_salary'] = $earnings;
                    $sal['net_salary'] = $net_pay;
                    $sal['is_salary_processed'] = 'yes';
                    $sal['status'] = 'inactive';
                    $sal['salary_processed_on']= date('Y-m-d H:i:s');
                    $ins[]=$sal;
                }
            }
        }   
            $chunks = array_chunk($ins, $batchSize);
            foreach ($chunks as $chunk1) {
                foreach ($chunk1 as $item) {
                    StaffSalary::updateOrCreate(
                        [
                            'staff_id' => $item['staff_id'],
                            'payroll_id' => $item['payroll_id'],
                        ],
                        $item
                    );
                }
            }
            $chunks1 = array_chunk($used_fields, $batchSize);

            foreach ($chunks1 as $chunk) {   
            foreach ($chunk as $key=>$pay_items) {  
            if(isset($pay_items['staff_id'])){
            $sallary_f_id=StaffSalary::where('staff_id',$pay_items['staff_id'])->where('payroll_id',$payout_id)->first();
            $pay_items['staff_salary_id']=$sallary_f_id->id;
            StaffSalaryField::updateOrCreate($pay_items,['staff_id'=>$pay_items['staff_id'],'staff_salary_id'=>$pay_items['staff_salary_id']]);
            }
            }
            }
            });
        }
       
        catch (\Throwable $e) {
          dd($e);
        }
        return redirect()->route('payroll.set.processing.id', ['id' => $payout_id]);
    }


        public function setPayrollProcessingBYId(Request $request,$id)
        {
            ini_set("max_execution_time", 0);
            ini_set('memory_limit', '-1');
            $payroll_info = Payroll::find($id);
            $date = $payroll_info->from_date;
            $payout_id = $payroll_info->id;
            $payroll_points = $request->payroll_points??[];
            $process_it =  $payroll_info->id;
            $payroll_date = $payroll_info->payroll_date;
            $month_start =$payroll_info->from_date;
            $month_end =$payroll_info->to_date;
            $total_net_pay = $request->total_net_pay ?? '';
            $salary_month = date('F', strtotime($payroll_date));
            $salary_year = date('Y', strtotime($payroll_date));
            $working_day = date('t', strtotime($payroll_date));
            $month = date('F', strtotime($date));
            $month_length = date('t', strtotime($payroll_date));
        
            $payout_data = $this->checklistRepository->getToPayEmployee($date);
            $earings_field = SalaryField::where('salary_head_id', 1)
                ->where(function ($query) {
                    $query->where('is_static', 'yes');
                    $query->orWhere(function ($q) {
                        $q->where('nature_id', 3);
                        $q->where('short_name', '!=', 'ARR');
                    });
                })
                ->orderBy('order_in_salary_slip')
                ->get();

            $deductions_field = SalaryField::where('salary_head_id', 2)
                ->where(function ($query) {
                    $query->where('is_static', 'yes');
                    $query->orWhere(function ($q) {
                        $q->where('nature_id', 3);
                        $q->where('short_name', '!=', 'CONTRIBUTION');
                        $q->where('short_name', '!=', 'OTHER');
                    });
        })->get();
                $employee_nature = NatureOfEmployment::where('status', 'active')->get();
                $employees = User::where('status', 'active')->orderBy('name', 'asc')->get();
                $salary_infos = StaffSalary::where('payroll_id', $payout_id)
                ->get();
                $total_pay = StaffSalary::where('payroll_id', $payout_id)->select('net_salary')
                ->sum('net_salary');
            $params = [
                'earings_field' => $earings_field,
                'deductions_field' => $deductions_field,
                'salary_info' => $salary_infos,
                'date' => $date,
                'payout_id' => $payout_id,
                'payroll_points' => $payroll_points,
                'process_it' => $process_it,
                'payout_data' => $payout_data,
                'working_day' => date('d', strtotime($month_end)),
                'payroll_date' => $payroll_date,
                'total_pay'=>$total_pay??0
            ];
            
            return view('pages.payroll_management.overview._payroll_process', $params);
        }
     
     /**
         * 1. Need to generate salary pdf for every staff
         * 2. Make entries in database         
         * 3. Make Payroll Log for payroll generation History
         */
        public function continuePayrollProcessing(Request $request)
        {
            ini_set("max_execution_time", 0);
            ini_set('memory_limit', '-1');
        
            $payout_id = $request->payout_id;
            $date = $request->date;
            $month_length = date('t', strtotime($date . '-1 month'));
            $month = date('F', strtotime($date));
            $payroll_info = Payroll::find($payout_id);
            $payout_data = $this->checklistRepository->getToPayEmployee($date);
        
            if (empty($payout_data)) {
                return ['error' => '1', 'message' => 'Error occurred while generating payroll', 'payout_id' => $payout_id];
            }
                    $earnings_field = SalaryField::where('salary_head_id', 1)
                    ->where(function ($query) {
                        $query->where('is_static', 'yes');
                        $query->orWhere(function ($q) {
                            $q->where('nature_id', 3);
                            $q->where('short_name', '!=', 'ARR');
                        });
                    })
                    ->orderBy('order_in_salary_slip')
                    ->get();

                $deductions_field = SalaryField::where('salary_head_id', 2)
                    ->where(function ($query) {
                        $query->where('is_static', 'yes');
                        $query->orWhere(function ($q) {
                            $q->where('nature_id', 3);
                            $q->where('short_name', '!=', 'CONTRIBUTION');
                            $q->where('short_name', '!=', 'OTHER');
                        });
                })->get();
        
        
            foreach ($payout_data as $value) {
                $other_bank_loan_amount = getBankLoansAmount($value->id, $date);
                if (!empty($other_bank_loan_amount['emi'])) {
                    $used_loans[] = $other_bank_loan_amount['emi'];
                }
                if (!empty($used_loans)) {
                    $staff_loan_id = [];
                    foreach ($used_loans as $loan_items) {
                        if (isset($loan_items['details']) && !empty($loan_items['details'])) {

                            $info = StaffLoanEmi::find($loan_items['details']->id);
                            $info->status = 'paid';
                            $info->save();
                            $staff_loan_id[]  = $loan_items['details']->staff_loan_id;
                        }
                    }
                    /**
                     * 1. For case 1 loan paid by all month
                     * 2. If loan close by half duration - need to do 
                     */
                    if (!empty($staff_loan_id)) {
                        $staff_loan_id = array_unique($staff_loan_id);
                        foreach ($staff_loan_id as $loan_ids) {
                            $loan_info = StaffBankLoan::with('paid_emi')->find($loan_ids);
                            if ($loan_info && $loan_info->period_of_loans == $loan_info->paid_emi()->count()) {
                                $loan_info->status = 'completed';
                                $loan_info->save();
                            }
                        }
                    }
                }
                $other_insurance_amount = getInsuranceAmount($value->id, $date);
                if (!empty($other_insurance_amount['emi'])) {
                    $used_insurance[] = $other_insurance_amount['emi'];
                }
                if (!empty($used_insurance)) {
                    $staff_ins_id = [];
                    foreach ($used_insurance as $loan_items) {
                        if (isset($loan_items['details']) && !empty($loan_items['details'])) {

                            $info = StaffInsuranceEmi::find($loan_items['details']->id);
                            $info->status = 'paid';
                            $info->save();

                            $staff_ins_id[]  = $loan_items['details']->staff_ins_id;
                        }
                    }
                    /**
                     * 1. For case 1 loan paid by all month
                     * 2. If loan close by half duration - need to do 
                     */
                    if (!empty($staff_ins_id)) {
                        $staff_ins_id = array_unique($staff_ins_id);
                        foreach ($staff_ins_id as $loan_ids) {
                            $loan_info = StaffInsurance::with('paid_emi')->find($loan_ids);
                            if ($loan_info && $loan_info->period_of_loans == $loan_info->paid_emi()->count()) {
                                $loan_info->status = 'completed';
                                $loan_info->save();
                            }
                        }
                    }
                }
                $salary_info = StaffSalary::where('payroll_id', $payout_id)->where('staff_id', $value->id)->first();
                if ($salary_info) {
                $used_earnings=StaffSalaryField::where('staff_salary_id',$salary_info->id)->where('staff_id',$value->id)->where('reference_type','EARNINGS')->get();
                if( !empty( $used_earnings ) ) {
                    foreach( $used_earnings as $earn ) {

                        $earn_info = StaffSalaryPreEarning::where('salary_month', $date)
                                ->where('earnings_type', $earn['field_name'])
                                ->where('academic_id', academicYearId())
                                ->where('staff_id', $earn['staff_id'])
                                ->first();

                        if( $earn_info ) {
                            $earn_info->status = 'paid';
                            $earn_info->save();
                        }
                        
                    }   
                }

                $used_deductions=StaffSalaryField::where('staff_salary_id',$salary_info->id)->where('staff_id',$value->id)->where('reference_type','DEDUCTIONS')->get();
                if( !empty( $used_deductions ) ) {
                    foreach( $used_deductions as $earn ) {

                        $deduct_info = StaffSalaryPreDeduction::where('salary_month', $date)
                                ->where('deduction_type', $earn['field_name'])
                                ->where('academic_id', academicYearId())
                                ->where('staff_id', $earn['staff_id'])
                                ->first();

                        if( $deduct_info ) {
                            $deduct_info->status = 'paid';
                            $deduct_info->save();
                        }
                        
                    }   
                }
                
               
                    $salary_info->update([
                        'is_salary_processed' => 'yes',
                        'status' => 'active',
                        'salary_processed_on' => now()
                    ]);
                }
            }
        
            $payroll_info->update(['payroll_date' => now()]);
            return ['error' => '0', 'message' => 'Payroll processed successfully!', 'payout_id' => $payout_id];
        }
        
    public function payrollStatementById(Request $request,$id)
    {
        $info = Payroll::find($id);
        $error = '0';
        $message = 'Payroll processed successfully!';
        $params = [
            'info' => $info
        ];

        return view('pages.payroll_management.overview._ajax_success_payroll', $params);
    }
    public function payrollStatement(Request $request)
    {
        ini_set("max_execution_time", 0);
        ini_set('memory_limit', '-1');
        $id = $request->id;
        $payroll_info = Payroll::find($id);
        $payroll_id = $id;
        $staff_id = $request->staff_id;
        $employee_nature = NatureOfEmployment::where('status', 'active')->get();
        $employees = User::where('status', 'active')->orderBy('name', 'asc')->get();
        $earings_field = SalaryField::where('salary_head_id', 1)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere(function ($q) {
                    $q->where('nature_id', 3);
                    $q->where('short_name', '!=', 'ARR');
                });
            })
            ->orderBy('order_in_salary_slip')
            ->get();
        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere(function ($q) {
                    $q->where('nature_id', 3);
                    $q->where('short_name', '!=', 'CONTRI');
                    $q->where('short_name', '!=', 'OTHER');
                });
            })->get();
        $salary_info = StaffSalary::where('payroll_id', $payroll_id)
            ->when(!empty($staff_id), function ($query) use ($staff_id) {
                $query->where('staff_id', $staff_id);
            })
            ->where('status', 'active')
            ->get();
        $params = [
            'employees' => $employees,
            'payroll_info' => $payroll_info,
            'employee_nature' => $employee_nature,
            'earings_field' => $earings_field,
            'deductions_field' => $deductions_field,
            'salary_info' => $salary_info
        ];
  

        return view('pages.payroll_management.overview.statement.index', $params);
    }

    public function payrollStatementList(Request $request)
    {
        ini_set("max_execution_time", 0);
        ini_set('memory_limit', '-1');
        $earings_field = SalaryField::where('salary_head_id', 1)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere(function ($q) {
                    $q->where('nature_id', 3);
                    $q->where('short_name', '!=', 'ARR');
                });
            })
            ->orderBy('order_in_salary_slip')
            ->get();

        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere(function ($q) {
                    $q->where('nature_id', 3);
                    $q->where('short_name', '!=', 'CONTRI');
                    $q->where('short_name', '!=', 'OTHER');
                });
            })->get();
 

        $payroll_id = $request->payroll_id;
        $staff_id = $request->staff_id;
        // $nature_id = $request->nature_id;

        $salary_info = StaffSalary::where('payroll_id', $payroll_id)
            ->when(!empty($staff_id), function ($query) use ($staff_id) {
                $query->where('staff_id', $staff_id);
            })
            ->where('status', 'active')
            ->get();

        $params = [
            'earings_field' => $earings_field,
            'deductions_field' => $deductions_field,
            'salary_info' => $salary_info
        ];

        return view('pages.payroll_management.overview.statement._list', $params);
    }

    public function exportStatement(Request $request)
    {
        ini_set("max_execution_time", 0);
        ini_set('memory_limit', '-1');
        $payroll_id = $request->payroll_id;
        $staff_id = $request->staff_id;

        return Excel::download(new PayrollStatementExport($payroll_id, $staff_id), 'payroll_statement.xlsx');
    }
    public function payrollTempExport(Request $request)
    {   
        ini_set("max_execution_time", 0);
        ini_set('memory_limit', '-1');

        $date = $request->date;
        $payout_id = $request->payout_id;
        $payroll_points = $request->payroll_points;
        $process_it = $request->process_it;
        $payroll_date = date('Y-m-d', strtotime($date . '-1 month'));
        $month_start = date('Y-m-01', strtotime($payroll_date));
        $month_end = date('Y-m-t', strtotime($payroll_date));
        $payout_data = $this->checklistRepository->getToPayEmployee($date);
       // return Excel::download(new PayrollStatementExport($payout_id,''), 'payroll_statement.xlsx');

        return Excel::download(new PayrollTempExport($payout_data,$date,$payout_id,$payroll_date,$month_start,$month_end), 'payroll__temp_statement.xlsx');
    }
}
