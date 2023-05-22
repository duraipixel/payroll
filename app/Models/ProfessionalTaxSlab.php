<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalTaxSlab extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_amount',
        'to_amount',
        'tax_fee',	
        'status'
    ];

}
