<?php

namespace App\Exports\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LopExport implements FromView
{
    public $data,$institute_id,$from_date;
    function __construct($data,$institute_id,$from_date)
    {
        $this->data = $data;
        $this->institute_id = $institute_id;
        $this->from_date = $from_date;
    }
    public function view() : View
    {
        return view('pages.reports.exports.lop', ['data' =>  $this->data,'institute_id' =>  $this->institute_id,'from_date' =>  $this->from_date]);
    }
}