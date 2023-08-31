<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElGratuity extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'institution_id',
        'husband_name',
        'dob',
        'last_post_held',
        'date_of_regularization',
        'date_of_ending_service',
        'cause_of_ending_service',
        'total_el_days',
        'basic',
        'basic_da',
        'pba',
        'pba_da',
        'pba_da_percentage',
        'basic_da_percentage',
        'total_emoluments',
        'el_calculation',
        'total_el_gratuity',
        'el_type',
        'mode_of_payment',
        'status',
        'settlement_status',
        'verification_status',
        'settlement_date',
        'date_of_issue',
        'issue_remarks',
        'issue_attachment',
        'payment_remarks',
        'payment_attachment',
        'approved_by'
    ];

}
