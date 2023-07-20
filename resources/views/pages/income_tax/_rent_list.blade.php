<form id="other_income_form">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between">
                <div class="from-group">
                    <label> House Rent Monthly </label>
                </div>
                <div class="from-group">
                    @if( isset( $statement_data ) && !empty( $statement_data ) && $statement_data->lock_calculation == 'yes')
                    @else
                        <button type="button" class="btn btn-primary btn-sm" onclick="return addNewRent()"> Add New
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12" id="rent_table">
            @include('pages.income_tax._rent_table')
        </div>
        @if( isset( $statement_data ) && !empty( $statement_data ) && $statement_data->lock_calculation == 'no')
        <div class="col-sm-12 text-end mt-3">
            <button class="btn btn-dark btn-sm" type="button"> cancel </button>
            <button class="btn btn-success btn-sm" type="submit"> Save </button>
        </div>
        @endif
    </div>
</form>
<script>
    function staffRentList() {
        var staff_id = $('#staff_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('it.rent.list') }}",
            type: 'POST',
            data: {
                staff_id: staff_id
            },
            beforeSend: function() {
                $('#rent_table').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#rent_table').removeClass('blur_loading_3px');
                $('#rent_table').html(res);
            }
        })
    }

    function addNewRent() {

        var staff_id = $('#staff_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('it.rent.add') }}",
            type: 'POST',
            data: {
                staff_id: staff_id
            },
            beforeSend: function() {},
            success: function(res) {
                $('#kt_dynamic_app').modal('show');
                $('#kt_dynamic_app').html(res);
            }
        })

    }

    function deleteRent(rent_id) {
        Swal.fire({
            text: "Are you sure you would like to delete record?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Delete it!",
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
                    url: "{{ route('it.rent.delete') }}",
                    type: 'POST',
                    data: {
                        rent_id: rent_id
                    },
                    beforeSend: function() {
                        $('#rent_table').addClass('blur_loading_3px');
                    },
                    success: function(res) {
                        $('#rent_table').removeClass('blur_loading_3px');
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
                        staffRentList();
                    }
                })

            }
        });
    }
</script>
