<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LeavesReportExport implements FromView
{
    public $leaves;
    function __construct($leaves)
    {
        $this->leaves = $leaves;
    }
    public function view() : View
    {
        return view('pages.reports.leaves._table', ['leaves' =>  $this->leaves]);
    }
}
