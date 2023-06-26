<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ItTabulation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = [
        'scheme',
        'scheme_id',
        'slug',
        'slab_amount',	
        'from_amount',	
        'to_amount',	
        'percentage',	
        'status',	
        'addedBy',	
        'updatedBy'
    ];

}
