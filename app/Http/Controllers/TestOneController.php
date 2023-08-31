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

    public function getCronData(Request $request)
    {

        $date = $request->date;
        $date = date('Y-m-d', strtotime($date));
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
            if (isset($responseData['data']) && !empty($responseData['data'])) {
                $i = 0;
                foreach ($responseData['data'] as $items) {
                    $ins = [];
                    $institute_code = $items['emp_code'];
                    $user_info = User::where('institute_emp_code', $institute_code)->first();
                    if( $user_info ) {

                        $from_time = $items['check_in'];
                        $to_time = $items['check_out'];
                        $total_time = $items['duration'] ?? '00:00';
                        $clock_in = $items['clock_in'] ?? '00:00';
                        $clock_out = $items['clock_out'] ?? '00:00';
                        $total_clocked_time = $items['total_time'] ?? '00:00';
                        
                        $current_date = date('Y-m-d', strtotime($items['att_date']));
                        $attendance_status = $items['attendance_status'];
                       
                        $attendance_status = strip_tags($attendance_status);
                        $attendance_status = explode('(', $attendance_status);
                        $ins['academic_id'] = academicYearId();
                        $ins['employment_id'] = $user_info->id;
                        $ins['institute_id'] = $user_info->institute_id ?? '';
                        $ins['institute_emp_code'] = $institute_code ?? '';
                        $ins['attendance_date'] = $current_date;
                        $ins['reporting_manager'] = $user_info->reporting_manager_id ?? null;
                        if( current($attendance_status) != 'Absence' &&  current($attendance_status) != 'Present') {
                            $a_status = 'Present';
                            $ins['other_status'] = current($attendance_status);
                        } else {
                            $a_status = current($attendance_status);
                        }
                        $ins['attendance_status'] = $a_status ?? null;
                        $ins['reason'] = null;
    
                        $ins['from_time'] = new \Illuminate\Database\Query\Expression("CAST('$from_time' AS TIME)");
                        $ins['to_time'] = new \Illuminate\Database\Query\Expression("CAST('$to_time' AS TIME)");
                        $ins['total_time'] = new \Illuminate\Database\Query\Expression("CAST('$total_time' AS TIME)");
    
                        $ins['clock_in'] = new \Illuminate\Database\Query\Expression("CAST('$clock_in' AS TIME)");
                        $ins['clock_out'] = new \Illuminate\Database\Query\Expression("CAST('$clock_out' AS TIME)");
                        $ins['total_clocked_time'] = new \Illuminate\Database\Query\Expression("CAST('$total_clocked_time' AS TIME)");
                        $ins['api_response'] = serialize($items);
                        
                        $check_array = ['attendance_date' => $current_date, 'employment_id' => $user_info->id];
                      
                        // $entry_info = AttendanceManualEntry::updateOrCreate($check_array, $ins);
                    }
                    $i++;
                    dump( $i );
                }
                
            }
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
