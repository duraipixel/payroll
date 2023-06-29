<?php

namespace App\Models\Staff;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffRentDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'amount',	
        'document',	
        'remarks',	
        'annual_rent',	
        'status'
    ];

    public function staffDetails() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

    public function academic() {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_id');
    }

}
