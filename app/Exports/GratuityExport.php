<?php

namespace App\Exports;

use App\Models\Gratuity;
use App\Models\Staff\StaffRetiredResignedDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GratuityExport implements FromCollection, WithHeadings
{
    public $types;
    public function __construct($types) {
        $this->types = $types;
    }
    public function collection()
    {
        return Gratuity::select('gratuities.created_at','users.name','users.institute_emp_code','gratuities.last_post_held','gratuities.date_of_regularizion','gratuities.date_of_ending_service',
        'gratuities.cause_of_ending_service','gratuities.gross_service','gratuities.extraordinary_leave','gratuities.net_qualifying_service','gratuities.suspension_qualifying_service',
        'gratuities.qualify_service_expressed','gratuities.total_emuluments','gratuities.gratuity_calculation','gratuities.total_payable_gratuity','gratuities.mode_of_payment','gratuities.verification_status',
        'gratuities.date_of_issue','gratuities.issue_remarks','gratuities.payment_remarks', 'gratuities.gratuity_type')
                        ->join('users', 'users.id', '=', 'gratuities.staff_id')->where('page_type', $this->types)->get();
    }
    public function headings(): array
    {
        return [
            'Added Date',
            'Employee Name',
            'Employee Code',
            'Last Post Held',
            'Date of Regularizion',
            'Date of Ending Service',
            'Cause of Ending Service',
            'Gross Service',
            'Extraordinary Leave',
            'Net Qualifying Service',
            'Suspension Qualifying Service',
            'Qualify Service Expressed',
            'Total Emuluments',
            'Gratuity Calculation',
            'Total Payable Gratuity',
            'Mode of Payment',
            'Verification Status',
            'Date of Issue',
            'Issue Remarks',
            'Payment Remarks',
            'Gratuity Type'
        ]; 
    }
}
