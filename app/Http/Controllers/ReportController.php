<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    function index() {
        return view('pages.reports.index');
    }
}