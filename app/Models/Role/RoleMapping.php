<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\User;
use App\Models\Role\Role;

class RoleMapping extends Model
{
    
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'role_id',
        'role_created_id',
        'sort_order',
        'status'
    ];
    public function staff_deatils()
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
    public function role_deatils()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    public function created_by()
    {
        return $this->hasOne(User::class, 'id', 'role_created_id');
    }
}