<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollRepository
{

    public function generateSalarySlip($info)
    {

        $date_string = $info->salary_year . '-' . $info->salary_month . '-01';
        $date = date('d/M/Y', strtotime($date_string));

        $params = [
            'institution_name' => $info->staff->institute->name ?? '',
            'institution_address' => $info->staff->institute->address ?? '',
            'pay_month' => 'Pay Slip for the month of ' . $info->salary_month . '-' . $info->salary_year,
            'info' => $info,
            'date' => $date
        ];

        $file_name = time() .'_'. $info->staff->institute_emp_code . '.pdf';

        $directory              = 'public/salary/' . $date_string;
        $filename               = $directory . '/' . $file_name;

        $pdf = Pdf::loadView('pages.payroll_management.overview.statement._auto_gen_pdf', $params)->setPaper('a4', 'portrait');
        Storage::put($filename, $pdf->output());
        return $filename;

    }

}
