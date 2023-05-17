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
        'overview.save' => 'Overview',
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
        'leaves.list' => 'Request Leave',
        'leave-status' => 'Leave Status',
        'leave-head' => 'Leave Head',
        'leave-mapping' => 'Leave Mapping', 
        'holiday' => 'Holidays', 
    ],
    'payroll_management' => [
        'salary-head' => 'Salary Heads',
       // 'SalaryFields' => 'Salary Fields',
    ],
    
    'gratuity_calculations' =>
    [

    ],

    'master_menu' => [
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
];
