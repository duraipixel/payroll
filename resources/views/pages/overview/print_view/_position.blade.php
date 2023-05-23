{{-- {{ dd( $user->position ) }} --}}
<tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
    <td colspan="8"
        style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;height:0px;">
        Employee Position
    </td>
</tr>

<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="8"
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Employee Details
    </td>
</tr>

<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Designation
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->position->designation->name ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Department
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->position->department->name ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Division
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->position->division->name ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Attendance Scheme
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->position->attendance_scheme->name ?? '' }}
    </td>
</tr>
<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Class Handling
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->handlingClassNames->handling_classes ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Subject </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->handlingSubjectNames->handling_subjects ?? '' }}
    </td>
</tr>

<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="8"
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Bank Details
    </td>
</tr>

<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Bank Name
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->bank->bankDetails->name ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        IFSC Code
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->bank->bankBranch->ifsc_code ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Account Name
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->bank->account_name ?? '' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Account Number
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->bank->account_number ?? '' }}
    </td>

</tr>

<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        UAN Number
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->pf->ac_number ?? 'n/a' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Esi No
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->esi->ac_number ?? 'n/a' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Area
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->esi->location ?? 'n/a' }}
    </td>
</tr>

<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="8"
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Identity Details</td>
</tr>

@if (isset($user->staffDocuments) && !empty($user->staffDocuments))
    <tr>
        @foreach ($user->staffDocuments as $sitem)
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                {{ ucwords($sitem->documentType->name ?? '') }}
            </td>
        @endforeach

    </tr>
@endif
@if (isset($user->staffDocuments) && !empty($user->staffDocuments))
    <tr>
        @foreach ($user->staffDocuments as $sitem)
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                {{ $sitem->description ?? '' }}
                <br>
                {{ $sitem->doc_number }}
            </td>
        @endforeach

    </tr>
@endif
