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
                @endphp
                @if (count($item->Attendance))
                @for ($i = 0; $i < $no_of_days; $i++)
                    @php
                        $search_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));
                        $attendanceRecord = $item->Attendance->where('attendance_date', $search_date)->first();
                        $status = $attendanceRecord ? $attendanceRecord->attendance_status : '';
                        
                        if($status =='Present'){
                        $present +=1;
                        }elseif($status=='Absence'){

                        }else{
                            $present +=1;
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
                        <b style="color:red;font-size: 10px;">U/A</b>
                    @endif
                    </td>
                    {{-- <td class="text-center"> {{ $search_date }}</td> --}}
                @endfor
                @else 
                    @for ($i = 0; $i < $month_days; $i++)
                        <td class="text-center" style="color:red;font-size: 10px;"><b>U/A</b></td>
                    @endfor
                @endif
                <td>{{ $month_days }}</td>
                <td>{{ $present }}</td>
                <td>{{ $month_days-$present}}</td>
                <td>{{ count($item->Attendance) }}</td>
                <td>{{ count($item->AttendancePresent) }}</td>
                <td>{{ abs(count($item->Attendance) - count($item->AttendancePresent)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
