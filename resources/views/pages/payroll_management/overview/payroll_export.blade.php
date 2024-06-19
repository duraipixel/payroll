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

 $month = date('F', strtotime($date));
$month_length = date('t', strtotime($payroll_date));
@endphp 
<table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                            id="revision_table">
                            <thead class="bg-primary">
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="px-3 text-primary sticky-col first-col">
                                        <div>
                                            <input role="button" type="radio" name="change_revision" value="none"
                                                id="select_all">
                                        </div>
                                    </th>
                                    <th class="px-3 text-primary sticky-col second-col">
                                        Emp Code
                                    </th>
                                    <th class="px-3 text-primary sticky-col third-col">
                                        Name
                                    </th>
                                    <th class="px-3 text-white">
                                        Join Date
                                    </th>
                                    <th class="px-3 text-white">
                                        Days in Month
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
                                        {{-- <th class="px-3 text-white">
                                            Tax
                                        </th>
                                        <th class="px-3 text-white">
                                            Prof.Tax
                                        </th> --}}
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

                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-bold">
                            @php
                                $total_net_pay = 0;
                                $gross_salary=0;
                                $net_salary=0;
                                $total_deductions=0;
                            @endphp
                                @if (isset($payout_data) && !empty($payout_data))
                                    @foreach ($payout_data as $item)
                                        <tr>
                                            <td class="sticky-col first-col px-3">
                                                <input type="radio" name="change_revision" value="{{ $item->id }}">
                                            </td>
                                            <td class="sticky-col second-col px-3">
                                                {{ $item->society_emp_code ?? '' }}
                                            </td>
                                            <td class="sticky-col third-col px-3">
                                                {{ $item->name ?? '' }}
                                            </td>
                                            <td class="px-3">
                                                {{ $item->firstAppointment->joining_date ?? '' }}
                                            </td>
                                            <td class="px-3">
                                                {{ $working_day ?? 0 }}
                                            </td>
                                            <td class="px-3">
                                                {{ $item->workedDays->count() ?? 0 }}
                                            </td>
                                            @php
                                                $gross = $item->currentSalaryPattern->gross_salary;
                                                $deduction = 0;
                                                $earnings = 0;
                                            @endphp
                                            @if (isset($earings_field) && !empty($earings_field))
                                                @foreach ($earings_field as $eitem)
                                                    <td class="px-3">

                                                        @php
                                                            $show_earning_total = 0;
                                                            $earn_total = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $eitem->name, 'EARNINGS', $eitem->short_name) ?? 0;
                                                            $show_earning_total += $earn_total;
                                                            // echo strtolower(Str::singular($eitem->short_name));
                                                            $e_name = $eitem->short_name == 'Bonus' ? 'bonus': strtolower(Str::singular($eitem->short_name));
                                                            $other_earnings = getEarningInfo($item->id, $e_name, $date);
                                                            $show_earning_total += $other_earnings->amount ?? 0;
                                                            $earnings += $show_earning_total;
                                                           ${$eitem->short_name}+=$show_earning_total;
                                                        @endphp
                                                        {{ $show_earning_total }}
                                                    </td>
                                                @endforeach
                                                <td class="px-3">
                                                    {{-- {{ $item->currentSalaryPattern->gross_salary }} --}}
                                                    {{ $earnings }}
                                                </td>
                                            @endif
                                            @if (isset($deductions_field) && !empty($deductions_field))
                                                @foreach ($deductions_field as $sitem)
                                                    @if ($sitem->short_name == 'IT')
                                                        <td class="px-3">
                                                            {{ staffMonthTax($item->id, strtolower($month)) }}
                                                            @php
                                                                ${$sitem->short_name}+=staffMonthTax($item->id, strtolower($month));
                                                                $deduction += staffMonthTax($item->id, strtolower($month));
                                                            @endphp
                                                        </td>
                                                    @elseif(trim(strtolower($sitem->short_name)) == 'other')
                                                        <td class="px-3">
                                                           
                                                            @php
                                                                $other_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                                /**
                                                                 * get leave deduction amount
                                                                 */
                                                                $leave_amount_day = getStaffLeaveDeductionAmount($item->id, $date) ?? 0;
                                                                $leave_amount = 0;
                                                                if ($leave_amount_day) {
                                                                    $leave_amount = getDaySalaryAmount($gross, $month_length);
                                                                    $leave_amount = $leave_amount * $leave_amount_day;
                                                                }
                                                                $other_amount += $leave_amount;
                                                                ${$sitem->short_name}+=$other_amount;
                                                            @endphp
                                                            {{ $other_amount }}
                                                            @php
                                                                $deduction += $other_amount;
                                                            @endphp
                                                        </td>
                                                    @elseif(trim(strtolower($sitem->short_name)) == 'bank loan')
                                                        <td class="px-3">
                                                            @php
                                                                $bank_loan_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                                /**
                                                                 * get leave deduction amount
                                                                 */
                                                                $other_bank_loan_amount = getBankLoansAmount($item->id, $date);
                                                                
                                                                $bank_loan_amount += $other_bank_loan_amount['total_amount'] ?? 0;
                                                                ${$sitem->short_name}+=$bank_loan_amount;
                                                            @endphp
                                                            {{ $bank_loan_amount }}
                                                            @php
                                                                $deduction += $bank_loan_amount;
                                                            @endphp
                                                        </td>
                                                    @elseif(trim(strtolower($sitem->short_name)) == 'lic')
                                                        <td class="px-3">
                                                            @php
                                                                $insurance_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                                /**
                                                                 * get leave deduction amount
                                                                 */
                                                                $other_insurance_amount = getInsuranceAmount($item->id, $date);
                                                                
                                                                $insurance_amount += $other_insurance_amount['total_amount'] ?? 0;
                                                                ${$sitem->short_name}+=$insurance_amount;
                                                            @endphp
                                                            {{ $insurance_amount }}
                                                            @php
                                                                $deduction += $insurance_amount;
                                                            @endphp
                                                        </td>
                                                    @else
                                                        <td class="px-3">

                                                            @php
                                                                $old_deduct_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                            
                                                                if( strtolower(Str::singular($sitem->short_name)) == 'other') {
                                                                    /**
                                                                     * get leave deduction amount
                                                                     */
                                                                    $leave_amount_day = getStaffLeaveDeductionAmount($item->id, $date) ?? 0;
                                                                    
                                                                    $leave_amount = 0;
                                                                    if ($leave_amount_day) {
                                                                    
                                                                        $leave_amount = getDaySalaryAmount($earnings, $month_length);
                                                                        // echo $leave_amount;
                                                                        $leave_amount = $leave_amount * $leave_amount_day;
                                                                    }
                                                                    $old_deduct_amount += $leave_amount;
                                                                }

                                                                $deduction += $old_deduct_amount;


                                                                $other_deductions = getDeductionInfo($item->id, strtolower(Str::singular($sitem->short_name)), $date);
                                                                $deduction += $other_deductions->amount ?? 0;
                                                                
                                                                $show_amount = ($old_deduct_amount ?? 0) + ($other_deductions->amount ?? 0);
                                                                ${$sitem->short_name}+=$show_amount;
                                                            @endphp
                                                            {{ $show_amount }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td class="px-3">
                                                    {{ $deduction }}
                                                    <br>
                                                    {{-- {{ $item->currentSalaryPattern->total_deductions ?? 0 }} --}}
                                                </td>
                                            @endif
                                            <td class="px-3">
                                                @php
                                                    $net_pay = $earnings - $deduction;
                                                    $total_net_pay = $total_net_pay + $net_pay;
                                                @endphp
                                                {{ $net_pay }}
                                            </td>
                                        </tr>
                    @php
                    $gross_salary +=$earnings;
                    $net_salary +=$net_pay;
                    $total_deductions+=$deduction;
                    @endphp
                                    @endforeach
                @if(count($payout_data)>0)
                  <tr>
                    <td class="sticky-col first-col px-3"></td>
                    <td class="sticky-col first-col px-3"></td>
                    <td class="sticky-col first-col px-3"></td>
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
                                @endif
                            </tbody>

                        </table>