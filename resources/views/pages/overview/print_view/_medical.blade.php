<table class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
    <tbody>
        <tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
            <td colspan="12"
                style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;
                        height:0px;">
                Medical Information</td>
        </tr>
        <tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
            <td colspan="15"
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
                Medical Details</td>
        </tr>
        
        <tr>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Blood Group
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->bloog_group->name ?? 'N/A' }}
            </td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Height in Cms </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->height ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Weight in Kgs
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->weight ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Identification mark
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->identification_mark ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Identification mark - 1
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->identification_mark1 ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Identification mark - 2
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->identification_mark2 ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Disease Allergy
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->disease_allergy ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Differently abled 
            </td>
            <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                {{ $user->healthDetails->differently_abled ?? 'N/A' }}
            </td>
        </tr>


    </tbody>
</table>