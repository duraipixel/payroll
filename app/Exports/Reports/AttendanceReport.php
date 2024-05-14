<?php

namespace App\Exports\Reports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceReport implements FromView
{
    public $attendance, $month_days,$no_of_days,$start_date;
    function __construct($attendance, $month_days,$no_of_days,$start_date)
    {
        $this->attendance = $attendance;
        $this->month_days = $month_days;
        $this->no_of_days = $no_of_days;
        $this->start_date = $start_date;
    }
    public function view() : View
    {
        return view('pages.reports.attendance._table', [
            'attendance' => $this->attendance,
            'month_days' => $this->month_days,
            'no_of_days' => $this->no_of_days,
            'start_date' => $this->start_date,
        ]);
    }
}
