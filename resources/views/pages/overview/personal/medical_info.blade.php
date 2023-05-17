@isset($info->medicalRemarks)

    <div class="cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0 mb-5">
            <h3 class="fw-bold m-0">Medical Records</h3>
        </div>

    </div>
    <div class="table-responsive cstmzes-tble">
        <table id="kt_customer_details_invoices_table_3"
            class="table align-middle table-row-dashed fs-6 fw-bolder gy-5 dataTable no-footer">
            <!--begin::Thead-->
            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
                <tr class="text-start text-muted bg-light gs-0">
                    <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">Reason
                    </th>
                    <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">Record
                        Date</th>
                    <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">File
                    </th>

                </tr>
            </thead>

            <tbody class="fs-6 fw-bold text-gray-600">
                @foreach ($info->medicalRemarks as $item)
                    <tr class="odd">
                        <td>{{ $item->reason }}</td>
                        <td>{{ commonDateFormat($item->medic_date) }}</td>
                        <td>
                            @if (isset($item->medic_documents) && !empty($item->medic_documents))
                                {{-- <a href="{{ asset(Storage::url($item->medic_documents)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public' . Storage::url($item->medic_documents)) }}" class=""
                                    target="_blank"> Download File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>
@endisset
