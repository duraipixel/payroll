@php
if (isset($earings_field) && !empty($earings_field)){
foreach ($earings_field as $eitem){
${$eitem->short_name}=0;
}
}
if (isset($deductions_field) && !empty($deductions_field)){
foreach ($deductions_field as $sitem){
 ${$sitem->short_name}=0;
}
}
@endphp  
<table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer" id="revision_table">
    <thead class="bg-primary">
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase align-middle gs-0">
            <th class="px-3 text-primary sticky-col first-col">
                Emp Code
            </th>
            <th class="px-3 text-primary sticky-col second-col">
                Name
            </th>
            <th class="px-3 text-white">
                Join Date
            </th>
            <th class="px-3 text-white">
              Staff Nature
            </th>
            <th class="px-3 text-white">
              Staff Designation 
            </th>
            <th class="px-3 text-white">
                Workdays
            </th>
            @if (isset($earings_field) && !empty($earings_field))
                @foreach ($earings_field as $eitem)
                    <th class="px-3 text-white">
                        {{ $eitem->short_name }}
                    </th>
                @endforeach
                <th class="px-3 text-white">
                    Gross
                </th>
            @endif
            @if (isset($deductions_field) && !empty($deductions_field))
                @foreach ($deductions_field as $sitem)
                    <th class="px-3 text-white">
                        {{ $sitem->short_name }}
                    </th>
                @endforeach
                <th class="px-3 text-white">
                    Total Deduction
                </th>
            @endif
            <th class="px-3 text-white w-100px">Net Pay</th>
            <th class="px-3 text-white w-100px">Loan Details</th>
        </tr>
    </thead>

    <tbody class="text-gray-600 fw-bold">
             @php
                $total_net_pay = 0;
                $gross_salary=0;
                $net_salary=0;
                $total_deductions=0;
            @endphp
        @if (isset($salary_info) && !empty($salary_info))
            @foreach ($salary_info as $item)
                <tr>
                    <td class="sticky-col first-col px-3">
                        {{ $item->staff->society_emp_code ?? '' }}
                    </td>
                    <td class="sticky-col second-col px-3">
                        {{ $item->staff->name ?? '' }}
                    </td>
                    <td class="px-3">
                    {{ $item->staff->firstAppointment->joining_date ? 
        \Carbon\Carbon::parse($item->staff->firstAppointment->joining_date)->format('d-m-Y') : 
        ' ' 
    }}
                    </td>
                    <td class="px-3">
                        {{ $item->staff->appointment->employment_nature->name ?? '' }}
                    </td>
                    <td class="px-3">
                        {{ $item->staff->position->designation->name ?? '' }}
                    </td>

                    <td class="px-3">
                        {{ $item->working_days ?? 0 }}
                    </td>
                    @if (isset($earings_field) && !empty($earings_field))
                        @foreach ($earings_field as $eitem)
                        @php
                                ${$eitem->short_name}+=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);
                        @endphp
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
                        @php
                            ${$sitem->short_name}+=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS');
                        @endphp
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
                    <td class="px-3">
                        @php
                        $loan_datas=getLoanDetsils($item->staff->id, $item->id);
                        @endphp
                        @if(isset($loan_datas) && count($loan_datas)>0)
                        @foreach ($loan_datas as $loan)
                        {{$loan->loan_type}} : {{$loan->bank_name}}<br/>
                        @endforeach
                        @else
                        -
                        @endif
                @php
                    $gross_salary +=$item->gross_salary;
                    $net_salary +=$item->net_salary;
                    $total_deductions+=$item->total_deductions;
                    @endphp
            @endforeach
            @if(count($salary_info)>0)
                  <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @if (isset($earings_field) && !empty($earings_field))
                    @foreach ($earings_field as $eitem)
                    <td>{{ amountFormat(${$eitem->short_name}) }}</td>
                    @endforeach
                    @endif
                    <td>{{amountFormat($gross_salary)}}</td>
                    @if (isset($deductions_field) && !empty($deductions_field))
                     @foreach ($deductions_field as $sitem)
                     <td>{{ amountFormat(${$sitem->short_name}) }}</td> 
                     @endforeach
                     @endif
                    <td>{{amountFormat($total_deductions)}}</td>
                    <td>{{amountFormat($net_salary)}}</td>
                   
                  </tr>
                  @endif
                  @else
                  <tr>
                    <td> No Payroll records </td>
                 </tr>
        @endif
    </tbody>

</table>