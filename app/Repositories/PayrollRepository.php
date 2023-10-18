<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollRepository
{

    public function generateSalarySlip($data)
    {

        $info=StaffSalary::with('staff.familyMembers','staff.pancard','staff.pf','staff.esi','staff.position','staff.appointment','fields','staff.leavesApproved')->find($data->id);
        $date_string = $info->salary_year . '-' . $info->salary_month . '-01';
        $date = date('d/M/Y', strtotime($date_string));

        $params = [
            'institution_name' => $info->staff->institute->name ?? '',
            'institution_address' => $info->staff->institute->address ?? '',
            'pay_month' => 'Pay Slip for the month of ' . $info->salary_month . '-' . $info->salary_year,
            'info' => $info,
            'date' => $date
        ];

        foreach($info->fields as $field){
            if($field->field_name=="Basic Pay"){
                $params['basic_pay']=$field->amount;
            }
            if($field->field_name=="Dearness Allowance"){
                $params['dearness']=$field->amount;
            }
            if($field->field_name=="House Rent Allowance"){
                $params['house_rent']=$field->amount;
            }
            if($field->field_name=="Traveling Allowance"){
                $params['traveling']=$field->amount;
            }
            if($field->field_name=="Performance Based Allowance Dearness Allowance"){
                $params['performance']=$field->amount;
            }
            if($field->field_name=="Dedication & Sincerity Allowance"){
                $params['dedication']=$field->amount;
            }
            if($field->field_name=="Medical & Nutrition Allowance"){
                $params['medical']=$field->amount;
            }
            if($field->field_name=="Income Tax"){
                $params['income_tax']=$field->amount;
            }
            if($field->field_name=="Employee Provident Fund"){
                $params['pf']=$field->amount;
            }
            if($field->field_name=="Bank Loan"){
                $params['bank_loan']=$field->amount;
            }
            if($field->field_name=="Life Insurance Corporation"){
                $params['insurance']=$field->amount;
            }
            if($field->field_name=="OTHER LOAN"){
                $params['loan']=$field->amount;
            }
            if($field->field_name=="Performance Based Allowance"){
                $params['performance_allowance']=$field->amount;
            }
            if($field->field_name=="Professional Tax"){
                $params['p_tax']=$field->amount;
            }
            if($field->field_name=="Contributions"){
                $params['contributions']=$field->amount;
            }
            if($field->field_name=="Arrears"){
                $params['arrears']=$field->amount;
            }
            if($field->field_name=="Others"){
                $params['others']=$field->amount;
            }
        }
         foreach($info->staff->leavesApproved as $leave){
            $params['casual']=0;
            $params['earned']=0;
            $params['maternity']=0;
            $params['granted']=0;
        if($leave->leave_category=="Casual Leave"){
          $params['casual']+=$leave->granted_days;
         }
         if($leave->leave_category=="Earned Leave"){
          $params['earned']+=$leave->granted_days;
         }
         if($leave->leave_category=="Maternity Leave"){
          $params['maternity']+=$leave->granted_days;
         }
         if($leave->leave_category=="Granted Leave"){
          $params['granted']+=$leave->granted_days;
         }

        }

        $file_name = time() .'_'. $info->staff->institute_emp_code . '.pdf';

        $directory              = 'public/salary/' . $date_string;
        $filename               = $directory . '/' . $file_name;
        $pdf = Pdf::loadView('pages.payroll_management.overview.statement._auto_gen_pdf', $params)->setPaper('a4', 'portrait');
        Storage::put($filename, $pdf->output());
        return $filename;

    }

}
