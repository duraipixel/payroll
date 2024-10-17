<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\PayrollManagement\StaffSalaryField;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\PayrollManagement\StaffSalaryPatternFieldHistory;
use App\Models\PayrollManagement\StaffSalaryPatternHistory;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\Payroll;
use App\Models\PayrollManagement\PayrollPermission;
use App\Http\Controllers\PayrollManagement\OverviewController;
use App\Models\Staff\StaffTaxSeperation;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Repositories\TaxCalculationRepository;
use App\Repositories\PayrollChecklistRepository;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\Staff\StaffInsuranceEmi;
use App\Models\Staff\StaffLoanEmi;
use App\Models\Staff\StaffSalaryPreDeduction;
use App\Models\Staff\StaffSalaryPreEarning;
use DB;
use Illuminate\Support\Str;
use App\Models\PayrollManagement\StaffSalary;
class PayrollImport implements ToCollection,WithHeadingRow
{
    public $collection;

    public function collection(Collection $rows)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
    //     DB::transaction(function() use ($rows
    //     ) {
        //StaffSalaryPattern::update(["is_current"=>'no']);
    //   foreach($rows as $row){
      
    //     $dateTime = Date::excelToDateTimeObject($row["effective_from"]);
    //     $date=$dateTime->format('Y-d-m');
    //     $staff=User::where('institute_emp_code',$row["inst_emp_code"])->first();
    //     if(isset( $staff)){
    //     $insert_data['staff_id'] = $staff->id;
    //     $insert_data['salary_no'] = date('ymdhis');
    //     $insert_data['total_earnings'] =(int)$row["gross"];
    //     $insert_data['total_deductions'] = (int)$row["ded"];
    //     $insert_data['gross_salary'] =(int)$row["gross"];
    //     $insert_data['net_salary'] = (int)$row["net"];
    //     $insert_data['is_salary_processed'] = 'no';
    //     $insert_data['status'] = 'active';
    //     $insert_data['effective_from'] = date('Y-m-d', strtotime($date));
    //     $insert_data['employee_remarks'] = $row["remarks"] ?? NULl;
    //     $insert_data['remarks'] = $row["remarks"] ?? NULL;
    //     $insert_data['payout_month'] = date('Y-m-d', strtotime($date));
    //      $insert_data['salary_month'] =date('Y-m-d', strtotime($date));
    //     // $insert_data['salary_year'] = date('Y', strtotime($date));
    //     $insert_data['verification_status'] = 'approved';
    //     $insert_data['is_current'] = 'yes';
    //     $insert_data['institute_id']=$staff->institute_id;
    //     $insert_data['addedBy'] = 1;
        
    //     $salary_info = StaffSalaryPattern::updateOrCreate(['staff_id' => $staff->id,'payout_month'=>date('Y-m-d', strtotime($date))], $insert_data);
    //     $history_info = StaffSalaryPatternHistory::create($insert_data);
    //     /**
    //      * update status in it statements
    //      */

    //     $ins = [
    //     'Basic' => $row['basic'],
    //     'DA' => $row['basicda'],
    //     'HRA' => $row['hra'],
    //     'TA' => $row['ta'],
    //     'PBA' => $row['pba'],
    //     'PBADA' => $row['pbada'],
    //     'DSA' => $row['dsa'],
    //     'MNA' => $row['mna'],
    //     'Arrear' => $row['arr'],
    //     'EPF' => $row['epf'],
    //     'ESI' => $row['esi'],
    //     'LIC' => $row['lic'],
    //     'Bank Loan' => $row['bankl'],
    //     'Loan' => $row['loan'],
    //     'Contribution' => $row['contri'],
    //     'IT' => $row['itax'],
    //     'Other' => $row['other'],
    //     ];

      
    //     foreach ($ins as $key=>$items_pay) {
    //         if($key=="Arrear"){
    //             $field=SalaryField::where('short_name','like',"%{$key}%")->where('salary_head_id',1)->first();
    //         }else{
    //             $field=SalaryField::where('short_name','like',"%{$key}%")->first();
    //         }
    //         if(isset($staff->id) && isset($field)){
    //         $field_data['staff_id'] = $staff->id;
    //         $field_data['staff_salary_pattern_id'] = $salary_info->id;
    //         $field_data['field_id'] = $field->id;
    //         $field_data['field_name'] = $field->name;
    //         $field_data['amount'] =(int)$items_pay;
    //         $field_data['percentage'] =0;
    //         $field_data['reference_type'] = ($field->salary_head_id==1)? 'EARNINGS': 'DEDUCTIONS';
    //         $field_data['reference_id'] =$field->salary_head_id;
    //          StaffSalaryPatternField::updateOrCreate(['staff_id' => $staff->id,'staff_salary_pattern_id'=> $salary_info->id,'field_name'=>$field->name],$field_data);
    //         $field_data['staff_salary_pattern_id'] = $history_info->id;
    //         StaffSalaryPatternFieldHistory::create($field_data);
    //         }
    //      }
        
    //     }
    //   }
    //   });
      $dateTime = Date::excelToDateTimeObject($rows[0]["payroll_from"]);
      $date=$dateTime->format('Y-d-m');
      $payroll_date = $date;
      $from_date = date('Y-m-01', strtotime($payroll_date));
      $to_date = date('Y-m-t', strtotime($payroll_date));

      $ins['from_date'] = $from_date;
      $ins['to_date'] = $to_date;
      $ins['name'] = date('F Y', strtotime($from_date));
      $ins['locked'] = 'no';
      $ins['added_by'] = auth()->id();
      $ins['academic_id'] = academicYearId();
      $ins['institute_id'] = session()->get('staff_institute_id')??null;
      $payroll = Payroll::updateOrCreate(['from_date'=>$from_date],$ins);
    
      $ins_roll['academic_id'] = academicYearId();
      $ins_roll['payout_month'] = $from_date;
      $ins_roll['payroll_id'] = $payroll->id;
      $ins_roll['payroll_inputs'] = 'unlock';
      $ins_roll['emp_view_release'] = 'lock';
      $ins_roll['it_statement_view'] = 'lock';
      $ins_roll['payroll'] = 'unlock';
      $academicId = academicYearId();
      PayrollPermission::updateOrCreate(['payroll_id'=>$payroll->id],$ins_roll);
      User::where('institute_id', session()->get('staff_institute_id'))
            ->where('status', 'active')
            ->where('verification_status', 'approved')
            ->where('transfer_status', 'active')
            ->chunk(100, function($incomes) use ($ins,$academicId) {
            
                foreach ($incomes as $income) {
                    $income_data = ItStaffStatement::where('academic_id',academicYearId())->where('staff_id',$income->id)->first();
                    if(empty($income_data)){
                      $taxRepo = new TaxCalculationRepository();
                      $result = $taxRepo->generateStatementForStaff($income->id);
                    }
                    $income_info = ItStaffStatement::where('academic_id',academicYearId())->where('staff_id',$income->id)->first();
                    if (isset($income_info) ){
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
                ini_set("max_execution_time", 0);
                ini_set('memory_limit', '-1');
                $date = $date;
                $batchSize = 4000;
                $payout_id = $payroll->id;
                $payroll_date = date('Y-m-d', strtotime($date . '-1 month'));
                $salary_month = date('F', strtotime($payroll_date));
                $salary_year = date('Y', strtotime($payroll_date));
                $month_length = date('t', strtotime($payroll_date));
                $total_net_pay = 0;

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
                    
                    $payCheck = new PayrollChecklistRepository();
                    $payout_data = $payCheck->getToPayEmployee($date);
                    // dd($payout_data);
                if (isset($payout_data) && count($payout_data)) {
        
                    StaffSalary::where('payroll_id', $payout_id)->update(['status' => 'inactive']);
                    $ins=[];
                    foreach ($payout_data as $key => $value) {
                        $staff_info = User::find($value->id);
                        if (isset($value->currentSalaryPattern->id) && !empty($value->currentSalaryPattern->id)) {
                            $pattern=StaffSalaryPattern::find($value->currentSalaryPattern->id);
                        
                        
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
                            $sal['other_description'] = NUll;
                            $sal['salary_date'] = $payroll_date;
                            $sal['salary_no'] =  salaryNo();
                            $sal['total_earnings'] = $pattern->total_earnings;
                            $sal['total_deductions'] = $pattern->total_deductions;
                            $sal['gross_salary'] = $pattern->gross_salary;
                            $sal['net_salary'] = $pattern->net_salary;
                            $sal['is_salary_processed'] = 'yes';
                            $sal['status'] = 'active';
                            $sal['salary_processed_on']= date('Y-m-d H:i:s');
                            $ins[]=$sal;
                            $sallary_f_id=StaffSalary::updateOrCreate(
                              [
                                  'staff_id' => $staff_id,
                                  'payroll_id' => $payout_id,
                              ],
                              $sal
                          );
                          if (isset($earings_field) && !empty($earings_field)) {
                         
                            foreach ($earings_field as $eitem) {
                                $amounts = getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $eitem->name, 'EARNINGS', $eitem->short_name);
                                if (isset($amounts)) {
                                    $used_fields= [
                                        'percentage' => 0,
                                        'staff_id' => $value->id,
                                        'field_id' => $eitem->id,
                                        'field_name' => $eitem->name,
                                        'reference_type' => 'EARNINGS',
                                        'reference_id' => 1,
                                        'short_name' => $eitem->short_name,
                                        'staff_salary_id'=>$sallary_f_id->id,
                                        'amount' => $amounts,
                                    ];
                                    StaffSalaryField::updateOrCreate($used_fields,['staff_id'=>$staff_id,'staff_salary_id'=>$sallary_f_id->id,'field_id'=> $used_fields['field_id']]);
                                }
                            }
                        }
        
                        if (isset($deductions_field) && !empty($deductions_field)) {
                            foreach ($deductions_field as $sitem) {
                                $tmp= [
                                    'percentage' => 0,
                                     'staff_id' => $value->id,
                                    'field_id' => $sitem->id,
                                    'field_name' => $sitem->name,
                                    'reference_type' => 'DEDUCTIONS',
                                    'reference_id' => 2,
                                    'short_name' => $sitem->short_name,
                                    'staff_salary_id'=>$sallary_f_id->id,
                                    'amount'=> getStaffPatterFieldAmount($value->id, $value->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS') ?? 0
                                ];
                                StaffSalaryField::updateOrCreate($tmp,['staff_id'=>$staff_id,'staff_salary_id'=>$sallary_f_id->id,'field_id'=> $tmp['field_id']]);
                            }
                        }
                         
                        }
                      }
                    }
                });
                }
              
                catch (\Throwable $e) {
                  dd($e);
                }
                return true;
            
            

    }
 
  
}
