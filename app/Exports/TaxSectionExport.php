<?php

namespace App\Exports;

use App\Models\Tax\TaxSection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TaxSectionExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    // a place to store the team dependency
    private $section;

    // use constructor to handle dependency injection
    public function __construct()
    {
        $this->section = TaxSection::with('scheme')->get();
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
            $member->scheme->name,
            $member->name,
            $member->maximum_limit,
            $member->status,
            $member->created_at
        ];
    }

    // this is fine
    public function headings(): array
    {
        return [
            'Tax Scheme',
            'Tax Section',
            'Maximum Limit',
            'Status',
            'Created At',
        ];
    }
    
}
