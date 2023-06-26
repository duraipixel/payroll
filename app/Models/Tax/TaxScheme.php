<?php

namespace App\Models\Tax;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxScheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',	
        'slug',	
        'status',	
        'is_current',	
        'added_by',	
        'updated_by'
    ];

}
