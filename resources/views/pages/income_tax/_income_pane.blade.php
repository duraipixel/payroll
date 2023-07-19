<div class="row">
    <div class="col-sm-12">
        <div class="d-flex justify-content-between">
            <div class="from-group">
                <label> Tax Related Component </label>
            </div>
        </div>
    </div>
    {{-- {{ dd($salary_field) }} --}}
    <div class="col-sm-12 table-responsive">
        <table class="w-100 mt-5 border border-2" id="deduction_table">
            <thead class="bg-primary text-white p-4">
                <tr>
                    <th class="p-2"> Month </th>
                    @if (isset($salary_field) && !empty($salary_field))
                        @foreach ($salary_field as $item)
                            <th class="p-2"> {{ $item->short_name }} </th>
                        @endforeach
                    @endif
                    <th>
                        Gross
                    </th>
                    <th>
                        EPF
                    </th>
                    <th>
                        LIC
                    </th>
                    <th>
                        Income Tax
                    </th>
                    <th>
                        Prof.Tax
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_gross = 0;
                    $total_epf = 0;
                    $total_lic = 0;
                    $total_tax = 0;
                    $total_pf_tax = 0;
                @endphp
                @for ($i = 0; $i < 12; $i++)
                    <tr>
                        <td class="p-2 bg-secondary text-black">
                            <label for=""
                                class="">{{ date('F Y', strtotime($start_list_date . ' + ' . $i . ' month')) }}</label>
                        </td>
                        @php
                            $gross = 0;
                            $epf = $lic = $pf_tax = $it_tax = 0;
                        @endphp
                        @if (isset($salary_field) && !empty($salary_field))
                            @foreach ($salary_field as $item)
                                <td class="p-2">
                                    @php
                                        $item_amount = getStaffPatterFieldAmount($staff_details->id, $salary_pattern->id, $item->id);
                                    @endphp
                                    {{ $item_amount }}
                                </td>
                                @php
                                    $gross = $gross + $item_amount;
                                @endphp
                            @endforeach
                        @endif
                        <td class="p-2">{{ $gross }}</td>
                        @php
                            $epf = getStaffPatterFieldAmount($staff_details->id, $salary_pattern->id, '', 'Employee Provident Fund');
                            $lic = getStaffPatterFieldAmount($staff_details->id, $salary_pattern->id, '', 'Life Insurance Corporation');
                            $it_tax = staffMonthTax($staff_details->id, date('F', strtotime($start_list_date . ' + ' . ($i + 1) . ' month')));
                        @endphp
                        <td class="p-2">{{ $epf }}</td>
                        <td class="p-2">{{ $lic }}</td>
                        <td class="p-2">{{ $it_tax }}</td>
                        @php
                            $total_epf += $epf;
                            $total_lic += $lic;
                            $total_tax += $it_tax;
                            $total_gross += $gross;
                        @endphp
                    </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    @if (isset($salary_field) && !empty($salary_field))
                        @foreach ($salary_field as $item)
                            <th class="p-2">
                                {{ getStaffPatterFieldAmount($staff_details->id, $salary_pattern->id, $item->id) * 12 }}
                            </th>
                        @endforeach
                    @endif
                    <th> {{ $total_gross }} </th>
                    <th> {{ $total_epf }} </th>
                    <th> {{ $total_lic }} </th>
                    <th> {{ $total_tax }} </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    {{-- <div class="col-sm-12 mt-3">
        <div class="d-flex justify-content-between">
            <div>
                <label for="" class="text-muted"> Total Annual Salary : </label>
                Rs. 3,02,256
            </div>
        </div>
    </div> --}}
</div>
