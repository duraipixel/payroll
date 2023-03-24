<?php

namespace App\Models\Staff;

use App\Models\Master\RelationshipType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffWorkingRelation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id', 
        'staff_id', 
        'types',
        'belonger_id',
        'belonger_code',
        'status',
        'relationship_type_id'
    ];

    public function belonger()
    {
        return $this->hasOne(User::class, 'id', 'belonger_id');
    }

    public function relationship()
    {
        return $this->hasOne(RelationshipType::class, 'id', 'relationship_type_id');
    }

    public function personal()
    {
        return $this->hasOne(StaffPersonalInfo::class, 'staff_id', 'staff_id');
    }
}
