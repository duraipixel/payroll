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
class PayrollImport implements ToCollection,WithHeadingRow
{
    public $collection;

    public function collection(Collection $rows)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
      foreach($rows as $row){
      
        $dateTime = Date::excelToDateTimeObject($row["effective_from"]);
        $date=$dateTime->format('Y-d-m');
        $staff=User::where('institute_emp_code',$row["inst_emp_code"])->first();
        if(isset( $staff)){
        $insert_data['staff_id'] = $staff->id;
        $insert_data['salary_no'] = date('ymdhis');
        $insert_data['total_earnings'] =(int)$row["gross"];
        $insert_data['total_deductions'] = (int)$row["ded"];
        $insert_data['gross_salary'] =(int)$row["gross"];
        $insert_data['net_salary'] = (int)$row["net"];
        $insert_data['is_salary_processed'] = 'no';
        $insert_data['status'] = 'active';
        $insert_data['effective_from'] = date('Y-m-d', strtotime($date));
        $insert_data['employee_remarks'] = $row["remarks"] ?? NULl;
        $insert_data['remarks'] = $row["remarks"] ?? NULL;
        $insert_data['payout_month'] = date('Y-m-d', strtotime($date));
         $insert_data['salary_month'] =date('Y-m-d', strtotime($date));
        // $insert_data['salary_year'] = date('Y', strtotime($date));
        $insert_data['verification_status'] = 'approved';
        $insert_data['is_current'] = 'yes';
        $insert_data['institute_id']=$staff->institute_id;
        $insert_data['addedBy'] = 1;
        
        $salary_info = StaffSalaryPattern::updateOrCreate(['staff_id' => $staff->id,'payout_month'=>date('Y-m-d', strtotime($date))], $insert_data);
        $history_info = StaffSalaryPatternHistory::create($insert_data);
        /**
         * update status in it statements
         */

        $ins = [
        'Basic' => $row['basic'],
        'Basic DA' => $row['basicda'],
        'HRA' => $row['hra'],
        'TA' => $row['ta'],
        'PBA' => $row['pba'],
        'PBADA' => $row['pbada'],
        'DSA' => $row['dsa'],
        'MNA' => $row['mna'],
        'Arrears' => $row['arr'],
        'EPF' => $row['epf'],
        'ESI' => $row['esi'],
        'LIC' => $row['lic'],
        'Bank Loan' => $row['bankl'],
        'Loan' => $row['loan'],
        'Contribution' => $row['contri'],
        'IT' => $row['itax'],
        'Other' => $row['other'],
        ];
        foreach ($ins as $key=>$items_pay) {
            $field=SalaryField::where('short_name','like',"%{$key}%")->first();
            if(isset($staff->id) && isset($field)){
            $field_data['staff_id'] = $staff->id;
            $field_data['staff_salary_pattern_id'] = $salary_info->id;
            $field_data['field_id'] = $field->id;
            $field_data['field_name'] = $field->name;
            $field_data['amount'] =(int)$items_pay;
            $field_data['percentage'] =0;
            $field_data['reference_type'] = ($field->salary_head_id==1)? 'EARNINGS': 'DEDUCTIONS';
            $field_data['reference_id'] =$field->salary_head_id;
            $salary_info=StaffSalaryPatternField::updateOrCreate(['staff_id' => $staff->id,'staff_salary_pattern_id'=> $salary_info->id],$field_data);
            $field_data['staff_salary_pattern_id'] = $history_info->id;
            StaffSalaryPatternFieldHistory::create($field_data);
            }
        }
        }
      }
    }
 
  
}
