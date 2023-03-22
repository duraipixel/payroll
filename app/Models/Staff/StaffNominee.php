<?php

namespace App\Models\Staff;

use App\Models\Master\RelationshipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffNominee extends Model
{
    use HasFactory;
    protected $table = 'staff_nominees';
    protected $fillable = [
        'staff_id',
        'academic_id',
        'nominee_id',
        'relationship_type_id',
        'dob',
        'gender',
        'age',
        'minor_name',
        'share',
        'minor_address',
        'minor_contact_no'
    ];

    public function nominee()
    {
        return $this->hasOne(StaffFamilyMember::class, 'id', 'nominee_id');
    }

    public function relationship()
    {
        return $this->hasOne(RelationshipType::class, 'id', 'relationship_type_id');
    }
}
