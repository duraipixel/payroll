<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th class="text-center"><small class="fw-bold">Staff Name</small></th>
            <th class="text-center"><small class="fw-bold">EMP code</small></th> 
            @for ($i = 0; $i < $month_days; $i++)
                <th class="text-center"><small class="fw-bold">{{ $i + 1 }}</small></th>
            @endfor
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
                @if (count($item->Attendance))
                    @for ($i = 0; $i < $month_days; $i++)
                        @if (isset($item->Attendance[$i]))
                            @if ($item->Attendance[$i]['attendance_status'] === 'Present')
                                <td><i style="font-size: 10px" class="text-primary fa fa-check"></i></td>
                            @else
                                <td><i style="font-size: 10px" class="text-danger fa fa-times"></i></td>
                            @endif
                        @else
                            <td class="text-center">-</td>
                        @endif
                    @endfor
                @else
                    @for ($i = 0; $i < $month_days; $i++)
                        <td class="text-center">-</td>
                    @endfor
                @endif
                <td>{{ count($item->Attendance) }}</td>
                <td>{{ count($item->AttendancePresent) }}</td>
                <td>{{ abs(count($item->Attendance) - count($item->AttendancePresent)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>