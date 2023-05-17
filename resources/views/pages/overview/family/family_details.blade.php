<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <!--begin::Thead-->
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Relationship
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Name
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
                    Qualification
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Occupation
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Address
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Order ID: activate to sort column ascending">
                    Contact No
                </th>
                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Amount: activate to sort column ascending">
                    Nationality
                </th>
                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                    rowspan="1" colspan="1" style="width: 0px;"
                    aria-label="Date: activate to sort column ascending">
                    Remarks
                </th>
            </tr>
        </thead>
        <!--end::Thead-->
        <!--begin::Tbody-->
        <tbody class="fs-6 fw-bold text-gray-600">
            @isset($info->familyMembers)
                @foreach ($info->familyMembers as $item)
                    <tr class="odd">
                        <td>{{ $item->relationship->name ?? '' }}</td>
                        <td>{{ $item->first_name }}</td>
                        <td>{{ date('M d, Y', strtotime($item->dob)) }}</td>
                        <td>{{ $item->gender }}</td>
                        <td>{{ $item->qualification->name ?? '' }}</td>
                        <td>{{ $item->profession ?? '' }}</td>
                        <td>{{ $item->residential_address ?? '' }}</td>
                        <td>{{ $item->contact_no ?? '' }}</td>
                        <td>{{ $item->nationality->name ?? '' }}</td>
                        <td>{{ $item->remarks ?? '' }}</td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
        <!--end::Tbody-->
    </table>
</div>
