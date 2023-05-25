<?php

namespace App\Models;

use App\Models\Scopes\AcademicScope;
use App\Models\Scopes\InstitutionScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarDays extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'calendar_date',
        'days_type',
        'institute_id',
        'comments',
        'academic_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AcademicScope);
        static::addGlobalScope(new InstitutionScope);
    }
    

}
