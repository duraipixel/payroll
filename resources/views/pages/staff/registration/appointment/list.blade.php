<div class="table-responsive">
    <!--begin::Table-->
    <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bolder text-muted">
                <th class="w-30px">No</th>
                <th class="w-120px">Joining Date</th>
                <th class="">Order No</th>
                <th class="w-140px">From</th>
                <th class="w-120px">To</th>
                <th class="w-120px">Appointment</th>
                <th class="w-120px">Category</th>
                <th class="w-120px">Nature Of Employment</th>
                <th class="w-120px">Work Place</th>
                <th class="w-120px">Salary Scale</th>
                <th class="w-120px">Actions</th>
            </tr>
        </thead>
        
        <tbody>
            @if (isset($staff_details->allAppointment) && count($staff_details->allAppointment) > 0)
                @foreach ($staff_details->allAppointment as $item)
                    <tr>
                        <td class="p-3"> {{ $loop->iteration }} </td>
                        <td class="p-3">{{ commonDateFormat($item->joining_date) }}</td>
                        <td class="p-3"> {{ $item->appointment_order_no ?? 'n/a' }} </td>
                        <td class="p-3">{{ commonDateFormat($item->from_appointment) }}</td>
                        <td class="p-3">{{ commonDateFormat($item->to_appointment) }}</td>
                        <td class="p-3">{{ $item->appointmentOrderModel->name ?? '' }}</td>
                        <td class="p-3">{{ $item->staffCategory->name ?? '' }}</td>
                        <td class="p-3">{{ $item->employment_nature->name ?? '' }}</td>
                        <td class="p-3">{{ $item->work_place->name ?? '' }}</td>
                        <td class="p-3">{{ $item->salary_scale ?? '' }}</td>
                        <td class="p-3 text-end">
                            @if ($item->appointment_doc && !empty($item->appointment_doc))
                                @php
                                    $url = Storage::url($item->appointment_doc);
                                @endphp
                                <a href="{{ asset('public' . $url) }}" target="_blank" class="btn btn-sm btn-light-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endif
                            <a href="javascript:void(0)" class="btn btn-sm btn-light-primary" onclick="return editStaffAppointment({{ $item->id }})">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-light-danger" onclick="return deleteStaffAppointment({{ $item->id }})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="10" class="text-center">No Appointment records</td>
            </tr>
            @endif
        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->
</div>