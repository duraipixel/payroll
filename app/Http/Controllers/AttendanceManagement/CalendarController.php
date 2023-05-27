<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Http\Controllers\Controller;
use App\Models\CalendarDays;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getEvent(Request $request)
    {

        $data = CalendarDays::all();
        
        $event_data = [];
        $new_array = [];
        $staff_id = $request->staff_id;
        if (isset($data) && !empty($data)) {
            foreach ($data as $items) {
                $event_data[] = array(
                    'id' => $items->id,
                    'title' => $items->comments ?? ucwords(str_replace('_', ' ', $items->days_type)),
                    'start' => $items->calendar_date,
                    'end' => $items->calendar_date,
                    'rendering' => 'background',
                    'color' => $items->days_type == 'working_day' ? '#16b31d' : ($items->days_type == 'week_off' ? 'orange':'#f90d0d'),
                    'display' => 'background'
                );

                $new_array[] = array(
                    'id'   => $items->id,
                    'title' => $items->comments ?? ucwords(str_replace('_', ' ', $items->days_type)),
                    'start' => $items->calendar_date,
                    'end' => $items->calendar_date,
                    // 'end' => date('Y-m-d', strtotime($items->end_date . ' +1 day')),
                    // 'color' => $items->days_type == 'working_day' ? '#16b31d' : '#f90d0d',
                    'color' => $items->days_type == 'working_day' ? '#16b31d' : ($items->days_type == 'week_off' ? 'orange':'#f90d0d'),
                    'rendering' => 'background',                    
                    // 'height' => '200'
                );

                if( isset( $staff_id ) && !empty( $staff_id ) ){

                }
            }
        }
        
        return response()->json($new_array);
    }

    public function setEvent(Request $request)
    {

        $day_type = $request->day_type;
        $dateSelected = $request->dateSelected;
        $from = $request->from;
        $to = $request->to;

        $period = new DatePeriod(
            new DateTime($from),
            new DateInterval('P1D'),
            new DateTime($to)
        );

        foreach ($period as $key => $value) {

            $dateSelected = $value->format('Y-m-d');

            $ins['year'] = date('Y', strtotime($dateSelected));
            $ins['month'] = date('F', strtotime($dateSelected));;
            $ins['calendar_date'] = $dateSelected;
            $ins['days_type'] = $day_type;
            $ins['comments'] = $request->comments;
            $ins['institute_id'] = session()->get('staff_institute_id') ?? null;
            $ins['academic_id'] = session()->get('academic_id') ?? null;

            CalendarDays::updateOrCreate(['calendar_date' => $dateSelected], $ins);
        }

        return array('error' => 0, 'message' => 'Days has been set success');
    }

    public function getDaysCount(Request $request)
    {
        
        $date = $request->date;
        $month_start = date('Y-m-1',strtotime($date));
        $month_end = date('Y-m-t',strtotime($date));
        
        $working_days = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'working_day')->count();
        $holidays = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'holiday')->count();
        $week_off = CalendarDays::whereBetween('calendar_date', [$month_start, $month_end])->where('days_type', 'week_off')->count();
        $params = array('working_days' => $working_days, 'holidays' => $holidays, 'week_off' => $week_off);
        return view('pages.leave._days_count', $params);

    }

}
