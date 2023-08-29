<?php

namespace App\Http\Controllers;

use App\Imports\OldStaffEntryImport;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\Master\AppointmentOrderModel;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\Staff\StaffAppointmentDetail;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\User;
use App\Repositories\CronRepository;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class TestOneController extends Controller
{
    public function cron(CronRepository $cronRepository) {
        return $cronRepository->getData();
    }

    public function testAppointmentPdf()
    {
        $info = AppointmentOrderModel::find(5);

        $params = array(
            'appointment_order_no' => 'ORder/121/1221',
            'appointment_date' => '2023-02-12',
            'staff_name' => 'Mrs. Durairaj.S',
            'designation' => 'Teacher',
            'institution_name' => 'Amalorpavam',
            'place' => 'Puducherry',
            'salary' => '25000'
        );

        $data = $info->document;
        
        foreach ($params as $key => $value) {
            $data = str_replace('$'.$key, $value, $data);
        }
        

        $pdf = PDF::loadView('pages.masters.appointment_order_model.dynamic_pdf', [ 'data' => $data])->setPaper('a4', 'portrait');
        return $pdf->stream('appointment.pdf');
    }

    public function deletePreviewPdf(Request $request)
    {
        $path = 'public/order_preview';
        if (File::exists($path)) {            
            File::deleteDirectory($path);
        }
    }

    public function importOldEntry()
    {
        Excel::import( new OldStaffEntryImport, request()->file('file') );
        return response()->json(['error'=> 0, 'message' => 'Imported successfully']);
    }

    public function sampleITStatement() {
        $data = [];
        $pdf = PDF::loadView('pages.sample.pdf.income_tax_statement', [ 'data' => $data])->setPaper('a4', 'portrait');
        return $pdf->stream('appointment.pdf');
    }

    public function testSalaryPdf()
    {

        $info = StaffSalary::find(1);
        $date_string = $info->salary_year.'-'.$info->salary_month.'-01';
        $date = date('d/M/Y', strtotime($date_string));
        
        $params = [
            'institution_name' => $info->staff->institute->name ?? '',
            'institution_address' => $info->staff->institute->address ?? '',
            'pay_month' => 'Pay Slip for the month of '.$info->salary_month.'-'.$info->salary_year,
            'info' => $info,
            'date' => $date
        ];
        // return view('pages.payroll_management.overview.statement._auto_gen_pdf', $params);
        $pdf = PDF::loadView('pages.payroll_management.overview.statement._auto_gen_pdf', $params)->setPaper('a4', 'portrait');
        return $pdf->stream('salaryslip.pdf');
    }

    public function assignAppointmentOrder() {

        $orders = StaffAppointmentDetail::whereNull('deleted_at')->get();
        // dd( $orders );
        if( isset( $orders ) && !empty( $orders ) ) {
            foreach ($orders as $items ) {
                // appointmentOrderNo($user_info->id)
                $order_no = appointmentOrderNo($items->staff_id, $items->academic_id );
                // dd( $order_no );
                $items->appointment_order_no = $order_no;
                $items->save();
                dump( $order_no );
            }
        }

    }

    public function checkCode() {
        $code = 'aews/20230704';
        $user_info = User::where('society_emp_code', $code)->first();

        $new_code = getStaffInstitutionCode($user_info->institute_id);
        // $user_info->institute_emp_code = $new_code;
        // $user_info->save();
        dd( $new_code );
    }   

    public function updateEntry() {

        $details = AttendanceManualEntry::whereNull('institute_id')->get();

        if( isset( $details ) && !empty( $details ) ) {
            foreach ($details as $items) {
                
                $user_info = User::find($items->employment_id);
                if( isset( $user_info ) && !empty( $user_info ) ) {

                    $items->institute_id = $user_info->institute_id;
                    $items->institute_emp_code = $user_info->institute_emp_code;
                    $items->save();
                }
            }
        }
    }

    public function getCronData()
    {

        $date = '2023-08-28';
        
        $end_date = $date;

        // $url = 'http://192.168.1.46:8085/att/api/dailyAttendanceReport/';
        $url = 'http://192.168.1.46:8085/att/api/dailyAttendanceReport/?start_date=' . $date . '&end_date=' . $end_date . '&page_size=1000000';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic YWRtaW46YWRtaW4=',
            'Cookie' => 'csrftoken=Ijp1jBEPQYcqWyautHJOgWJexx3UTPMSPC3vJegzRJLeAakrmi2eL68hOzJAelEG',
        ])->get($url);

        // Check if the request was successful
        if ($response->successful()) {
            $responseData = $response->json(); // Assuming the response is in JSON format
            return $responseData;
            // Do something with $responseData here
        } else {
            // Handle the error response
            $errorCode = $response->status();
            return $errorCode;
            // Handle the error based on the status code
        }
    }
}
