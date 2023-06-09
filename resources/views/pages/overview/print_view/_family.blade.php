<table class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
    <tbody>
        <tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
            <td colspan="12"
                style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;
                        height:0px;">
                Family Information</td>
        </tr>
        <tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
            <td colspan="15"
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
                Family Details</td>
        </tr>
        <tr>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:5%;">
                Relationship Type</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Name</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Date of Birth</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Qualification </td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Profession / Studying</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Address</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Contact No</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Blood Group</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Nationality</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Remarks</td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Son / Daughter</td>
        </tr>
        
        @if (isset($user->familyMembers) && !empty($user->familyMembers))
            @foreach ($user->familyMembers as $item)
                <tr>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->relationship->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->first_name }}
                        <br>{{ ucfirst($item->gender) }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ isset($item->dob) && !empty($item->dob) ? commonDateFormat($item->dob) : '' }} <br> Age - {{ $item->age ?? 0 }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->qualification->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->profession ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->residential_address ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->contact_no ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->bloodGroup->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->nationality->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->remarks ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;"> 
                        {{ $item->premises ?? '' }}
                        <br>
                        {{ $item->registration_no ?? '' }}
                        <br>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>
