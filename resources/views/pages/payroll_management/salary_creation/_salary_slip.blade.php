<style>
    #salary_table {
        border-collapse: separate;
        border-spacing: 0;
        /* border: 1px solid #5d5858; */
    }

    .inner_table {
        /* border: none; */
        border-collapse: separate;
        border-spacing: 0;
    }

    .bl-none {
        border-left: none !important;
    }

    .br-none {
        border-right: none !important;
    }

    .bt-none {
        border-top: none !important;
    }

    .bb-none {
        border-bottom: none !important;
    }

    #salary_table td,
    th {
        border: 1px solid #5d5858;
        padding: 5px;
        font-size: 12px;
        /* height: 30px; */
    }
</style>
<table class="table " id="salary_table" border-spacing="0" style="width: 100%">
    <tr>
        <td colspan="4" style="text-align: center;font-weight:bold;font-size:16px;" class="bb-none">
            {{ $staff_info->institute->name ?? '' }} </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center;font-weight:bold;font-size:14px;" class="bb-none">
            {{ $staff_info->appointment->work_place->name ?? '' }} </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center;font-weight:bold;" class="bb-none">
            Pay Slip for the month of @if ($salary_info->salary_month && !empty($salary_info->salary_month))
                {{ $salary_info->salary_month }}
                {{ $salary_info->salary_year }}
            @else
                {{ date('M Y', strtotime($salary_info->created_at)) }}
            @endif
        </td>

    </tr>
    <tr>
        <td style="font-weight:bold;" class="bb-none ">Name</td>
        <td colspan="3" class="bb-none bl-none">{{ $staff_info->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;" class="bb-none ">Designation</td>
        <td colspan="3" class="bb-none bl-none"> {{ $staff_info->position->designation->name ?? 'N/A' }} </td>
    </tr>
    <tr>
        <td style="font-weight:bold;" class="bb-none ">Date</td>
        <td colspan="3" class="bb-none bl-none">
            @if (isset($staff_info->personal->dob))
                {{ date('d/M/Y', strtotime($staff_info->personal->dob)) }}
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="2" class="bb-none " style="font-weight:bold;background: #2a82cf; color: white;">
            Earnings
        </td>
        <td colspan="2" class="bb-none bl-none" style="font-weight:bold;background: #2a82cf; color: white;"> Deductions </td>
    </tr>
    <tr>
        <td colspan="2" style="padding:0px" class="">
            @if (isset($salary_info->earnings) && !empty($salary_info->earnings))
                <table style="width:100%" class="inner_table">
                    @php
                        $start = 1;
                        $earing_total_row = count($salary_info->earnings);
                    @endphp
                    @foreach ($salary_info->earnings as $item)
                        @if ($start == 1)
                            <tr>
                                <td style="width:60%;font-weight:bold;" class="bt-none bl-none">
                                    {{ strtoupper($item->field_name) }}
                                </td>
                                <td style="width:40%;text-align:right" class="bt-none br-none bl-none">{{ $item->amount }}</td>
                            </tr>
                        @elseif($start == $earing_total_row)
                            <tr>
                                <td style="width:60%;font-weight:bold;" class="bb-none bl-none bt-none">
                                    {{ strtoupper($item->field_name) }}
                                </td>
                                <td style="width:40%;text-align:right" class="bb-none br-none bl-none bt-none">{{ $item->amount }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td style="width:60%;font-weight:bold;" class="bt-none bl-none">
                                    {{ strtoupper($item->field_name) }}
                                </td>
                                <td style="width:40%;text-align:right" class="bt-none br-none bl-none">{{ $item->amount }}
                                </td>
                            </tr>
                        @endif

                        @php
                            $start++;
                        @endphp
                    @endforeach


                </table>
            @endif
        </td>
        <td colspan="2" style="padding:0px;" class="bl-none">
            @if (isset($salary_info->deductions) && !empty($salary_info->deductions))
                <table style="width:100%" class="inner_table">
                    @php
                        $start = 1;
                        $deduction_total_row = count($salary_info->deductions);
                    @endphp
                    @foreach ($salary_info->deductions as $item)
                        @if ($start == 1)
                            <tr>
                                <td style="width:60%;font-weight:bold;" class="bt-none bl-none">
                                    {{ strtoupper($item->field_name) }}
                                </td>
                                <td style="width:40%;text-align:right" class="bt-none br-none">{{ $item->amount }}</td>
                            </tr>
                        @elseif($start == $earing_total_row)
                            <tr>
                                <td style="width:60%;font-weight:bold;" class="bb-none bl-none">
                                    {{ strtoupper($item->field_name) }}
                                </td>
                                <td style="width:40%;text-align:right" class="bb-none br-none">{{ $item->amount }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td style="width:60%;font-weight:bold;" class="bt-none bl-none">
                                    {{ strtoupper($item->field_name) }}
                                </td>
                                <td style="width:40%;text-align:right" class="bt-none br-none">{{ $item->amount }}
                                </td>
                            </tr>
                        @endif

                        @php
                            $start++;
                        @endphp
                    @endforeach
                    @if ($earing_total_row > $deduction_total_row)
                        @php
                            $extra_deduct_row = $earing_total_row - $deduction_total_row;
                        @endphp
                        @for ($i = 0; $i < $extra_deduct_row; $i++)
                            {{-- <tr>
                        <td></td>
                        <td></td>
                    </tr> --}}
                        @endfor
                    @endif
                    <tr></tr>


                </table>
            @endif

        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding:0px;" class="bt-none">
            <table style="width:100%" class="inner_table">
                <tr style="margin-top:10px;">
                    <td style="width:60%;font-weight:bold;" class="bb-none bt-none bl-none"> Gross
                    </td>
                    <td style="width:40%" class="bt-none br-none bl-none bb-none">
                        {{ $salary_info->total_earnings }} </td>
                </tr>
            </table>
        </td>
        <td colspan="2" style="padding:0px;" class="bt-none bl-none">
            <table style="width:100%" class="inner_table">
                <tr style="margin-top:10px;">
                    <td style="width:60%;font-weight:bold;" class="bt-none bl-none bb-none">
                        Deductions </td>
                    <td style="width:40%" class="bt-none br-none bb-none">
                        {{ $salary_info->total_deductions }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="bb-none bt-none"></td>
        <td colspan="2" style="padding:0px;" class="bt-none bl-none bb-none">
            <table style="width:100%" class="inner_table">
                <tr>
                    <td style="width:60%;font-weight:bold;" class="bt-none bb-none bl-none"> Net
                        Salary </td>
                    <td style="width:40%;font-weight:bold;" class="bt-none bb-none br-none">
                        {{ $salary_info->net_salary }} </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="bb-none">
            "Do not work for the food that perishes, but for the food that endures for eternal life."
        </td>
    </tr>
    <tr>
        <td colspan="4">
            Note : This computer generated salary slip cannot be produced any where as an authenticated certificate.
        </td>
    </tr>
    <tr></tr>
</table>
