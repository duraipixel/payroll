<?php

namespace App\Models\Staff;

use App\Models\Master\Institution;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'from_institution_id',
        'to_institution_id',
        'staff_id',
        'remarks',
        'reason',
        'effective_from',
        'status', //'pending', 'approved', 'rejected'
        'new_institution_code',
        'old_institution_code'

    ];

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

    public function from() {
        return $this->hasOne(Institution::class, 'id', 'from_institution_id');
    }

    public function to() {
        return $this->hasOne(Institution::class, 'id', 'to_institution_id');
    }

}
