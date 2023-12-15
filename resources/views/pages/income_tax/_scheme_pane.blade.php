<div class="row">
    <div class="col-sm-12">
        <form id="regime_form">
            <div class="form-group mt-3">
                <label for="" class="">Select a income tax regime to submit and declare IT</label>
                <div class="mt-5">
                    <select name="scheme_id" id="scheme_id" class="form-control w-200px table-select">
                        <option value="">--select--</option>
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
<script>
    $('.table-select').select2({
        theme: 'bootstrap-5'
    })

    function taxSchemeSetCurrent() {
        var id = $('#scheme_id').val();
        var staff_id=$('#staff_id').val();

        Swal.fire({
            text: "Are you sure you would like to set Current Schemes?",
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
                    data: {
                        id: id,
                        staff_id: staff_id
                    },
                    success: function(res) {
                        if( res.status == 0 ) {

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
</script>
