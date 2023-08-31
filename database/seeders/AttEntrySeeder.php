<?php

namespace Database\Seeders;

use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\User;
use DateInterval;
use DatePeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::select('id')->whereNull('is_super_admin')->get();
        
        $holiday = ['saturday', 'sunday'];
        $date = '2023-05-01';
        $month_start = date('Y-m-d', strtotime($date));
        $month_end = date('Y-m-t', strtotime($date));

        $start_date = date_create('2023-05-01');
        $end_date = date_create('2023-05-31');
        $interval = new DateInterval('P1D');
        $date_range = new DatePeriod($start_date, $interval, $end_date);
        
        foreach ($date_range as $date) {

            $absents = User::select('id')->get()->random(15)->toArray();
            if (isset($absents) && !empty($absents)) {
                $absent_ids = array_column($absents, 'id');
            }
            $current_date = $date->format('Y-m-d');
            $current_day = date('l', strtotime($current_date));
            if (!in_array(strtolower($current_day), $holiday)) {

                if (isset($users) && !empty($users)) {
                    foreach ($users as $item) {
                        $attendance_status = '<span style="color:#fff">Present</span>(<span>P</span>)';

                        $from_time = '09:00';
                        $to_time = '18:00';
                        if (isset($absent_ids) && in_array($item->id, $absent_ids)) {
                            $from_time = null;
                            $to_time = null;
                            $attendance_status = '<span style="color:#fff">Absence</span>(<span>A</span>)';
                        }
                        $attendance_status = strip_tags($attendance_status);
                        $attendance_status = explode('(', $attendance_status);
                        $ins['academic_id'] = academicYearId();
                        $ins['employment_id'] = $item->id;
                        $ins['attendance_date'] = $current_date;
                        $ins['reporting_manager'] = $item->reporting_manager_id ?? null;
                        $ins['attendance_status'] = current($attendance_status) ?? null;
                        $ins['reason'] = null;
                        
                        $ins['from_time'] = new \Illuminate\Database\Query\Expression("CAST('$from_time' AS TIME)");
                        $ins['to_time'] = new \Illuminate\Database\Query\Expression("CAST('$to_time' AS TIME)");
                        // $ins['total_time'] = getHoursBetweenHours($from_time, $to_time);
                        AttendanceManualEntry::updateOrCreate(['attendance_date' => $current_date, 'employment_id' => $item->id], $ins);
                    }
                }
            }
        }
        /**
         * for end date calculation
         */
        $current_date = $month_end;
        $current_day = date('l', strtotime($current_date));
        if (!in_array(strtolower($current_day), $holiday)) {

            if (isset($users) && !empty($users)) {
                foreach ($users as $item) {

                    $attendance_status = '<span style="color:#fff">Present</span>(<span>P</span>)';

                    $from_time = '09:00';
                    $to_time = '18:00';
                    if (isset($absent_ids) && in_array($item->id, $absent_ids)) {
                        $from_time = null;
                        $to_time = null;
                        $attendance_status = '<span style="color:#fff">Absence</span>(<span>A</span>)';
                    }
                    $attendance_status = strip_tags($attendance_status);
                    $attendance_status = explode('(', $attendance_status);
                    $ins['academic_id'] = academicYearId();
                    $ins['employment_id'] = $item->id;
                    $ins['attendance_date'] = $current_date;
                    $ins['reporting_manager'] = $item->reporting_manager_id ?? null;
                    $ins['attendance_status'] = current($attendance_status) ?? null;
                    $ins['reason'] = null;
                    $ins['from_time'] = new \Illuminate\Database\Query\Expression("CAST('$from_time' AS TIME)");
                    $ins['to_time'] = new \Illuminate\Database\Query\Expression("CAST('$to_time' AS TIME)");
                    
                    AttendanceManualEntry::updateOrCreate(['attendance_date' => $current_date, 'employment_id' => $item->id], $ins);
                }
            }
        }
    }
}
