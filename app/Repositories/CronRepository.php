<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class CronRepository
{
    
    public function getData() {

        $date = date('Y-m-d');
        $end_date = $date;

        $url = 'http://192.168.1.46:8085/att/api/dailyAttendanceReport/?page_size=100000';
        $url = 'http://192.168.1.46:8085/att/api/dailyAttendanceReport/?start_date='.$date.'&end_date='.$end_date.'&page_size=1000000';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic YWRtaW46YWRtaW4=',
            'Cookie' => 'csrftoken=Ijp1jBEPQYcqWyautHJOgWJexx3UTPMSPC3vJegzRJLeAakrmi2eL68hOzJAelEG',
        ])->get($url);
        
        // Check if the request was successful
        if ($response->successful()) {
            $responseData = $response->json(); // Assuming the response is in JSON format
            
            if( isset( $responseData['data'] ) && !empty( $responseData['data'] )) {
                foreach ($responseData['data'] as $items ) {
                    dd( $items );
                }
                dd( $responseData );
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
