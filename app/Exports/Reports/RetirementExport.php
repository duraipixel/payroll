<?php

namespace App\Exports\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RetirementExport implements FromView
{
    public $users,$institute_id;
    function __construct($users,$institute_id)
    {
        $this->users = $users;
        $this->institute_id = $institute_id;
    }
    public function view() : View
    {
        return view('pages.reports.retirement._export', ['users' =>  $this->users,'institute_id'=>$this->institute_id]);
    }
}
