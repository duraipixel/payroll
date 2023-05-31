<table style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
    <tbody>
        <tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
            <td colspan="7"
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
                Nominee required </td>
        </tr>
        <tr>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:5%;">
                Relationship Name</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Relationship</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Date of Birth</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Gender</td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Age
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Share
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                If Minor Nominee Name & Address
            </td>
        </tr>
        
        @if (isset($user->nominees) && count($user->nominees) > 0)
            @foreach ($user->nominees as $item)
                <tr>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->nominee->first_name }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->relationship->name }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{  commonDateFormat($item->dob) }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->gender }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->age }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->share }} %
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{  $item->minor_address ?? '' }}
                        <br>
                        {{ $item->minor_contact_no ?? '' }}
                    </td>
                </tr>
            @endforeach
        @else
        <tr >
            <td colspan="7" style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                No Record found
            </td>
        </tr>
        @endif
    </tbody>
</table>