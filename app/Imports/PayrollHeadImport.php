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
use App\Models\Staff\StaffSalaryPreDeduction;
use App\Models\Staff\StaffSalaryPreEarning;
class PayrollHeadImport implements ToCollection,WithHeadingRow
{
    public $collection;

    public function collection(Collection $rows)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

       DB::transaction(function() use ($rows) {
       foreach($rows as $row){
         $staff=User::where('institute_emp_code',$row["inst_emp_code"])->first();
         $dateTime = Date::excelToDateTimeObject($row["payroll_date"]);
         $salary_month=$dateTime->format('Y-d-m');
         if(isset($staff)){
            if(isset($row['arr']) && !empty($row['arr'])){
                $ins['staff_id'] = $staff->id;
                $ins['salary_month'] = $salary_month;
                $ins['academic_id'] = academicYearId();
                $ins['amount'] = $row['arr'];
                $ins['remarks'] = $row['remarks'] ?? null;
                $ins['earnings_type'] = 'arrear';
                $ins['status'] = 'active';
                $ins['added_by'] = auth()->user()->id;
                StaffSalaryPreEarning::updateOrCreate(['staff_id' => $staff->id, 'salary_month' => $salary_month, 'earnings_type' =>'arrear'], $ins);
            }
            if(isset($row['bonus']) && !empty($row['bonus'])){
                $ins['staff_id'] = $staff->id;
                $ins['salary_month'] = $salary_month;
                $ins['academic_id'] = academicYearId();
                $ins['amount'] = $row['bonus'];
                $ins['remarks'] = $row['remarks'] ?? null;
                $ins['earnings_type'] = 'bonus';
                $ins['status'] = 'active';
                $ins['added_by'] = auth()->user()->id;
                StaffSalaryPreEarning::updateOrCreate(['staff_id' => $staff->id, 'salary_month' => $salary_month, 'earnings_type' =>'bonus'], $ins);
            }
            if(isset($row['others']) && !empty($row['others'])){
                $ins['staff_id'] = $staff->id;
                $ins['salary_month'] = $salary_month;
                $ins['academic_id'] = academicYearId();
                $ins['amount'] = $row['others'];
                $ins['remarks'] = $row['remarks'] ?? null;
                $ins['earnings_type'] = 'other';
                $ins['status'] = 'active';
                $ins['added_by'] = auth()->user()->id;
                StaffSalaryPreEarning::updateOrCreate(['staff_id' => $staff->id, 'salary_month' => $salary_month, 'earnings_type' =>'other'], $ins);

            }
            if(isset($row['contri']) && !empty($row['contri'])){
                $ins['staff_id'] = $staff->id;
                $ins['salary_month'] = $salary_month;
                $ins['academic_id'] = academicYearId();
                $ins['amount'] = $row['contri'];
                $ins['remarks'] = $row['remarks'] ?? null;
                $ins['deduction_type'] = 'contribution';
                $ins['status'] = 'active';
                $ins['added_by'] = auth()->user()->id;
                StaffSalaryPreDeduction::updateOrCreate(['staff_id' => $staff->id, 'salary_month' => $salary_month, 'deduction_type' =>'contribution'], $ins);
            }
            if(isset($row['other']) && !empty($row['other'])){
                $ins['staff_id'] = $staff->id;
                $ins['salary_month'] = $salary_month;
                $ins['academic_id'] = academicYearId();
                $ins['amount'] = $row['other'];
                $ins['remarks'] = $row['remarks'] ?? null;
                $ins['deduction_type'] = 'other';
                $ins['status'] = 'active';
                $ins['added_by'] = auth()->user()->id;
                StaffSalaryPreDeduction::updateOrCreate(['staff_id' => $staff->id, 'salary_month' => $salary_month, 'deduction_type' =>'other'], $ins);

            }
         }
         }
        });
        return true;
            
            

    }
 
  
}
