<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle table-row-dashed fs-6 fw-bolder gy-5 dataTable no-footer">
        
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light gs-0">
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Name
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Address
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Relationship with 
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    DOB
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Sex
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Share
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Contact No
                </th>
            </tr>
        </thead>
       
        <tbody class="fs-6 fw-bold text-gray-600">
            @isset($info->nominees)
                @foreach ($info->nominees as $item)
                    <tr class="odd">
                        <td>{{ $item->nominee->first_name ?? '' }}</td>
                        <td>{{ $item->nominee->residential_address ?? '' }}</td>
                        <td>{{ $item->relationship->name ?? '' }}</td>
                        <td>{{ date('M d, Y', strtotime($item->nominee->dob))  }}</td>
                        <td> {{ $item->gender }}</td>
                        <td> {{ $item->share ?? '' }}</td>
                        <td>{{ $item->nominee->contact_no ?? '' }}</td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
        
    </table>
</div>
