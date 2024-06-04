<?php

namespace App\Exports\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BankLoanExport implements FromView
{
    public $data,$institute_id,$start_date;
    function __construct($data,$institute_id,$start_date)
    {
        $this->data = $data;
        $this->institute_id = $institute_id;
        $this->start_date = $start_date;
    }
    public function view() : View
    {
        return view('pages.reports.exports.bankloan', ['data' =>  $this->data,'institute_id' =>  $this->institute_id,'start_date' =>  $this->start_date]);
    }
}