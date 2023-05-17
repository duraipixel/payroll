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
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Accumulated Leave</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Available Leave</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">Leave
                    Name</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Academic Year</th>
            </tr>
        </thead>
        <!--end::Thead-->
        <!--begin::Tbody-->
        <tbody class="fs-6 fw-bold text-gray-600">
            @isset($info->appointment->leaveAllocatedYear)
                @foreach ($info->appointment->leaveAllocatedYear as $item)
                    <tr class="odd">
                        <td>{{ $item->total_leave }}</td>
                        <td>0</td>
                        <td>{!! getLeaveHeadsSeperation($item->nature_of_employment_id) !!}</td>
                        <td>{{ $item->academy->from_year . ' - ' . $item->academy->to_year }}</td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
        <!--end::Tbody-->
    </table>
</div>
