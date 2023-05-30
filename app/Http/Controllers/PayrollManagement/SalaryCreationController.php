<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\SalaryHead;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryField;
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

    public function salaryAdd(Request $request)
    {
        
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $earnings = 0;
        $deductions = 0;
        $net_pay = 0;
        if($salary_heads) {
            $ins = [];
            foreach ($salary_heads as $items) {
                if ( isset($items->fields) && !empty($items->fields) ) {
                    foreach ( $items->fields as $item_fields ) {
                        if( isset($_POST['amount_'.$item_fields->id]) ) {
                            $amount = $_POST['amount_'.$item_fields->id];
                            $ins[] = array('field_id' => $item_fields->id, 'name' => $item_fields->name, 'amount' => $amount, 'reference_type' => $items->name, 'reference_id' => $items->id );
                            if( $items->name == 'EARNINGS') {
                                $earnings += $amount;
                            } else {
                                $deductions += $amount;

                            }
                        }
                    }
                }
            }
        }
        $net_pay = $earnings - $deductions;
        

        if( !empty( $ins )) {
            $insert_data = [];
            $insert_data['staff_id'] = $staff_id;
            $insert_data['salary_no'] = date('ymdhis');
            $insert_data['total_earnings'] = $earnings;
            $insert_data['total_deductions'] = $deductions;
            $insert_data['gross_salary'] = $earnings;
            $insert_data['net_salary'] = $net_pay;
            $insert_data['is_salary_processed'] = 'no';
            $insert_data['status'] = 'active';
            
            $salary_info = StaffSalary::updateOrCreate(['staff_id' => $staff_id], $insert_data);

            StaffSalaryField::where('staff_salary_id', $salary_info->id )->forceDelete();

            foreach ( $ins as $items_pay ) {

                $field_data = [];
                $field_data['staff_id'] = $staff_id;
                $field_data['staff_salary_id'] = $salary_info->id;
                $field_data['field_id'] = $items_pay['field_id'];
                $field_data['field_name'] = $items_pay['name'];
                $field_data['amount'] = $items_pay['amount'];
                $field_data['percentage'] = '';
                $field_data['reference_type'] = $items_pay['reference_type'];
                $field_data['reference_id'] = $items_pay['reference_id'];
                StaffSalaryField::create($field_data);
                
            }
            $error = 'Salary is set successfully';
        } else {
            $error = 'Error while setting Salary Fields';
        }
        return redirect('/salary/creation')->with('status', $error);

    }

    public function getStaffSalaryInfo(Request $request)
    {
        $staff_id = $request->staff_id;

        $salary_info = StaffSalary::where('staff_id', $staff_id)->first();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        return view('pages.payroll_management.salary_creation.fields', compact('salary_heads', 'salary_info' ) );
    }
}
