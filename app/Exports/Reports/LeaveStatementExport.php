<?php

namespace App\Exports\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class LeaveStatementExport implements FromView
{
    public $data,$from_date,$to_date;
    function __construct($data,$from_date ,$to_date)
    {
        $this->data = $data;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
    public function view() : View
    {
        return view('pages.reports.exports.leave', ['data' =>  $this->data,'from_date' =>  $this->from_date,'to_date' =>  $this->to_date]);
    }
}