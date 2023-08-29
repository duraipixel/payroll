<!DOCTYPE html>
<html lang="en">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    .border td,
    .border th {
        border: 0.5px solid rgb(23, 23, 23);
        padding: 5px;
        font-size: 12px;
    }

    .w-50 {
        width: 50% !important;
    }

    .w-100 {
        width: 100% !important;
    }
</style>

<body>
    <table>
        <thead>
            <tr>
                <th colspan="4">
                    <center>
                        <label style="display: block">AMALORPAVAM HR. SEC. SCHOOL</label>
                        <label style="display: block">Lourdes Campus, Vanarapet, Puducherry.</label>
                    </center>
                </th>
            </tr>

            <tr>
                <th colspan="4" style="padding-top: 5px;">
                    <center> Form for assessing of Gratuity</center>
                </th>
            </tr>
            <tr>
                <th colspan="4" style="font-size: 13px;padding-top:10px;padding-bottom:10px;">
                    <center>RESIGNED STAFF</center>
                </th>
            </tr>
        </thead>
    </table>
    <table class="border w-100">
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Name of the Staff </td>
            <td style="text-align: left;width:50%;padding-left:10px"> {{ $staff_info->name }} </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Name of the Husband </td>
            <td style="text-align: left;width:50%;padding-left:10px"> {{ $staff_info->familyMembers?->husband?->first_name ?? '-' }} </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Employee Code </td>
            <td style="text-align: left;width:50%;padding-left:10px"> {{ $staff_info->institute_emp_code }}</td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Date of Birth </td>
            <td style="text-align: left;width:50%;padding-left:10px">{{ commonDateFormat( $staff_info->personal->dob ) }}</td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px;color:#959595" colspan="2"> 
                Particulars of post held at the time of retirement 
            </th>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> a) Last Post held </th>
            <td style="text-align: left;width:50%;padding-left:10px"> {{  $staff_info->appointment?->designation?->name ?? '' }} </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> b) Date of Regularization on </th>
            <td style="text-align: left;width:50%;padding-left:10px"> {{ commonDateFormat( $staff_info->appointment?->from_appointment ?? '' ) }} </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Date of ending of Service </th>
            <td style="text-align: left;width:50%;padding-left:10px"> {{ commonDateFormat( $staff_info->appointment?->to_appointment ?? '' ) }}  </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Cause of ending Service </th>
            <td style="text-align: left;width:50%;padding-left:10px"> Superannuation </td>
        </tr>
    </table>
    <table class="border">
        <tbody>
            <tr>
                <th rowspan="2" style="width:40%">
                    Name of the Institution
                </th>
                <th rowspan="2" style="width: 20%">
                    Last Post held
                </th>
                <th colspan="2" style="width:40%">
                    Period
                </th>
            </tr>
            <tr>
                <th>
                    From
                </th>
                <th>
                    To
                </th>
            </tr>
            <tr>
                <td style="width: 40%;padding-left:5px">
                    {{ $staff_info->institute->name ?? '' }}
                </td>
                <td style="width: 20%;text-align:center;">
                    {{  $staff_info->appointment?->designation?->name ?? '' }}
                </td>
                <td style="width: 20%;text-align:center;">
                    {{ commonDateFormat( $staff_info->appointment?->from_appointment ?? '' ) }} 
                </td>
                <td style="width: 20%;text-align:center;">
                    {{ commonDateFormat( $staff_info->appointment?->to_appointment ?? '' ) }}
                </td>
            </tr>
        </tbody>
    </table>
    <table class="border w-100">
       
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Gross service </th>
            <td style="text-align: left;width:50%;padding-left:10px"> 3 Years and 8 Months </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Extraordinary Leave not counting as qualifying
                service. 
            </th>
            <td style="text-align: left;width:50%;padding-left:10px">
            </td>
        </tr>

        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Periods of suspension not treated as qualifying
                service 
            </th>
            <td style="text-align: left;width:50%;padding-left:10px">
            </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Net qualifying service </th>
            <td style="text-align: left;width:50%;padding-left:10px">
            </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px">
                Qualifying service expressed in terms of completed
                six monthly periods (period of three months and over is treated as completed six monthly period)
            </th>
            <td style="text-align: left;width:50%;padding-left:10px">
            </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px" colspan="2">Emoluments last drawn</th>
        </tr>
        <tr>
            <td style="text-align: left;width:50%;padding-left:5px"> Basic </td>
            <td style="text-align: left;width:50%;padding-left:10px"> Rs.23556 </td>
        </tr>
        <tr>
            <td style="text-align: left;width:50%;padding-left:5px"> Basic </td>
            <td style="text-align: left;width:50%;padding-left:10px"> Rs.23556 </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Total Emoluments </th>
            <td style="text-align: left;width:50%;padding-left:10px"> Rs.42474.00 </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px">Gratuity Calculation</th>
            <td style="text-align: left;width:50%;padding-left:10px"> Rs.42474.00 </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px">
                Whether nomination made for death gratuity / retirement gratuity
            </th>
            <td style="text-align: left;width:50%;padding-left:10px"> Retired Gratuity. </td>
        </tr>
        <tr>
            <th style="text-align: left;width:50%;padding-left:5px"> Total Payable of retirement Gratuity </th>
            <td style="text-align: left;width:50%;padding-left:10px"> Rs.42474.00 </td>
        </tr>
    </table>
    <table style="padding-top:10px;margin-top:70px;font-size:12px;">
        <tr>
            <th style="text-align: left;">
               Date
            </th>
            <th style="text-align: right;">
                Signature of the Head of the Institution.
            </th>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;padding-top:20px;">
                I  have verified the above said  calculations & accept  the same.
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:right;padding-top:60px;">
                Signature of the Staff.</td>
        </tr>
     
    </table>
</body>

</html>
