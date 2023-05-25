<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Master\Society;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'name',
        'society_id',
        'academic_id',
        'code',
        'logo',
        'flag',
        'short_name',
        'email',
        'contact_no',
        'landline_no1',
        'landline_no2',
        'city',
        'district',
        'state',
        'country',
        'post_code',
        'gstin_no',
        'school_recognise',
        'fax',
        'address',
        'status'
    ];
    public function society()
    {
        return $this->belongsTo(Society::class,'society_id','id');
    }
}
