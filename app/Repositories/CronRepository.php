<?php

namespace App\Repositories;

use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class CronRepository
{

    public function getData()
    {

        $date = date('Y-m-d');
        
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
                \Log::info($responseData['data']);
                foreach ($responseData['data'] as $items) {
                    $ins = [];
                    $institute_code = $items['emp_code'];
                    $user_info = User::where('institute_emp_code', $institute_code)->first();
                   if($user_info){
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
                    $ins['employment_id'] = $user_info->id ?? '';
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
                    $entry_info = AttendanceManualEntry::updateOrCreate($check_array, $ins);
                }
                   
                    // dd( $entry_info );
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
    public function getDataByDate( $date)
    {

     
        
        $end_date = $date;

        // $url = 'http://192.168.1.46:8085/att/api/dailyAttendanceReport/';
        $url = 'http://192.168.1.46:8085/att/api/dailyAttendanceReport/?start_date=' . $date . '&end_date=' . $end_date . '&page_size=1000000';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic YWRtaW46YWRtaW4=',
            'Cookie' => 'csrftoken=Ijp1jBEPQYcqWyautHJOgWJexx3UTPMSPC3vJegzRJLeAakrmi2eL68hOzJAelEG',
        ])->timeout(1000)->get($url);

        // Check if the request was successful
        if ($response->successful()) {
            $responseData = $response->json(); // Assuming the response is in JSON format
            if (isset($responseData['data']) && !empty($responseData['data'])) {
                \Log::info($responseData['data']);
                foreach ($responseData['data'] as $items) {
                    $ins = [];
                    $institute_code = $items['emp_code'];
                    $user_info = User::where('institute_emp_code', $institute_code)->first();
                   if($user_info){
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
                    $ins['employment_id'] = $user_info->id ?? '';
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
                    $entry_info = AttendanceManualEntry::updateOrCreate($check_array, $ins);
                }
                   
                    // dd( $entry_info );
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
