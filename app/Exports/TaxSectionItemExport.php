<?php

namespace App\Exports;

use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TaxSectionItemExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    // a place to store the team dependency
    private $section;

    // use constructor to handle dependency injection
    public function __construct()
    {
        $this->section = TaxSectionItem::with('section')->get();
    }

    // set the collection of members to export
    public function collection()
    {
        return $this->section;
    }

    // map what a single member row should look like
    // this method will iterate over each collection item
    public function map($member): array
    {
        
        return [
            $member->section->scheme->name,
            $member->section->name,
            $member->name,
            $member->created_at
        ];
    }

    // this is fine
    public function headings(): array
    {
        return [
            'Tax Scheme',
            'Tax Section',
            'Item Name',
            'Created At',
        ];
    }
   
}
