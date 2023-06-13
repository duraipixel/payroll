<style>
    .tableFixHead {
        overflow: auto;
        height: 300px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .blur_table {
        filter: blur(1px);
    }
</style>
<div class="table-responsive tableFixHead mt-5" style="box-shadow: 1px 2px 3px 4px #98aac173;">
    <h3 class="p-3 text-center"> Service History</h3>
    <table class="table table-hover table-row-dashed align-middle gs-0 gy-3 my-0 ">
        <thead>
            <tr class="fs-8 fw-bold text-gray-400 border-bottom-0">
                <th class="p-0 p-3 min-w-50px bg-dark">No</th>
                <th class="p-0 p-3 bg-dark">From</th>
                <th class="p-0 p-3 bg-dark">To</th>
                <th class="p-0 p-3 bg-dark pe-12">Appointment</th>
                <th class="p-0 p-3 bg-dark pe-7">Category</th>
                <th class="p-0 p-3 bg-dark text-center">Action</th>
            </tr>
        </thead>

        <tbody id="service_history_tbody">
            
            @if (isset($staff_details->allAppointment) && !empty($staff_details->allAppointment))
                @foreach ($staff_details->allAppointment as $item)
                    <tr>
                        <td class="p-3"> {{ $loop->iteration }} </td>
                        <td class="p-3">{{ $item->from_appointment }}</td>
                        <td class="p-3">{{ $item->to_appointment }}</td>
                        <td class="p-3">{{ $item->appointmentOrderModel->name ?? '' }}</td>
                        <td class="p-3">{{ $item->staffCategory->name ?? '' }}</td>
                        <td class="p-3">
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
            @endif

        </tbody>
    </table>
</div>
