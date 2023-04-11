<?php

namespace App\Exports;

use App\Models\Block;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BlockExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Block::select('blocks.name','institutions.name as institute_name','place_of_works.name as place_of_works_name','blocks.description','blocks.status','blocks.created_at')
        ->leftJoin('institutions','institutions.id','=','blocks.institute_id')
        ->leftJoin('place_of_works','place_of_works.id','=','blocks.place_of_work_id')
        ->get();
    }
    public function headings(): array
    {
        return [
        'Block name',
        'Institution Name',
        'Place Of Work Name',
        'Description',
        'Status',
        'Created At',
        ]; 
    }
}
