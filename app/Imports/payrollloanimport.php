<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DB;
use App\Models\Staff\StaffBankLoan;
use App\Models\Master\Bank;
use App\Models\Staff\StaffLoanEmi;

class PayrollLoanImport implements ToCollection, WithHeadingRow
{
    public $collection;

    public function collection(Collection $rows)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        // Start the transaction block
        DB::transaction(function() use ($rows) {
            foreach($rows as $row) {
                try {
                    // Retrieve staff based on employee code
                    $staff = User::where('institute_emp_code', $row["inst_emp_code"])->first();

                    if (isset($staff) && isset($row['loan_type'])) {
                        $staff_id = $staff->id;
                        
                        // Retrieve bank info based on the bank name
                        $bank_info = Bank::where('name', 'LIKE', "%{$row['bank']}%")->first();

                        // Prepare loan data
                        $ins = [
                            'staff_id' => $staff_id,
                            'bank_id' => $bank_info->id,
                            'bank_name' => $bank_info->name,
                            'ifsc_code' => $row['ifsc_code'],
                            'loan_ac_no' => $row['acc_no'],
                            'loan_type' => $row['staff_loan_type'],
                            'loan_due' => $row['loan_type'],
                            'every_month_amount' => $row['pay_amount'],
                            'loan_amount' => $row['loan_amount'],
                            'period_of_loans' => $row['loan_period'],
                            'status' => 'active',
                        ];

                        // Handle loan start and end dates
                        if ($row['loan_start_date']) {
                            $dateTime = Date::excelToDateTimeObject($row["loan_start_date"]);
                            $loan_start_date = $dateTime->format('Y-m-d');
                            $ins['loan_start_date'] = $loan_start_date;
                        }
                        
                        if ($row['loan_end_date']) {
                            $dateTime1 = Date::excelToDateTimeObject($row["loan_end_date"]);
                            $loan_end_date = $dateTime1->format('Y-m-d');
                            $ins['loan_end_date'] = $loan_end_date;
                        }

                        // Create or update the loan information in the database
                        $loan_info = StaffBankLoan::updateOrCreate(
                            ['staff_id' => $staff_id, 'loan_amount' => $row['loan_amount'],'loan_start_date'=>$loan_start_date],
                            $ins
                        );

                        // Handle the EMI records
                        $date = Date::excelToDateTimeObject($row["emi_loan_date"]);
                        $emi_date = $date->format('Y-m-d');
                        $check_date = date('Y-m-01', strtotime($emi_date));

                        $emi_ins = [
                            'staff_id' => $staff_id,
                            'staff_loan_id' => $loan_info->id,
                            'emi_date' => $emi_date,
                            'emi_month' => $check_date,
                            'amount' => $row['emi_pay_amount'] ?? 0,
                            'loan_mode' => $row['loan_type'],
                            'loan_type' => 'Bank Loan',
                            'status' => 'active',
                        ];

                        // Create or update the EMI record
                        StaffLoanEmi::updateOrCreate(
                            ['staff_loan_id' => $loan_info->id, 'emi_date' => $emi_date, 'amount' => $row['emi_pay_amount']],
                            $emi_ins
                        );
                    }
                } catch (\Exception $e) {
                    // Log the error for debugging purposes
                    \Log::error('Error processing row: ' . $e->getMessage());
                    
                    // Re-throw the exception to trigger Laravel's automatic transaction rollback
                    throw $e;
                }
            }
        });

        return true;
    }
}

