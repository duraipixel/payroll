
<div class="table-responsive">
<div class="tble-fnton mt-5 card mb-5 mb-xl-8">

<div class="bg-primary p-2 d-flex align-items-center justify-content-between">
<h3 class="fs-7 text-white m-0">
    <span class="card-label fw-bolder fs-5 mb-1">Schema</span>
</h3>
<button id="kt_new_data_toggle_duty" style="display:none"
    class="engage-demos-toggle btn btn-sm btn-success" title="Click Here to add More"
    data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click"
    data-bs-trigger="hover">

</button>

</div>

<div class="card-body py-3" id="invigilation-pane">
<div class="row">
 <div class="col-sm-12">
        <form id="regime_form">
            <div class="form-group mt-3">
                <label for="" class="">Select a income tax regime to submit and declare IT</label>
                <div class="mt-5">
                    <select name="scheme_id" id="scheme_id" class="form-control w-200px table-select">
                        <option selected value="">--Select scheme--</option>
                        @if (isset($tax_scheme) && !empty($tax_scheme))
                            @foreach ($tax_scheme as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->tax_scheme_id) && $staff_details->tax_scheme_id == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <input type="hidden" name="staff_id" id="staff_id" value="{{($staff_details->id ?? Auth::user()->id)}}">
              
            <div class="form-group mt-5">
                <button class="btn btn-primary btn-sm" type="button" id="regime_button" onclick="taxSchemeSetCurrent()"> Save </button>
            </div>
           
        </form>
    </div>
</div>
</div>
<!--begin::Body-->
</div>
<div class="tble-fnton mt-5 card mb-5 mb-xl-8">

<div class="bg-primary p-2 d-flex align-items-center justify-content-between">
<h3 class="fs-7 text-white m-0">
    <span class="card-label fw-bolder fs-5 mb-1">Leave Mapping</span>
</h3>
</div>
<div class="card-body py-3" id="invigilation-pane">
 <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">

        <thead>
            <tr class="fw-bolder text-muted">
                <th class="min-w-50px">Heads</th>
                <th class="min-w-120px">No Of Leave Days</th>
                <th class="min-w-120px text-end">Actions</th>
            </tr>
        </thead>

        <tbody>
            @isset($leave_mappings)
                @foreach ($leave_mappings as $leave_mapping)
                    <tr>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            @if(isset($leave_mapping->leave_head)){{$leave_mapping->leave_head->name}}@endif
                        </td>

                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                              {{$leave_mapping->no_of_leave}}
                        </td>
                        <td class="text-end">
                            <a href="javascript:void(0)" onclick="getLeaveInformationModal({{ $leave_mapping->id }})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                              <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z"></path></svg>
                            </a>
                           
                        </td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
    </table>
</div>
</div>
</div>
<section class="popup">
  <div class="popup__content">
    <div class="close">
      <span></span>
      <span></span>
      asfsadf
    </div>
  </div>
</section>
<script>
$("#taken_data").click(function() {
  $(".popup").fadeIn(500);
});
$(".close").click(function() {
  $(".popup").fadeOut(500);
});
   async function ValidationSchemeSetCurrent() {
     return false;
    }
    function taxSchemeSetCurrent() {
       var formData =$("#regime_form").serialize();
        Swal.fire({
            text: "All the existing Income tax data. Do you want to Proceed?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('taxscheme.set.current') }}",
                    type: 'POST',
                    data:formData,
                    success: function(res) {
                        if( res.error == 0 ) {

                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: res.message,
                                icon: "danger",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                timer: 3000
                            });
                        }

                    },
                    error: function(xhr, err) {
                        if (xhr.status == 403) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });
            }
        });
    }
 function getLeaveInformationModal(id = '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formMethod = "addEdit";
            $.ajax({
                url: "{{ route('staff.leave-mapping.edit') }}",
                type: 'POST',
                data: {
                    id: id,

                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })

        }
</script>