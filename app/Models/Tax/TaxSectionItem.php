<?php

namespace App\Models\Tax;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'financial_start',	
        'financial_end',	
        'tax_scheme_id',	
        'name',	
        'is_proof',	
        'proof_document',	
        'slug',	
        'reference_salary_field_id',	
        'reference_slug',	
        'added_by',	
        'updated_by',
        'tax_section_id'
    ];

    public function section() {
        return $this->hasOne(TaxSection::class, 'id', 'tax_section_id');
    }

}
