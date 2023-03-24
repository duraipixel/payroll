<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TeachingType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'teaching_types';
    protected $fillable = [
        'academic_id',	
        'institute_id',
        'name',
        'sort_order',	
        'status'
    ];
}
