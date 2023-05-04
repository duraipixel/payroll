<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class LeaveFormGeneratorController extends Controller
{
    public function leaveApplication()
    {
        $pdf = PDF::loadView('leave_form.leave_application')->setPaper('a4', 'portrait');
        return $pdf->stream('test.pdf');
    }

    public function earnedLeaveApplication()
    {
        $pdf = PDF::loadView('leave_form.el')->setPaper('a4', 'portrait');
        return $pdf->stream('test.pdf');
    }

    public function eolApplication()
    {
        $pdf = PDF::loadView('leave_form.eol')->setPaper('a4', 'portrait');
        return $pdf->stream('test.pdf');
    }

    public function maternityLeaveApplication()
    {
        $pdf = PDF::loadView('leave_form.ml')->setPaper('a4', 'portrait');
        return $pdf->stream('test.pdf');
    }

    public function permissionApplication()
    {
        $pdf = PDF::loadView('leave_form.permission')->setPaper('a4', 'portrait');
        return $pdf->stream('test.pdf');
    }

}
