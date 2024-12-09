<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DB;
use Illuminate\Support\Str;
use App\Models\Staff\StaffBankLoan;
use App\Models\Master\Bank;
use App\Models\Staff\StaffLoanEmi;
class PayrollLoanImport implements ToCollection,WithHeadingRow
{
    public $collection;

    public function collection(Collection $rows)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
          //dd($rows);
       DB::transaction(function() use ($rows) {
       foreach($rows as $row){
         $staff=User::where('institute_emp_code',$row["inst_emp_code"])->first();
         if(isset($staff) && isset($row['loan_type'])){
           $staff_id = $staff->id;
           $bank_info = Bank::where('name', 'LIKE',"%{$row['bank']}%")->first();
    
           $ins['staff_id'] = $staff_id;
           $ins['bank_id'] = $bank_info->id;
           $ins['bank_name'] = $bank_info->name;
           $ins['ifsc_code'] = $row['ifsc_code'];
           $ins['loan_ac_no'] = $row['acc_no'];
           $ins['loan_type'] = $row['staff_loan_type'];
           $ins['loan_due'] =  $row['loan_type'];
           $ins['every_month_amount'] =  $row['pay_amount'];
           $ins['loan_amount'] =  $row['loan_amount'];
           $ins['period_of_loans'] =  $row['loan_period'];
           $ins['status'] = 'active';
           if ($row['loan_start_date']) {
              $dateTime = Date::excelToDateTimeObject($row["loan_start_date"]);
              $loan_start_date=$dateTime->format('Y-d-m');
               $ins['loan_start_date'] = $loan_start_date;
           }
           if ( $row['loan_end_date']) {
                $dateTime1 = Date::excelToDateTimeObject($row["loan_end_date"]);
                $loan_end_date=$dateTime1->format('Y-d-m');
               $ins['loan_end_date'] = $loan_end_date;
           }

           $loan_info = StaffBankLoan::updateOrCreate(['staff_id' => $staff_id,'loan_amount'=>$row['loan_amount']], $ins);
           if(isset($row['loan_type']) &&  $row['loan_type']=="fixed"){
            $emi_details = [];
            if ($loan_start_date && $row['loan_period']) {
                for ($i = 0; $i < $row['loan_period']; $i++) {
                    $emi_details[] = array(
                        's_no' => $i + 1,
                        'emi_month' => date('Y-m-d', strtotime($loan_start_date . '+' . $i . 'month')),
                        'emi_amount' => $row['pay_amount']
                    );
                }
            }
                  if (isset($emi_details) && count($emi_details) > 0) {
                    StaffLoanEmi::where('staff_loan_id', $loan_info->id)->update(['status' => 'inactive']);
                    foreach($emi_details as $emi_detail){
                        $emi_date=date('Y-m-d', strtotime($emi_detail["emi_month"]));
                        $check_date = date('Y-m-01', strtotime($emi_date));
                        $ins = [];
                        $ins['staff_id'] = $staff_id;
                        $ins['staff_loan_id'] = $loan_info->id;
                        $ins['emi_date'] = $emi_date;
                        $ins['emi_month'] = $check_date;
                        $ins['amount'] = $emi_detail['emi_amount'] ?? 0;
                        $ins['loan_mode'] = $row['loan_type'];
                        $ins['loan_type'] = 'Bank Loan';
                        $ins['status'] = 'active';
 
                        StaffLoanEmi::updateOrCreate(['staff_loan_id' => $loan_info->id, 'emi_date' => $emi_date], $ins);
                    }
                    }
           }else{
            $emi_detailes = $rows->filter(function ($item) use ($row) {
                return $item['type'] === 'child' && $item['type_id'] === $row['type_id'];
            });
           
            
            if (isset($emi_detailes)  && count($emi_detailes) > 0) {
                StaffLoanEmi::where('staff_loan_id', $loan_info->id)->update(['status' => 'inactive']);
                foreach($emi_detailes as $emi_detail){

                       $date =Date::excelToDateTimeObject($emi_detail["loan_start_date"]);
                       $emi_date=$date->format('Y-d-m');
                       $check_date = date('Y-m-01', strtotime($emi_date));
                       $ins = [];
                       $ins['staff_id'] = $staff_id;
                       $ins['staff_loan_id'] = $loan_info->id;
                       $ins['emi_date'] = $emi_date;
                       $ins['emi_month'] = $check_date;
                       $ins['amount'] = $emi_detail['pay_amount'] ?? 0;
                       $ins['loan_mode'] = $row['loan_type'];
                       $ins['loan_type'] = 'Bank Loan';
                       $ins['status'] = 'active';

                       StaffLoanEmi::updateOrCreate(['staff_loan_id' => $loan_info->id, 'emi_date' => $emi_date], $ins);
                   }
                }
           }
            
         }
         }
        });
        return true;
            
            

    }
 
  
}
