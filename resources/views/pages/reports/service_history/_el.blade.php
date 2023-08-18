<table style="width: 100%;border:1px solid #ddd" class="common_table">

    <thead style="background: aliceblue;color:black;">
        <tr>
            <th colspan="5" style="text-align: center;padding:3px"> EARNED LEAVE DETAILS </th>
        </tr>
        @if ( isset($hitem['staff_details']->earnedLeaves) && count($hitem['staff_details']->earnedLeaves) > 0)
            <tr style="background: aquamarine">
                <th style="padding: 3px ">S.No</th>
                <th style="padding: 3px ">Reason</th>
                <th style="padding: 3px ">From</th>
                <th style="padding: 3px ">To</th>
                <th style="padding: 3px;text-align:center ">No. of Days</th>
            </tr>
        @endif
    </thead>

    <tbody>
        @if ($hitem['staff_details']->earnedLeaves && count($hitem['staff_details']->earnedLeaves) > 0)
            @foreach ($hitem['staff_details']->earnedLeaves as $leave_item)
            <tr>
                <td style="padding: 3px 10px;">{{$loop->iteration}}</td>
                <td style="padding: 3px 10px;">{{ $leave_item->reason }}</td>
                <td style="padding: 3px 10px;">{{ commonDateFormat($leave_item->from_date) }}</td>
                <td style="padding: 3px 10px;">{{ commonDateFormat($leave_item->to_date) }}</td>
                <td style="text-align: center">{{ $leave_item->no_of_days }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" style="text-align: center"> - NIL - </td>
            </tr>
        @endif
    </tbody>
    @if ($hitem['staff_details']->earnedLeaves && count($hitem['staff_details']->earnedLeaves) > 0)
    <tfoot>
        @php
            $accumulated = getLeaveAccumulated($hitem['staff_details']->appointment->nature_of_employment_id, 'Earned Leave', $hitem['staff_details'] );
            $sanctionted = getAcademicLeaveAllocated( academicYearId(), $hitem['staff_details']->appointment->nature_of_employment_id, 'Earned Leave' );
            $el_total = $accumulated + $sanctionted;
        @endphp
        <tr>
            <td> a. </td>
            <td> EL Accumulated </td>
            <td> {{ $accumulated }} </td>
        </tr>
        <tr>
            <td> b. </td>
            <td> EL sanctioned for ( 2022 - 2023 ) </td>
            <td> {{ $sanctionted }} </td>
        </tr>
        <tr>
            <td> c. </td>
            <td> EL Total (a+b) </td>
            <td> {{ $el_total }} </td>
        </tr>
    </tfoot>
    @endif
</table>