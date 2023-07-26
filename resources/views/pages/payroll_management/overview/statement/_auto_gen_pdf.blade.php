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
                        <h4>AMALORPAVAM HR. SEC. SCHOOL</h4>
                    </center>
                    </td>
            </tr>
            <tr>
                <th colspan="4">
                    <center>Lourdes Campus, Vanarapet, Puducherry - 605001</center>
                    </td>
            </tr>
            <tr>
                <th colspan="4">
                    <center>Pay Slip for the month of MMM-YYYY (EG.Feb – 2023)</center>
                </th>
            </tr>
            <tr>
                <th colspan="2"> Name </td>
                <td colspan="2"> durerlje</td>
            </tr>
            <tr>
                <th colspan="2"> Designation </td>
                <td colspan="2"> stetisgdsg </td>
            </tr>
            <tr>
                <th colspan="2"> Date </td>
                <td colspan="2"> dd/mm/yyyy </td>
            </tr>
            <tr>
                <th colspan="2"> Earnings </td>
                <th colspan="2"> Deductions </td>
            </tr>
        </thead>
        <tbody>
            <tr style="margin: 0 !important">
                <td colspan="2" class="none-td">
                    <table class="border-0">
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td style="width: 60%">Earnings</td>
                                <td style="width: 40%;text-align:right"> 450000</td>
                            </tr>
                        @endfor
                        <tr>
                            <td style="width: 60%">Gross</td>
                            <td style="width: 40%;text-align:right"> 450000</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" class="none-td">
                    <table class="border-0" style="border-right: 1px solid black !important;">
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td style="width: 60%">Tax</td>
                                <td style="width: 40%;text-align:right"> 0</td>
                            </tr>
                        @endfor
                        <tr>
                            <td style="width: 60%">Deductions</td>
                            <td style="width: 40%;text-align:right"> 0</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="margin: 0 !important">
                <td colspan="2" style="border-top:none;border-right:none;">
                </td>
                <td colspan="2" class="none-td">
                    <table>
                        <tr>
                            <th style="width: 60%;border-top:none;border-bottom:none">
                                Net Salary
                            </th>
                            <td style="width: 40%;border-top:none;text-align:right;border-bottom:none">
                                898989
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
                    Note: This computer generated salary slip cannot be produced any where as an authenticated certificate.
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
