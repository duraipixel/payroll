<?php

namespace App\Exports;

use App\Models\Tax\TaxScheme;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaxSchemeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TaxScheme::select('name','is_current','status','created_at')->get();
    }

    public function headings(): array
    {
        return [
        'Name',
        'Is Current Scheme',
        'Status',
        'Created At',
        ]; 
    }
}
