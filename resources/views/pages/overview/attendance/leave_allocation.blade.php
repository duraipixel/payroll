<div class="  cursor-pointer">
    <!--begin::Card title-->
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Leave Allocation</h3>
    </div>
    {{-- {{ dd( $info->appointment->leaveAllocated ) }} --}}
</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3"
        class="table align-middle table-row-dashed fs-6 fw-bolder gy-5 dataTable no-footer">
        <!--begin::Thead-->
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light gs-0">
                <th> ACCUMULATED Leave Head</th>
                <th> ACCUMULATED Leave Days</th>
                <th>Is Carry Forword</th>

            </tr>
        </thead>
        <!--end::Thead-->
        <!--begin::Tbody-->

        <tbody class="fs-6 fw-bold text-gray-600">
            @php
                isFemale($info->id);
            @endphp
            @isset($info->appointment->leaveAllocated)
                @php
                    $total = 0;
                @endphp
                @foreach ($info->appointment->leaveAllocated as $item)
          
                    @if (isFemale($info->id) && ( trim($item->leave_head->name) == 'Maternity Leave'))
                        @php
                            $total += $item->leave_days;
                        @endphp
                        <tr class="odd">
                            <td>{{ $item->leave_head->name }}</td>
                            <td>{{ $item->leave_days }}</td>
                            <td>{{ ucfirst($item->carry_forward) }}</td>
                            {{-- <td>{!! getLeaveHeadsSeperation($item->nature_of_employment_id) !!}</td> --}}
                            {{-- <td>{{ $item->academy->from_year . ' - ' . $item->academy->to_year }}</td> --}}
                        </tr>
                    @elseif( trim($item->leave_head->name) != 'Maternity Leave')
                        @php
                            $total += $item->leave_days;
                        @endphp
                        <tr class="odd">
                            <td>{{ $item->leave_head->name }}</td>
                            <td>{{ $item->leave_days }}</td>
                            <td>{{ ucfirst($item->carry_forward) }}</td>
                            {{-- <td>{!! getLeaveHeadsSeperation($item->nature_of_employment_id) !!}</td> --}}
                            {{-- <td>{{ $item->academy->from_year . ' - ' . $item->academy->to_year }}</td> --}}
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td> Total</td>
                    <td> {{ $total }}</td>
                </tr>
            @endisset

        </tbody>
        <!--end::Tbody-->
    </table>
</div>
