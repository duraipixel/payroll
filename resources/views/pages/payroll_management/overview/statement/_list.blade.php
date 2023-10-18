
<div class="table-responsive">
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
            </tr>
        </thead>

        <tbody class="text-gray-600 fw-bold">
            @php
                $total_net_pay = 0;
            @endphp
            @if (isset($salary_info) && !empty($salary_info))
                @foreach ($salary_info as $item)
                    <tr>
                        <td class="sticky-col first-col px-3">
                            {{ $item->staff->society_emp_code ?? '' }}
                        </td>
                        <td class="sticky-col second-col px-3">
                           @php
                                $url = storage_path('app/public/' . $item->document)
                            @endphp
                     @if(file_exists($url))
                            <a href="{{ asset('public' . $url) }}" target="_blank">
                                <i class="fa fa-file-pdf text-danger px-1"></i>
                            </a>
                    @else
                    <a href="{{ url('payroll/download',$item->id) }}" target="_blank">
                                <i class="fa fa-file-pdf text-danger px-1"></i>
                            </a>
                    @endif
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
            @endif
        </tbody>
    </table>
</div>
<div class="p3">
    Total Generated : {{ count($salary_info) }}
</div>

<div class="row">
    <div class="col-sm-12 text-end mt-3">
        <a href="{{ route('payroll.overview') }}" class="btn btn-dark"> Move to Payroll Overview </a>
    </div>
</div>
