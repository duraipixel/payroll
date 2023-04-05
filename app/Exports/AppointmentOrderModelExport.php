<?php

namespace App\Exports;

use App\Models\Master\AppointmentOrderModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppointmentOrderModelExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AppointmentOrderModel::select('name','status','created_at')->get();
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
