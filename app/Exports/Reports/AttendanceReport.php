<?php

namespace App\Exports\Reports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceReport implements FromView
{
    public $attendance, $month_days;
    function __construct($attendance, $month_days)
    {
        $this->attendance = $attendance;
        $this->month_days = $month_days;
    }
    public function view() : View
    {
        return view('pages.reports.attendance._table', [
            'attendance' => $this->attendance,
            'month_days' => $this->month_days,
        ]);
    }
}
