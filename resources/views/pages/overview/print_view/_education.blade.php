<table style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
    <tbody>
        
        <tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
            <td colspan="12"
                style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;
                        height:0px;">
                Education Qualification</td>
        </tr>
        <tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
            <td colspan="12"
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
                Completed / Under going</td>
        </tr>
        <tr>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:5%;">
                Sl.No</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Course Completed</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Board/University</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Year of Completion</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Main Subject</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Ancillary Subject</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Submitted Date</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Returned Date</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Type</td>
        </tr>
        @if (isset($user->education) && !empty($user->education))
            @foreach ($user->education as $item)
                <tr>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->course_name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->boards->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->course_completed_year }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->mainSubject->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->axSubject->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->submitted_date ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->returned_date ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->eduType->name ?? '' }}
                    </td>
                </tr>
            @endforeach
        @endif


    </tbody>
</table>
