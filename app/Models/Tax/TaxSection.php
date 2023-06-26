<?php

namespace App\Models\Tax;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSection extends Model
{
    use HasFactory;

    protected $fillable = [
       'academic_id',	
       'name',	
       'slug',	
       'financial_start',	
       'financial_end',	
       'maximum_limit',	
       'status',	
       'added_by',	
       'updated_by',
       'tax_scheme_id'
    ];

    public function scheme() {
        return $this->hasOne(TaxScheme::class, 'id', 'tax_scheme_id');
    }

}
