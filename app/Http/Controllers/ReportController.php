<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function index() {
        return view('pages.reports.index');
    }

    public function profileReports(Request $request) {

        if( $request->ajax() ){
            $details = User::with(['personal', 'position'])->whereNull('is_super_admin')->orderBy('society_emp_code', 'desc')->get();
            $params = [ 'details' => $details ];
            return view('pages.reports.profile._table_content', $params);
        }
        return view('pages.reports.profile._index');
    }

    public function commonExport(Request $request) {

    }
}