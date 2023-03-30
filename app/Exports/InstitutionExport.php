<?php

namespace App\Exports;

use App\Models\Master\Institution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InstitutionExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Institution::select('institutions.name','institutions.code','institutions.address','societies.name as society_name','institutions.status')
        ->join('societies','societies.id','=','institutions.society_id')
        ->get();
    }
    public function headings(): array
    {
        return [
        'Name',
        'Code',
        'Address',
        'Society',
        'Status',
        ]; 
    }
}
