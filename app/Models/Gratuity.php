<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Gratuity extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'institution_id',	
        'husband_name',	
        'dob',	
        'last_post_held',	
        'date_of_regularizion',	
        'date_of_ending_service',	
        'cause_of_ending_service', //'Superannuation,Due to medical ground,Invalid on medical ground,Death,retired,resigned'	
        'gross_service',	
        'gross_service_year',	
        'gross_service_month',	
        'extraordinary_leave',	
        'net_qualifying_service',	
        'suspension_qualifying_service',
        'qualify_service_expressed', 	
        'total_emuluments',	
        'gratuity_calculation',	
        'gratuity_nomination_name',	
        'gratuity_nomination_type',	
        'gratuity_nomination_contact_details',	
        'gratuity_nomination_address',	
        'total_payable_gratuity',	
        'mode_of_payment',	
        'status',	//'active', 'inactive'
        'settlement_status', 	//'pending', 'completed', 'cancelled'
        'verification_status', //'verified', 'failed', 'pending'
        'settlement_date',	
        'date_of_issue',	
        'issue_remarks',	
        'issue_attachment',	
        'payment_remarks',	
        'payment_attachment',	
        'approved_by',
        'page_type'
    ];

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
