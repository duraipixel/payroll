<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportRepository
{

    public function getServiceHistory()
    {

        $chunkSize = 2;
        $employees = User::with(['appointment', 'position', 'position.designation', 'personal'])->where('verification_status', 'approved')->whereNull('is_super_admin')->get();
        $academic_data = AcademicYear::find(academicYearId());

        $employeeChunks = $employees->chunk($chunkSize);

        $all_datas = [];
        if (isset($employeeChunks) && !empty($employeeChunks)) {
            foreach ($employeeChunks as $employeeChunk) {
                foreach ($employeeChunk as $emp) {
                    $params = [];
                    $staff_id = $emp->id;
                    $params['staff_details'] = $emp;
                    $nature_of_employment_id = $emp->appointment->nature_of_employment_id ?? '';
                    $params['salary_field'] = SalaryField::where('nature_id', $nature_of_employment_id)->where('salary_head_id', 1)->orderBy('order_in_salary_slip')->get();

                    if ($academic_data) {

                        $sdate = $academic_data->from_year . '-' . $academic_data->from_month . '-01';
                        $start_date = date('Y-m-d', strtotime($sdate));
                        $edate = $academic_data->to_year . '-' . $academic_data->to_month . '-01';
                        $end_date = date('Y-m-t', strtotime($edate));
                        $params['start_list_date'] = date('Y-m-d', strtotime($sdate . ' - 1 month'));
                        $salary_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])
                            ->where(function ($q) use ($start_date, $end_date) {
                                $q->where('payout_month', '>=', $start_date);
                                $q->where('payout_month', '<=', $end_date);
                            })
                            ->where('is_current', 'yes')
                            ->first();
                    }
                    $params['salary_pattern'] = $salary_pattern;
                    $all_datas[] = $params;
                }
            }
        }
        return $all_datas;
    }
}
