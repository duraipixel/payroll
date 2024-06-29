<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th class="text-center"><small class="fw-bold">Staff Name</small></th>
            <th class="text-center"><small class="fw-bold">EMP code</small></th>
            @for ($i = 1; $i <= $no_of_days; $i++)
                <th class="text-center"><small class="fw-bold">{{ $i }}</small></th>
            @endfor
            <th class="text-center"><small class="fw-bold">Month Total Days</small></th>
            <th class="text-center"><small class="fw-bold">Month Present Days</small></th>
            <th class="text-center"><small class="fw-bold">Month Absent Days</small></th>
            <th class="text-center"><small class="fw-bold">Total Days</small></th>
            <th class="text-center"><small class="fw-bold">Present Days</small></th>
            <th class="text-center"><small class="fw-bold">Absent Days</small></th>
        </tr>
    </thead>
    <tbody class="border">
        @foreach ($attendance as $item)
       
            <tr>
                <td><small style="font-size: 10px">{{ $item->name }}</small></td>
                <td><small style="font-size: 10px">{{ $item->society_emp_code }}</small></td>
                @php
                $present=0;
                $month_total= getAttendanceYearMonth(date('m', strtotime($start_date)),date('Y', strtotime($start_date)));
                $year_total=getAttendanceYear(date('Y', strtotime($start_date)));
                @endphp
                @if (count($item->Attendance))
                @for ($i = 0; $i < $no_of_days; $i++)
                    @php
                        $search_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));
                        $attendanceRecord = $item->Attendance->where('attendance_date', $search_date)->first();
                        $status = $attendanceRecord ? $attendanceRecord->attendance_status : '';
                        
                        if($status =='Present'){
                          $present +=1;
                        }
                        $calander_status=getCalanderStatus($search_date);
                        if(isset($calander_status) && !empty($calander_status->comments)){
                            $key_word=formatWord($calander_status->comments);
                        }
                    @endphp

                    <td>
                    @if($status === 'Present')
                        <b style="color:green;font-size: 10px;">P</b>
                    @elseif($status=='Absence')
                    @if(getSortStaffLeaveType($item->id,$attendanceRecord->attendance_date)=='')
                    <b style="color:red;font-size: 10px;">U/A</b>
                    @else
                    <b style="color:blue;font-size: 10px;">{{ getSortStaffLeaveType($item->id,$attendanceRecord->attendance_date) }}</b>
                    @endif
                    @else
                    @if(isset($calander_status) && !empty($calander_status->days_type))
                    @if($calander_status->days_type=='holiday')
                    <b style="color:black;font-size: 10px;">{{$key_word ??'WO'}}</b>
                    @elseif($calander_status->days_type=='week_off')
                    <b style="color:black;font-size: 10px;">WO</b>
                    @else
                    <b style="color:red;font-size: 10px;">U/A</b>
                    @endif
                    @endif
                    @endif
                    </td>
                    
                @endfor
                @else 
                    @for ($i = 0; $i < $month_days; $i++)
                    <td  class="text-center">
                    @if(isset($calander_status) && !empty($calander_status))
                    @if($calander_status->days_type=='holiday')
                    <b style="color:black;font-size: 10px;">{{$key_word ??'WO'}}</b>
                    @elseif($calander_status->days_type=='week_off')
                    <b style="color:black;font-size: 10px;">WO</b>
                    @else
                    <b style="color:red;font-size: 10px;">U/A</b>
                    @endif
                    @endif
                    </td>
                    @endfor
                @endif
                <td>{{ $month_total }}</td>
                <td>{{ $present }}</td>
                <td>{{ $month_total-$present}}</td>
                <td>{{ $year_total }}</td>
                <td>{{ count($item->AttendancePresent) }}</td>
                <td>{{ abs($year_total - count($item->AttendancePresent)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
