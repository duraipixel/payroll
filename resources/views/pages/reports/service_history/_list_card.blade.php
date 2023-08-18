@if (isset($history) && !empty($history))
    @php
    @endphp
    @foreach ($history as $hitem)
        <div style="border:1px solid #ddd; margin-top:5px;">

            <h3 style="text-align: center;"> {{ $academic_title }} </h3>
            <table style="width: 100%">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="3" style="text-align: center;padding:3px"> STAFF DETAILS </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="" style="padding:3px 10px;width:30%">1. Name of the Staff </td>
                        <td style="width: 50%"> {{ $hitem['staff_details']->name }} </td>
                        <td rowspan="6" style="width:20%">

                            @if (isset($hitem['staff_details']->image) && !empty($hitem['staff_details']->image))
                                @php
                                    $profile_image = Storage::url($hitem['staff_details']->image);
                                @endphp
                                    <img src="{{ asset('public' . $profile_image) }}" alt="" width="100" style="border-radius:10%">
                            @else
                                <img src="{{ asset('assets/images/no_image.jpg') }}" width="100"
                                    style="border-radius:10%">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">2. Staff Id </td>
                        <td> {{ $hitem['staff_details']->society_emp_code }} </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">3. Designation </td>
                        <td> {{ $hitem['staff_details']->position->designation->name ?? '' }} </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">4. Address </td>
                        <td> {{ $hitem['staff_details']->personal->contact_address ?? 'n/a' }} </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">5. Phone No </td>
                        <td>{{ $hitem['staff_details']->personal->phone_no ?? 'n/a' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">6. Mobile No </td>
                        <td>{{ $hitem['staff_details']->personal->whatsapp_no ?? 'n/a' }}</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="3" style="text-align: center;padding:3px"> SERVICE DETAILS </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="" style="padding:3px 10px;width:30%">7. Order No</td>
                        <td style="width: 50%;text-align:left;"> {{ $hitem['staff_details']->appointment->appointment_order_no ?? '-' }} </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">8. Order Date </td>
                        <td> {{ isset( $hitem['staff_details']->appointment->joining_date ) && !empty( $hitem['staff_details']->appointment->joining_date ) ? commonDateFormat($hitem['staff_details']->appointment->joining_date) : '-'}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">9. Description </td>
                        <td> - </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> CASUAL LEAVE DETAILS </th>
                    </tr>
                    <tr style="background: aquamarine">
                        <th style="padding: 3px ">S.No</th>
                        <th style="padding: 3px ">Reason</th>
                        <th style="padding: 3px ">From</th>
                        <th style="padding: 3px ">To</th>
                        <th style="padding: 3px;text-align:center ">No. of Days</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> MATERNITY LEAVE DETAILS </th>
                    </tr>
                    <tr style="background: aquamarine">
                        <th style="padding: 3px ">S.No</th>
                        <th style="padding: 3px ">Reason</th>
                        <th style="padding: 3px ">From</th>
                        <th style="padding: 3px ">To</th>
                        <th style="padding: 3px;text-align:center ">No. of Days</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> EOL DETAILS </th>
                    </tr>
                    <tr style="background: aquamarine">
                        <th style="padding: 3px ">S.No</th>
                        <th style="padding: 3px ">Reason</th>
                        <th style="padding: 3px ">From</th>
                        <th style="padding: 3px ">To</th>
                        <th style="padding: 3px;text-align:center ">No. of Days</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> EARNED LEAVE DETAILS </th>
                    </tr>
                    <tr style="background: aquamarine">
                        <th style="padding: 3px ">S.No</th>
                        <th style="padding: 3px ">Reason</th>
                        <th style="padding: 3px ">From</th>
                        <th style="padding: 3px ">To</th>
                        <th style="padding: 3px;text-align:center ">No. of Days</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> PERMISSION DETAILS </th>
                    </tr>
                    {{-- <tr style="background: aquamarine">
                    <th style="padding: 3px ">S.No</th>
                    <th style="padding: 3px ">Reason</th>
                    <th style="padding: 3px ">From</th>
                    <th style="padding: 3px ">To</th>
                    <th style="padding: 3px;text-align:center ">No. of Days</th>
                </tr> --}}
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> COL DETAILS </th>
                    </tr>
                    {{-- <tr style="background: aquamarine">
                    <th style="padding: 3px ">S.No</th>
                    <th style="padding: 3px ">Reason</th>
                    <th style="padding: 3px ">From</th>
                    <th style="padding: 3px ">To</th>
                    <th style="padding: 3px;text-align:center ">No. of Days</th>
                </tr> --}}
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> DISCIPLINARY ACTION </th>
                    </tr>
                    {{-- <tr style="background: aquamarine">
                    <th style="padding: 3px ">S.No</th>
                    <th style="padding: 3px ">Reason</th>
                    <th style="padding: 3px ">From</th>
                    <th style="padding: 3px ">To</th>
                    <th style="padding: 3px;text-align:center ">No. of Days</th>
                </tr> --}}
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> RESIGNATION DETAILS </th>
                    </tr>
                    {{-- <tr style="background: aquamarine">
                    <th style="padding: 3px ">S.No</th>
                    <th style="padding: 3px ">Reason</th>
                    <th style="padding: 3px ">From</th>
                    <th style="padding: 3px ">To</th>
                    <th style="padding: 3px;text-align:center ">No. of Days</th>
                </tr> --}}
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;border:1px solid #ddd">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px"> GENERAL REMARKS </th>
                    </tr>
                    {{-- <tr style="background: aquamarine">
                    <th style="padding: 3px ">S.No</th>
                    <th style="padding: 3px ">Reason</th>
                    <th style="padding: 3px ">From</th>
                    <th style="padding: 3px ">To</th>
                    <th style="padding: 3px;text-align:center ">No. of Days</th>
                </tr> --}}
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"> - NIL - </td>
                    </tr>
                </tbody>
            </table>
            {{-- <table class="w-100 mt-5 border border-2" id="deduction_table">

            <thead class="bg-primary text-white p-4">
                <tr>
                    <th class="p-2"> Month </th>
                    @if (isset($hitem['salary_field']) && !empty($hitem['salary_field']))
                        @foreach ($hitem['salary_field'] as $item)
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
                                class="">{{ date('M', strtotime($hitem['start_list_date'] . ' + ' . $i . ' month')) }}</label>
                        </td>
                        @php
                            $gross = 0;
                            $epf = $lic = $pf_tax = $it_tax = 0;
                        @endphp
                        @if (isset($hitem['salary_field']) && !empty($hitem['salary_field']))
                            @foreach ($hitem['salary_field'] as $item)
                                <td class="p-2">
                                    @php
                                        $item_amount = getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id, $item->id);
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
                            $epf = getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id, '', 'Employee Provident Fund');
                            $lic = getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id, '', 'Life Insurance Corporation');
                            $it_tax = staffMonthTax($hitem['staff_details']->id, date('F', strtotime($hitem['start_list_date'] . ' + ' . ($i + 1) . ' month')));
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
                    @if (isset($hitem['salary_field']) && !empty($hitem['salary_field']))
                        @foreach ($hitem['salary_field'] as $item)
                            <th class="p-2">
                                {{ getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id, $item->id) * 12 }}
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
        </table> --}}
            <div style="padding:10px 5px;">
                I, AMUTHA.R hereby confirm that all the information furnished above are true to the best of my knowledge
                and
                belief and in acceptance to the same I
                affix my signature below.
            </div>
            <div style="margin-top:45px;padding:10px 5px;">
                Signature of the Staff
            </div>
        </div>
    @endforeach
@endif
