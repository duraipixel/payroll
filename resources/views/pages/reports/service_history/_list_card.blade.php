<style>
    /* Style for printing */


    #deduction_table {
        width: 100%;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    #deduction_table td,
    #deduction_table th {
        border-collapse: collapse;
        border: 1px solid black;
        font-size: 11px;
    }

    #staff_details_table td,
    #appointment_details_table td,
    .common_table td {
        font-size: 11px;
    }

    .common_table th {
        font-size: 12px;
        page-break-inside: auto;

    }

    .page-break-after {
        page-break-after: always
    }

    .main-div {
        border: 1px solid black;
        margin-top: 15px;
        /* box-shadow: 2px 1px 2px 1px #ddd; */
    }

    .logo-header {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@if (isset($history) && !empty($history))
    @php
    // dd( $history );
    @endphp
    @foreach ($history as $hitem)
        <div class="main-div">

            <table style="width:100%">
                <tr>
                    <td style="width: 20%"></td>
                    <td style="width: 30%;text-align:right;">
                        <img src="{{ asset('assets/logo/logo.png') }}" style="height: 85px;">
                    </td>
                    <td style="width: 50%;text-align:left">
                        <h4>
                            {{ $hitem['staff_details']->institute->name ?? '' }}
                        </h4>
                    </td>
                </tr>
            </table>
            <h4 style="text-align: center;margin-top: 1px;"> {{ $academic_title }} </h4>
            <table style="width: 100%" id="staff_details_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="3" style="text-align: center;padding:3px;font-size:12px;"> STAFF DETAILS
                        </th>
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
                                <img src="{{ asset('public' . $profile_image) }}" alt="" width="100"
                                    style="border-radius:10%">
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
            <table style="width: 100%" id="appointment_details_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="3" style="text-align: center;padding:3px;font-size:12px;"> SERVICE DETAILS
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="" style="padding:3px 10px;width:30%">7. Order No</td>
                        <td style="width: 50%;text-align:left;">
                            {{ $hitem['staff_details']->appointment->appointment_order_no ?? '-' }} </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">8. Order Date </td>
                        <td> {{ isset($hitem['staff_details']->appointment->joining_date) && !empty($hitem['staff_details']->appointment->joining_date) ? commonDateFormat($hitem['staff_details']->appointment->joining_date) : '-' }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 10px;">9. Description </td>
                        <td> - </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <table id="deduction_table">

                <thead>
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
                                    <td class="p-2" style="text-align: right">
                                        @php
                                            $item_amount = getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id ?? '', $item->id);
                                        @endphp
                                        {{ $item_amount }}
                                    </td>
                                    @php
                                        $gross = $gross + $item_amount;
                                    @endphp
                                @endforeach
                            @endif
                            <td class="p-2" style="text-align: right">{{ $gross }}</td>
                            @php
                                $epf = getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id ?? '', '', 'Employee Provident Fund');
                                $lic = getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id ?? '', '', 'Life Insurance Corporation');
                                $it_tax = staffMonthTax($hitem['staff_details']->id, date('F', strtotime($hitem['start_list_date'] . ' + ' . ($i + 1) . ' month')));
                            @endphp
                            <td class="p-2" style="text-align: right">{{ $epf }}</td>
                            <td class="p-2" style="text-align: right">{{ $lic }}</td>
                            <td class="p-2" style="text-align: right">{{ $it_tax }}</td>
                            <td class="p-2" style="text-align: right">0</td>
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
                                <th class="p-2" style="text-align: right">
                                    {{ getStaffPatterFieldAmount($hitem['staff_details']->id, $hitem['salary_pattern']->id ?? '', $item->id) * 12 }}
                                </th>
                            @endforeach
                        @endif
                        <th style="text-align: right"> {{ $total_gross }} </th>
                        <th style="text-align: right"> {{ $total_epf }} </th>
                        <th style="text-align: right"> {{ $total_lic }} </th>
                        <th style="text-align: right"> {{ $total_tax }} </th>
                        <th style="text-align: right">0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="next"></div>
        <div style="border: 1px solid black;">
            @include('pages.reports.service_history._cl')
            @include('pages.reports.service_history._ml')
            @include('pages.reports.service_history._eol')
            @include('pages.reports.service_history._el')

            <table style="width: 100%;border:1px solid #ddd" class="common_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px;font-size:12px;"> PERMISSION
                            DETAILS </th>
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
            <table style="width: 100%;border:1px solid #ddd" class="common_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px;font-size:12px;"> COL DETAILS </th>
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
            <table style="width: 100%;border:1px solid #ddd" class="common_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px;font-size:12px;"> DISCIPLINARY
                            ACTION </th>
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
            <table style="width: 100%;border:1px solid #ddd" class="common_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px;font-size:12px;"> RESIGNATION
                            DETAILS </th>
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
            <table style="width: 100%;border:1px solid #ddd" class="common_table">
                <thead style="background: aliceblue;color:black;">
                    <tr>
                        <th colspan="5" style="text-align: center;padding:3px;font-size:12px;"> GENERAL REMARKS
                        </th>
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
            <div class="signature-container" style="font-size:12px;">

                <div style="padding:10px 5px;">
                    I, {{ $hitem['staff_details']->name }} hereby confirm that all the information furnished above are true to the best of my
                    knowledge
                    and
                    belief and in acceptance to the same I
                    affix my signature below.
                </div>
                <div style="margin-top:45px;padding:10px 5px;">
                    Signature of the Staff
                </div>
            </div>
        </div>
        @if ($loop->last)
            <div style="page-break-after: auto"></div>
        @else
            <div style="page-break-after: always"></div>
        @endif
    @endforeach
@endif