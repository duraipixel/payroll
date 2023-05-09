<?php

namespace App\Exports;

use App\Models\Role\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RoleExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Role::select('name','status','created_at')->get();
    }
    public function headings(): array
    {
        return [
        'Name',
        'Status',
        'Created At',
        ]; 
    }
}
