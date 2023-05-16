<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'academic_id',
        'name',
        'sort_order',
        'status'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_id', 'id');
    }
}
