<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Master\Society;
use App\Models\User;
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
        'status',
        'addedBy',
        'updatedBy'
    ];
    public function society()
    {
        return $this->belongsTo(Society::class,'society_id','id');
    }

    public function lastUpdatedBy() {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }

    public function added() {
        return $this->hasOne(User::class, 'id', 'addedBy');
    }
}
