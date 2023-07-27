<!DOCTYPE html>
<html lang="en">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: lightgray !important
    }

    .none-td {
        padding: 0 !important;
        border: none !important
    }

    .border-0 {
        border-left: 1px solid black !important;
    }

    .border-0 td:nth-child(1) {
        border-top: none !important;
        border-left: none !important;
    }

    .border-0 td:nth-last-child(1) {
        border-top: none !important;
        border-right: none !important;
    }
</style>

<body>
    <table class="border">
        <thead>
            <tr>
                <th colspan="4">
                    <center>
                        <h4>{{ $institution_name ?? '' }}</h4>
                    </center>
                    </td>
            </tr>
            <tr>
                <th colspan="4">
                    <center>{{ $institution_address ?? '' }}</center>
                    </td>
            </tr>
            <tr>
                <th colspan="4">
                    <center> {{ $pay_month ?? '' }}</center>
                </th>
            </tr>
            <tr>
                <th colspan="2"> Name </td>
                <td colspan="2"> {{ $info->staff->name ?? '' }}</td>
            </tr>
            <tr>
                <th colspan="2"> Designation </td>
                <td colspan="2"> {{ $info->staff->position->designation->name ?? '' }} </td>
            </tr>
            <tr>
                <th colspan="2"> Employee Code </td>
                <td colspan="2"> {{ $info->staff->institute_emp_code ?? '' }} </td>
            </tr>
            <tr>
                <th colspan="2"> Date </td>
                <td colspan="2"> {{ $date }}</td>
            </tr>
            <tr>
                <th colspan="2"> Earnings </td>
                <th colspan="2"> Deductions </td>
            </tr>
        </thead>
        <tbody>
            <tr style="margin: 0 !important">
                <td colspan="2" class="" style="vertical-align: top;padding:0px;">
                    <table class="none-td">
                        @if (isset($info->earnings) && count($info->earnings))
                            @foreach ($info->earnings as $item)
                                <tr>
                                    <td style="width: 60%;border-left:none;"> {{ $item->field_name }}</td>
                                    <td style="width: 40%;text-align:right;border-right:none"> {{ $item->amount }} </td>
                                </tr>
                            @endforeach
                        @endif
                       
                    </table>
                </td>
                <td colspan="2" class="" style="vertical-align: top;padding:0px;">
                    <table class="none-td">
                        @if (isset($info->deductions) && count($info->deductions))
                            @foreach ($info->deductions as $item)
                                <tr>
                                    <td style="width: 60%;border-left:none;"> {{ $item->field_name }}</td>
                                    <td style="width: 40%;text-align:right;border-right:none"> {{ $item->amount }} </td>
                                </tr>
                            @endforeach
                        @endif
                       
                    </table>
                </td>
                
            </tr>
            <tr style="margin: 0 !important">
                <td colspan="2" style="padding:0px;">
                    <table class="none-td">
                        <tr>
                            <th style="width: 60%;border-top:none;border-left:none;border-bottom:none;border-top:none !important;">
                                Gross
                            </th>
                            <td style="width: 40%;border-top:none;text-align:right;border-right:none;border-bottom:none">
                                {{ RsFormat($info->gross_salary) }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" style="padding: 0px;">
                    <table class="none-td">
                        <tr>
                            <th style="width: 60%;border-top:none;border-left:none;border-bottom:none;border-top:none !important;">
                                Deductions
                            </th>
                            <td style="width: 40%;border-top:none;text-align:right;border-right:none;border-bottom:none">
                                {{ RsFormat(  $info->total_deductions  ) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="margin: 0 !important">
                <td colspan="2" style="border-top:none;border-right:none;">
                </td>
                <td colspan="2" style="padding: 0px;">
                    <table class="none-td">
                        <tr>
                            <th style="width: 60%;border-top:none;border-bottom:none;border-let:none;">
                                Net Salary
                            </th>
                            <td style="width: 40%;border-top:none;text-align:right;border-bottom:none">
                                {{ RsFormat( $info->net_salary ) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    "Do not work for the food that perishes, but for the food that endures for eternal life"
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Note: This computer generated salary slip cannot be produced any where as an authenticated
                    certificate.
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
