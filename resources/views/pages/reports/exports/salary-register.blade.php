<table border="1">
    <thead>
        <tr>
            <th> S. No. </th>
            <th> Division </th>
            <th> DOJ </th>
            <th> Category </th>
            <th> AEWS /INSTITUTION CODE </th>
            <th> NAME </th>
             <th> DESIGINATION </th>
            <th>  Workdays </th>
                            @if (isset($earings_field) && !empty($earings_field))
                    @foreach ($earings_field as $eitem)
                        <th>
                            {{ $eitem->short_name }}
                        </th>
                    @endforeach
                    <th>
                       Deduction in Gross (LOP)
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
                <th>NET SALARY</th>
                 <th>Bank</th>
                              <th>
                           Account NO
                            </th>
                              <th>
                          IFSC
                            </th>
                             <th>
                          UAN
                            </th>
                            <th>
                        UAN Name
                            </th>
                             <th>
                         ESI No
                            </th>
                            <th>
                        ESI Name
                            </th>
                             <th>
                          PAN
                            </th>
                            <th>
                        PAN Name
                            </th>
                             <th>
                          Aadhaar Name
                            </th>
                            <th>
                        Aadhaar No
                            </th>
                             <th>
                          Mobile
                            </th>
                            <th>
                      Email
                            </th>
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
                        <td >
                            {{ $item->staff->position->division->name ?? '' }}
                        </td>
                         <td class="px-3">
                            {{ $item->staff->firstAppointment->joining_date ?? '' }}
                        </td>
                         <td >
                            {{ $item->staff->appointment->staffCategory->name ?? '' }}
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
                        <td>
                            {{ $item->staff->appointment->designation->name ?? '' }}
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
                        <td>{{$item->staff->bank->bankBranch->name ?? ''}}</td>
                        <td>{{$item->staff->bank->account_number ?? ''}}</td>
                        <td>{{$item->staff->bank->bankBranch->ifsc_code ?? ''}}</td>

                        <td>{{$item->staff->pf->ac_number?? ''}}</td>
                        <td>{{$item->staff->pf->name ?? ''}}</td>

                         <td>{{$item->staff->esi
->ac_number?? ''}}</td>
                        <td>{{$item->staff->esi
->name ?? ''}}</td>
                         <td>{{$item->staff->pancard
->doc_number?? ''}}</td>
                        <td>{{$item->staff->pancard
->description ?? ''}}</td>
                         <td>{{$item->staff->aadhaar
->description?? ''}}</td>
                        <td>{{$item->staff->aadhaar
->doc_number ?? ''}}</td>
 <td>{{$item->staff->personal
->mobile_no1 ?? ''}}</td>
 <td>{{$item->staff->email ?? ''}}</td>
                    </tr>
                @endforeach
            @else 
                <tr>
                    <td> No Payroll records </td>
                </tr>
            @endif
    </tbody>
</table>
