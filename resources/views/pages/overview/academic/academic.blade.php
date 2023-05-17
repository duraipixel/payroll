<div class="cursor-pointer">
    <!--begin::Card title-->
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Academics Details</h3>
    </div>

</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <!--begin::Thead-->
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Course</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    University</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">Year
                    Completed</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">Main
                    Sub</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Ancillary Sub</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">Cert
                    No</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Submitted Date</th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Returned Date</th>
                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Date: activate to sort column ascending">File
                </th>
            </tr>
        </thead>

        <tbody class="fs-6 fw-bold text-gray-600">
            @isset($info->education)
                @foreach ($info->education as $item)
                    <tr class="odd">
                        <td>{{ $item->course_name }}</td>
                        <td>{{ $item->boards->name }}</td>
                        <td>{{ $item->course_completed_year }}</td>
                        <td>{{ $item->mainSubject->name ?? '-' }}</td>
                        <td>{{ $item->axSubject->name ?? '-' }}</td>
                        <td>{{ $item->certificate_no ?? '-' }}</td>
                        <td>{{ $item->submitted_date }}</td>
                        <td>{{ $item->returned_date ?? '-' }}</td>
                        <td>
                            @if (isset($item->doc_file) && !empty($item->doc_file))
                                {{-- <a href="{{ asset(Storage::url($item->doc_file)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public' . Storage::url($item->doc_file)) }}" class=""
                                    target="_blank"> Download File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endisset

        </tbody>

    </table>
</div>
