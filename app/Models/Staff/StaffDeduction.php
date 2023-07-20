<?php

namespace App\Models\Staff;

use App\Models\Tax\TaxSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StaffDeduction extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'financial_start',	
        'financial_end',	
        'tax_section_id',	
        'tax_section_item_id',	
        'remarks',	
        'amount',	
        'status',	
        'added_by',	
        'updated_by',
        'staff_id',
        'non_editable'
    ];

    public function section() {
        return $this->hasOne(TaxSection::class, 'id', 'tax_section_id');
    }

    public function sectionItem() {
        return $this->hasOne(TaxSectionItem::class, 'id', 'tax_section_item_id');
    }

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
