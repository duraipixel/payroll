<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffELEntry extends Model
{
    use HasFactory;
    protected $table='staff_el_entries';
    protected $fillable = ['staff_id','academic_id','calendar_id','from_date','to_date','leave_days','remarks','leave_mapping_id'];

}
