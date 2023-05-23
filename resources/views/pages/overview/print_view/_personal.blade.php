
<tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
    <td colspan="8" style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;
                height:0px;font-weight:bold;">
        Personal Information
    </td>
</tr>

<tr>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;    font-size: 12px;">
        Emp Society Code</td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;    font-size: 13px;font-weight:bold;">
        <strong>{{ $user->society_emp_code }}</strong>
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;    font-size: 12px;">
        Emp Institution Code
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;    font-size: 13px;font-weight:bold;">
        <strong>{{ $user->institute_emp_code }}</strong>
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;    font-size: 12px;">
        Emp. Code</td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;    font-size: 13px;font-weight:bold;">
        <strong>{{ $user->emp_code }}</strong>
    </td>
</tr>
<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="8" style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Personal Details</td>
</tr>
<tr>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Name (In English)
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->name }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Name (In Tamil)
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->first_name_tamil ?? '-' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Short Name
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->short_name ?? '-' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Institution Type
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->institute->name ?? '-' }}
    </td>
</tr>
<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Category of Staff</td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->appointment->staffCategory->name ?? '-' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Nature of Employment
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->appointment->employment_nature->name ?? '-' }}
    </td>

    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Teaching Type
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->appointment->teachingType->name ?? '-' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Place of Work
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->appointment->work_place->name ?? '-' }}
    </td>
</tr>
<tr>
    {{-- <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Level</td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Level 32
    </td> --}}
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Reporting Manager 
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->reporting->name ?? '-' }}
    </td>
</tr>
