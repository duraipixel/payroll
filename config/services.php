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
    'master_menu' => [
        'AppointmentOrder' => 'Appointment Orders',
        'AttendanceScheme' => 'Attence Schemes',
        'Bank' => 'Bank',
        'BankBranch' => 'Bank Branch',
        'BloodGroup' => 'Blood Group',
        'Caste' => 'Caste',
        'Classes' => 'Classes',
        'Community' => 'Community',
        'Department' => 'Department',
        'Designation' => 'Designation',
        'Division' => 'Division',
        'DocumentType' => 'Document Type',
        'DutyClass' => 'Duty Types',
        'ProfessionType'=>'Education Types',
        'NatureOfEmployment'=>'Employment Nature',
        'Institution' => 'Institution',
        'Language' => 'Language',
        'Nationality' => 'Nationality',      
        'OtherSchoolPlace' => 'Other School Place',
        'OtherSchool' => 'Other Schools',
        'PlaceOfWork' => 'Place Of Work',
        'Qualification' => 'Qualification',
        'RelationshipType' => 'Relationship Type',
        'Religion' => 'Religion',
        //'Society' => 'Society',
        'StaffCategory' => 'Staff Category',
        'Subject' => 'Subject',
        'TeachingType' => 'Teaching Type',
        'TopicTraining' => 'Training Topic',
        'Board' => 'University/Boards',        
    ],
    'staff_management' => [
        'Register' => 'Register',
        'StaffList' => 'Staff List',
        'BulkUpload' => 'Bulk Upload'
    ],
];
