<!--begin::Table-->
<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
    <!--begin::Table head-->
    <thead>
        <tr class="fw-bolder text-muted">
            <th class="min-w-50px">Languages</th>
            <th class="min-w-140px">Read</th>
            <th class="min-w-120px">Write</th>
            <th class="min-w-120px">Speak</th>
        </tr>
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody id="language-table-body">
        @isset($mother_tongues)
            @foreach ($mother_tongues as $item)
                <tr>
                    <td class="text-dark fw-bolder text-hover-primary fs-6">{{ $item->name }}</td>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input widget-13-check" name="read[]" @if( isset($staff_details) && getStaffKnownLanguages($staff_details->id, $item->id, 'read')) checked @endif type="checkbox" value="{{ $item->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input widget-13-check" name="write[]" @if( isset($staff_details) && getStaffKnownLanguages($staff_details->id, $item->id, 'write')) checked @endif type="checkbox" value="{{ $item->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input widget-13-check" name="speak[]" @if( isset($staff_details) && getStaffKnownLanguages($staff_details->id, $item->id, 'speak')) checked @endif type="checkbox" value="{{ $item->id }}" />
                        </div>
                    </td>
                </tr>
            @endforeach

        @endisset


    </tbody>
    <!--end::Table body-->
</table>
<!--end::Table-->
