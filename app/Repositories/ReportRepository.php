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

    public function getServiceHistory($employee_id, $department, $is_export = '')
    {

        $perPage = 1;
        $currentPage = 1;
        $employees = User::select('users.*')->with(['appointment', 'position', 'position.designation', 'personal', 'casualLeaves'])
            ->join('staff_professional_datas', 'staff_professional_datas.staff_id', '=', 'users.id')
            ->where('verification_status', 'approved')->whereNull('is_super_admin')
            ->when(!empty($employee_id), function ($query) use ($employee_id) {
                $query->where('users.id', $employee_id);
            })
            ->where('institute_id',session()->get('staff_institute_id'))
            ->when(!empty($department), function ($query) use ($department) {
                $query->where('staff_professional_datas.department_id', $department);
            });
        if ($is_export) {
           $employees = $employees->get();
        } else {
            $employees = $employees->paginate(2);
            $paginate = $employees->links();
        }


        $academic_data = AcademicYear::find(academicYearId());

       
        $all_datas = [];
        if (isset($employees) && !empty($employees)) {
            foreach ($employees as $emp) {
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
        return [$all_datas, $paginate ?? ''];
    }
}
