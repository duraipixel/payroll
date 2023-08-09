<table style="box-shadow: 3px 2px 5px 1px #ddd;" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">

    <thead>
        <tr class="fw-bold fs-6 text-gray-800 text-center border-0 bg-light">
            <th colspan="2" class="min-w-200px rounded-start rounded-end text-white" style="background: #ff8e8e;">
                Completed Progress </th>
        </tr>
    </thead>

    <tbody class="border-bottom border-dashed">

        <tr class="text-center">
            <td class="text-start ps-6">
                <div class="fw-bold fs-6 text-gray-800"> Data Entry </div>
            </td>
            <td>
                @if (isset($staff_details) && !empty($staff_details) && getStaffVerificationStatus($staff_details->id, 'data_entry'))
                    {!! yesTickSvg() !!}
                @else
                    {!! noTickSvg() !!}
                @endif
            </td>
        </tr>
        <tr class="text-center">
            <td class="text-start ps-6">
                <div class="fw-bold fs-6 text-gray-800">
                    Document Uploaded
                </div>
            </td>
            <td>
                @if (isset($staff_details) && !empty($staff_details) && getStaffVerificationStatus($staff_details->id, 'doc_uploaded'))
                    {!! yesTickSvg() !!}
                @else
                    {!! noTickSvg() !!}
                @endif
            </td>
        </tr>
        <tr class="text-center">
            <td class="text-start ps-6">
                <div class="fw-bold fs-6 text-gray-800">
                    Document Verified
                </div>
            </td>
            <td>
                @if (isset($staff_details) && !empty($staff_details) && getStaffVerificationStatus($staff_details->id, 'doc_verified'))
                    {!! yesTickSvg() !!}
                @else
                    {!! noTickSvg() !!}
                @endif
            </td>
        </tr>
        <tr class="text-center">
            <td class="text-start ps-6">
                <div class="fw-bold fs-6 text-gray-800">
                    Salary Entry
                </div>
            </td>
            <td>
                @if (isset($staff_details) && !empty($staff_details) && getStaffVerificationStatus($staff_details->id, 'salary_entry'))
                    {!! yesTickSvg() !!}
                @else
                    {!! noTickSvg() !!}
                @endif
            </td>
        </tr>
        <tr class="text-center">
            <td colspan="2">
                <div class="alert alert-warning small">
                    Only when data entry, uploading, and document verification are
                    complete can employee codes be created.
                </div>
            </td>
        </tr>
        @if( !$staff_details->society_emp_code )
        <tr class="text-center">
            <td colspan="2">
                <button type="button" class="btn btn-light-success btn-sm"  onclick="generateEmployeeCodecheck('{{$staff_details->id}}')"> Click to generate Employee Code </button>
            </td>
        </tr>
        @endif
        @if( isset( $staff_details->verification_status ) && $staff_details->verification_status == 'pending' )
        <tr class="text-center">
            <td colspan="2">
                <div class="alert alert-danger small">
                    Verification not Completed. Click finish button to Approve Verification.
                </div>
            </td>
        </tr>
        @else
        <tr class="text-center">
            <td colspan="2">
                <div class="alert alert-success small">
                    Approved
                </div>
            </td>
        </tr>
        @endif

    </tbody>

</table>


<script>
    function generateEmployeeCodecheck(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.generate.code') }}",
            type: "POST",
            data: {staff_id:staff_id},
            success: function(res) {
                if( res.error == 0 ) {
                    toastr.success( 'Success', res.message );

                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    toastr.error( 'error', res.message );
                }
            }
        });
    }
</script>