<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'account' => [
        'overview' => 'Overview',
        'logs' => 'Logs'
    ],
    'authentication' => [
         'role' => 'Roles',
         'role-mapping' => 'Role Mappings',
         'user.permission' => 'Permissions',
     ],
    'staff_management' => [
        'staff.register' => 'Register',
        'staff.list' => 'Staff List',
        'staff.bulk' => 'Bulk Upload',
        'reporting' => 'Reporting Manager',
        'staff.transfer' => 'Staff Transfer',
        'staff.el.summary'=>'Staff El Summary'
    ],
    'document_locker' => [
        'user.document_locker' => 'List',
        //'Details' => 'Details',
    ],
    
    'block_mapping' => [
        'blocks' => 'Blocks',
    ],
    'attendance_management' => [
        'att-manual-entry' => 'Attendance Manual Entry',
    ],
    
    'leave_management' => [
        'leaves.overview'=>'Leaves Overview',
        'leaves.list' => 'Request Leave',
        'leave-status' => 'Leave Status',
        'leave-head' => 'Leave Head',
        'leave-mapping' => 'Leave Mapping', 
        'leave-cancellation' => 'Leave Cancellation',
        'holiday' => 'Holidays', 
        'leaves.set.workingday'=>'Set Working day'
    ],
    'payroll_management' => [
        
        'salary-head' => 'Salary Heads',
        'salary-field' => 'Salary Fields',
        'salary.creation' => 'Salary Creation',
        'salary.revision' => 'Salary Revision',
        'salary.loan' => 'Loan',
        'salary.lic' => 'Insurance',
        'earnings' => 'Earnings',
        'deductions' => 'Deductions',
        'taxscheme' => 'Tax Scheme',
        'taxsection' => 'Tax Section',
        'taxsection-item' => 'Tax Section Item',
        'it' => 'Income',
        'it.tabulation' => 'IT Tabulation',
        'it-calculation' => 'IT Calculation',
        'other-income' => 'Other Income',
        'professional-tax' => 'Professional Tax',
        'holdsalary' => 'Hold Salary',
        'payroll.overview' => 'Payroll Overview'  
              
    ],
    
    'gratuity_calculations' =>
    [
        'gratuity' => 'Gratuity',
        'career' => 'Career Transition Module'
    ],

    'master_menu' => [
        'appointment.orders' => 'Appointment Order',
        'scheme' => 'Attence Schemes',
        'bank' => 'Bank',
        'bank-branch' => 'Bank Branch',
        'blood_group' => 'Blood Group',
        'caste' => 'Caste',
        'class' => 'Classes',
        'community' => 'Community',
        'department' => 'Department',
        'designation' => 'Designation',
        'division' => 'Division',
        'document_type' => 'Document Type',
        'duty-class' => 'Duty Class',
        'duty-type' => 'Duty Types',
        'professional_type'=>'Education Types',
        'nature-of-employeement'=>'Employment Nature',
        'institutions' => 'Institution',
        'language' => 'Language',
        'nationality' => 'Nationality',      
        'place' => 'Other School Place',
        'other-school' => 'Other Schools',
        'workplace' => 'Place Of Work',
        'qualification' => 'Qualification',
        'relationship' => 'Relationship Type',
        'religion' => 'Religion',
        'staff-category' => 'Staff Category',
        'subject' => 'Subject',
        'teaching-type' => 'Teaching Type',
        'training-topic' => 'Training Topic',
        'board' => 'University/Boards',        
     ],    
    'reports' => [

        'reports.profile' => 'Staff Profile Reports',
        'reports.attendance' => 'Staff Attendance Reports',
        'reports.service.history' => 'Staff Service History Book Reports',
        'reports.staff.history' => 'Staff History Reports',
        'reports.salary.register' => 'Staff Salary Register Reports',
        'reports.retirement' => 'Staff Retirement Reports',
        'reports.leaves' => 'Staff Leave Reports',
        'reports.epf.report' => 'EPF Reports',
        'reports.esi.report' => 'ESI Reports',
        'reports.income.tax.report' => 'IncomeTax  Reports',
        'reports.bonus.report' => 'Bonus Reports',
        'reports.arrears.report' => 'Arrears Reports',
        'reports.resignation.report' => 'Resignation Reports',
        'reports.salary.acquitance.report' => 'SalaryAcquitance Reports',
        'reports.staff.acquitance.register' => 'SalaryAcquitance Register Reports',
        'reports.bank.loan.report' => 'Bank Loan Reports',
        'reports.lic.report' => 'LIC Reports',
        'reports.lop.report' => 'LOP Reports',
        'reports.salary.hold.repor' => 'SalaryHold Reports',
        'reports.professional.tax.report' => 'ProfessionalTax Reports',
        'reports.month.wise.variation.report' => 'MonthWiseVariation Reports',
        'reports.notification.list' => 'Notification Reports',
        'leave.report'=>'Leave Report',
        'bank.disbursement.report'=>'Bank Disbursement Report'

    ]
];
