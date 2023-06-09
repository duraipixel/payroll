
<tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
    <td colspan="8"
        style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;
                height:0px;">
        Basic Information
    </td>
</tr>

<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="8"
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Basic Details
    </td>
</tr>
<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Date of Birth
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ isset($user->personal->dob) && !empty($user->personal->dob) ? commonDateFormat($user->personal->dob) : 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Gender
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ ucfirst( $user->personal->gender ?? 'N/A') }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Date of Joining
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{-- 15/05/2019 --}}
        N/A
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Marital Status
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ ucfirst($user->personal->marital_status ?? 'N/A') }}
    </td>
</tr>
<tr>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Marriage Date
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ isset($user->personal->marriage_date) && !empty($user->personal->marriage_date) ? commonDateFormat($user->personal->marriage_date) : 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Mother Tongue
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->motherTongue->name ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Place of Birth
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->birthPlace->name ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Nationality 
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->nationality->name ?? 'N/A' }}
    </td>
</tr>
<tr>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Religion
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->religion->name ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Caste
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->caste->name ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Community
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->community->name ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Email Id 
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->email ?? 'n/a' }}
    </td>
</tr>

<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Phone No
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->phone_no ?? 'N/A' }}
    </td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Mobile No - 1 
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->mobile_no1 ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Mobile No - 2 
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->mobile_no2 ?? 'N/A' }}
    </td>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Whatsapp No. 
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->whatsapp_no ?? 'N/A' }}
    </td>
</tr>
<tr>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Emergency No
    </td>
    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->emergency_no ?? 'N/A' }}
    </td>
</tr>
<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Contact Address
    </td>
    <td colspan="7" style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->contact_address ?? 'n/a' }}
    </td>
</tr>
<tr>
    <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
        Permanent Address
    </td>
    <td colspan="7" style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
        {{ $user->personal->permanent_address ?? 'n/a' }}
    </td>
</tr>