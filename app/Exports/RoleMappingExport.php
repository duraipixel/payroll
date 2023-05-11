<?php

namespace App\Exports;

use App\Models\Master\BankBranch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Role\RoleMapping;

class RoleMappingExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  RoleMapping::leftJoin('users as staff','staff.id','=','role_mappings.staff_id')
        ->leftJoin('users as created','created.id','=','role_mappings.role_created_id')  
        ->leftJoin('roles','roles.id','=','role_mappings.role_id')
        ->select('staff.name as staff_name','roles.name as role_name','created.name as created_by_name',
        'role_mappings.status','role_mappings.created_at')
        ->get();
    }
    public function headings(): array
    {
        return [
        'Staff Name',
        'Role Name',
        'Role Created By',
        'Status',
        'Created At',
        ]; 
    }
}
