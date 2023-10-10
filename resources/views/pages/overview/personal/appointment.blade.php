@isset($info->allAppointment)

    <div class="  cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0 mb-5">
            <h3 class="fw-bold m-0">Appointment details</h3>
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
                        aria-label="Order ID: activate to sort column ascending"> Date of Joining
                    </th>
                      <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">  Order No
                    </th>
                      <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">    Period of Appointment (From - To)
                    </th>
                     <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">   Appointment
                    </th>
                      <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">   Category
                    </th>
                     <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">    Nature Of Employment
                    </th>
                      <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">    Work Place
                    </th>
                      <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">    Salary Scale
                    </th>
                    <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_customer_details_invoices_table_3"
                        rowspan="1" colspan="1" style="width: 0px;"
                        aria-label="Order ID: activate to sort column ascending">
                        Appointment Order Upload</th>
                </tr>
            </thead>
            <!--end::Thead-->
            <!--begin::Tbody-->
            <tbody class="fs-6 fw-bold text-gray-600">
                @foreach ($info->allAppointment as $item)
                    <tr class="odd">
                        <td> {{ commonDateFormat($item->joining_date) }}</td>
                         <td> {{ $item->appointment_order_no ?? 'n/a'}}</td>
                        <td> {{ commonDateFormat($item->from_appointment) }} - {{ commonDateFormat($item->to_appointment)}}</td>
                        <td> {{ $item->appointmentOrderModel->name ?? 'N/A'  }}</td>
                        <td> {{ $item->staffCategory->name ?? '' }}</td>
                       <td> {{$item->employment_nature->name ?? ''   }}</td>
                        <td> {{$item->work_place->name ?? '' }}</td>
                        <td> ₹{{ $item->salary_scale }}</td>

                       
                        <td>
                            @if (isset($item->appointment_doc) && !empty($item->appointment_doc))
                                {{-- <a href="{{ asset(Storage::url($item->appointment_doc)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public' . Storage::url($item->appointment_doc)) }}" class=""
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
