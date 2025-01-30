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
        
        try {
            DB::transaction(function() use ($rows) {
                foreach ($rows as $row) {
                    $staff = User::where('institute_emp_code', $row["inst_emp_code"])->first();
        
                    if (!$staff) {
                        continue; // Skip if no staff is found
                    }
        
                    $dateTime = Date::excelToDateTimeObject($row["payroll_date"]);
                    $salary_month = $dateTime->format('Y-m-d'); // Corrected date format (was Y-d-m)
        
                    // Define reusable values
                    $commonData = [
                        'staff_id' => $staff->id,
                        'salary_month' => $salary_month,
                        'academic_id' => academicYearId(),
                        'status' => 'active',
                        'added_by' => auth()->user()->id,
                        'remarks' => $row['remarks'] ?? null,
                    ];
        
                    // Salary Earnings
                    $earnings = [
                        'arr'   => 'arrear',
                        'bonus' => 'bonus',
                        'others' => 'other',
                    ];
                    foreach ($earnings as $key => $earningType) {
                        if (!empty($row[$key])) {
                            StaffSalaryPreEarning::updateOrCreate(
                                ['staff_id' => $staff->id, 'salary_month' => $salary_month, 'earnings_type' => $earningType],
                                array_merge($commonData, ['amount' => $row[$key], 'earnings_type' => $earningType])
                            );
                        }
                    }
        
                    // Salary Deductions
                    $deductions = [
                        'contri' => 'contribution',
                        'other'  => 'other',
                    ];
                    foreach ($deductions as $key => $deductionType) {
                        if (!empty($row[$key])) {
                            StaffSalaryPreDeduction::updateOrCreate(
                                ['staff_id' => $staff->id, 'salary_month' => $salary_month, 'deduction_type' => $deductionType],
                                array_merge($commonData, ['amount' => $row[$key], 'deduction_type' => $deductionType])
                            );
                        }
                    }
                }
            });
        
            return true;
        } catch (\Exception $e) {
            Log::error('Payroll Processing Error: ' . $e->getMessage());
            return false;
        }
    }
 
  
}
