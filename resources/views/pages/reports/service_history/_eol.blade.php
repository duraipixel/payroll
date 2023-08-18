<table style="width: 100%;border:1px solid #ddd">

    <thead style="background: aliceblue;color:black;">
        <tr>
            <th colspan="5" style="text-align: center;padding:3px">EOL DETAILS</th>
        </tr>
        @if ( isset($hitem['staff_details']->casualLeaves) && count($hitem['staff_details']->casualLeaves) > 0)
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
        @if ($hitem['staff_details']->casualLeaves && count($hitem['staff_details']->casualLeaves) > 0)
            @foreach ($hitem['staff_details']->casualLeaves as $leave_item)
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
</table>