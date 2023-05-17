<?php

namespace App\Models\Staff;

use App\Models\Master\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffKnownLanguage extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'language_id',	
        'read',	
        'write',	
        'speak',	
        'status'
    ];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
