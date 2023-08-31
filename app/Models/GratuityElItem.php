<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GratuityElItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gratuity_el_id',
        'el_from_year',
        'el_to_year',
        'total_leave',
        'taken_leave',
        'leave_description'
    ];

}
