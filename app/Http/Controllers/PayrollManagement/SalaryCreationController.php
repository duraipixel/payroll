<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\SalaryHead;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryCreationController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Salary Creation',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Salary Creation'
                ),
            )
        );
        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        return view('pages.payroll_management.salary_creation.index', compact('breadcrums', 'employees', 'salary_heads'));
    }
}
