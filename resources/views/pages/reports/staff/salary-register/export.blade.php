<table border="1">
    <thead>
        <tr>
            <th> S. No. </th>
            <th> Emp ID </th>
            <th> DOJ </th>
            <th> NAME </th>
            <th>  Workdays </th>
                            @if (isset($earings_field) && !empty($earings_field))
                    @foreach ($earings_field as $eitem)
                        <th>
                            {{ $eitem->short_name }}
                        </th>
                    @endforeach
                    <th>
                        Gross
                    </th>
                @endif
                @if (isset($deductions_field) && !empty($deductions_field))
                    @foreach ($deductions_field as $sitem)
                        <th>
                            {{ $sitem->short_name }}
                        </th>
                    @endforeach
                    <th>
                        Total Deduction
                    </th>
                @endif
                <th>Net Pay</th>
        </tr>
    </thead>
    <tbody>
            @php

            $total_net_pay = 0;
            @endphp
            @if (isset($salary_info) && !empty($salary_info))
                @foreach ($salary_info as $key=>$item)
                    <tr>
                         <td class="sticky-col first-col px-3">
                            {{ $key+1 }}
                        </td>
                        <td class="sticky-col first-col px-3">
                            {{ $item->staff->society_emp_code ?? '' }}
                        </td>
                        <td class="sticky-col second-col px-3">
                         
                    <a href="{{ url('payroll/download',$item->id) }}" target="_blank">
                                <i class="fa fa-file-pdf text-danger px-1"></i>
                            </a>
                   
                            {{ $item->staff->name ?? '' }}
                        </td>
                        <td class="px-3">
                            {{ $item->staff->firstAppointment->joining_date ?? '' }}
                        </td>

                        <td class="px-3">
                            {{ $item->working_days ?? 0 }}
                        </td>
                        @if (isset($earings_field) && !empty($earings_field))
                            @foreach ($earings_field as $eitem)
                                <td class="px-3">
                                    {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name)) }}
                                </td>
                            @endforeach
                            <td class="px-3">
                                {{ amountFormat($item->gross_salary) }}
                            </td>
                        @endif
                        @if (isset($deductions_field) && !empty($deductions_field))
                            @foreach ($deductions_field as $sitem)
                                <td class="px-3">
                                    {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS')) }}
                                </td>
                            @endforeach
                            <td class="px-3">
                                {{ amountFormat($item->total_deductions) }}
                            </td>
                        @endif
                        <td class="px-3">
                            {{ RsFormat($item->net_salary) }}
                        </td>
                    </tr>
                @endforeach
            @else 
                <tr>
                    <td> No Payroll records </td>
                </tr>
            @endif
    </tbody>
</table>
