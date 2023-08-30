<?php

namespace App\Exports\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RetirementExport implements FromView
{
    public $users;
    function __construct($users)
    {
        $this->users = $users;
    }
    public function view() : View
    {
        return view('pages.reports.retirement._table', ['users' =>  $this->users]);
    }
}
