<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'academic_id',
        'role_id',
        'route_name',
        'add_edit_menu',       
        'view_menu',
        'delete_menu',
        'export_menu',
        'sort_order',
        'status'
    ];
}
