<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IncomeTaxCalculationController extends Controller
{
    public function index(Request $request) {

        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();
        $params = array(
            'employees' => $employees
        );
        return view('pages.payroll_management.it_calculation.index', $params);
        
    }
}
