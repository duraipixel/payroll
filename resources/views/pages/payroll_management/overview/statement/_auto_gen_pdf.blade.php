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
                    <center><h4>AMALORPAVAM HR. SEC. SCHOOL</h4></center>
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
                                <td>Earnings</td>
                                <td>-</td>
                            </tr>
                        @endfor
                    </table>
                </td>
                <td colspan="2" class="none-td">
                    <table class="border-0" style="border-right: 1px solid black !important;">
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td>Deductions</td>
                                <td>-</td>
                            </tr>
                        @endfor
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
