<div data-kt-stepper-element="content">
    <form id="staff_appointment_order">
        @csrf
        <div class="w-100">
            <div class="card card-flush py-0">
                <div class="pt-0">
                    <div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
                        <div class="row">
                            <div class="tble-fnton card mt-0 mb-5 mb-xl-8">
                                <!--begin::Header-->
                                <div class="card-header bg-primary border-0 pt-0">

                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-5 mb-1 text-white"> Service History </span>
                                    </h3>

                                    <button onclick="return editStaffAppointment()" type="button"
                                        class="btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                                        title="Click Here to add More" data-bs-toggle="tooltip"
                                        data-bs-placement="left">
                                        <span id="kt_engage_demos_label">
                                            {!! plusSvg() !!}
                                            Add New
                                        </span>
                                    </button>

                                </div>
                                <div class="card-body py-3" id="appointment-list-pane">
                                    @include('pages.staff.registration.appointment.list')
                                </div>
                            </div>
                            <hr>
                            <div class="row my-3">
                                <div class="col-sm-8">

                                    <div class="col-md-12 fv-row">
                                        @if (isset($staff_details) && !empty($staff_details) && getStaffVerificationStatus($staff_details->id, 'salary_entry'))
                                            <div class="row">
                                                <div class="col-sm-12 mt-6">
                                                    <div class="alert alert-success">
                                                        Salary Database is created
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex">

                                                <a href="javascript:void(0)"
                                                    onclick="return getSalarySlipView('{{ $staff_details->id }}')"
                                                    class="btn btn-light-info w-50"> View Salary </a>
                                                <a class="btn btn-warning w-50"
                                                    href="{{ route('salary.creation', ['staff_id' => $staff_details->id]) }}">
                                                    Edit Salary Database </a>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-sm-12 mt-6">
                                                    <div class="alert alert-warning">
                                                        Salary is not processing. To create salary database click below
                                                        button
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="btn btn-warning w-100"
                                                @if (isset($staff_details) && !empty($staff_details)) href="{{ route('salary.creation', ['staff_id' => $staff_details->id]) }}"
                                            @else 
                                                href="{{ route('salary.creation') }}" @endif>
                                                Create Salary Database </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @include('pages.staff.registration._completed_info')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function deleteStaffAppointment(appointment_id) {
        Swal.fire({
            text: "Are you sure you want to delete?",
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
                    url: "{{ route('staff.delete.appointment') }}",
                    type: 'POST',
                    data: {
                        id: appointment_id
                    },
                    success: function(res) {
                        $('#appointment-list-pane').html(res);
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

    function editStaffAppointment(appointment_id = '') {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.add_edit.appointment') }}",
            type: 'POST',
            data: {
                id: appointment_id
            },
            success: function(res) {
                $('#kt_dynamic_app').modal('show');
                $('#kt_dynamic_app').html(res);
            }
        })
    }

    function listStaffAppointment(staff_id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.appointment.list') }}",
            type: 'POST',
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#appointment-list-pane').html(res);
            }
        })
    }

    $('input[name=probation]').change(function() {

        if ($(this).val() == 'yes') {
            $('#probation_pane').show();
        } else {
            $('#probation_pane').hide();
            // $('#probation_period').val('');
        }

    })

    async function validateAppointmentForm() {
        event.preventDefault();
        var appointment_error = false;

        var key_name = [
            'staff_category_id',
            'nature_of_employment_id',
            'teaching_type_id',
            'place_of_work_id',
            'joining_date',
            'salary_scale',
            'from_appointment',
            'to_appointment',
            'appointment_order_model_id'
        ];

        $('.appointment-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                appointment_error = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container appointment-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!appointment_error) {
            loading();
            var forms = $('#staff_appointment_order_update')[0];
            var formData = new FormData(forms);
            var staff_id = $('#outer_staff_id').val();
            formData.append('staff_id', staff_id);

            const kycResponse = await fetch("{{ route('staff.save.appointment') }}", {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    unloading();

                    if (data.error == 1) {
                        var err_message = '';
                        if (data.message) {
                            data.message.forEach(element => {
                                err_message += '<p>' + element + '</p>';
                            });
                            toastr.error("Error", err_message);
                        }
                        return false;
                    } else {
                        toastr.success("Success", 'Staff Appointment Order Details Saved Successfully');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                        return true;
                    }

                });
            return kycResponse;

        } else {
            return true;
        }
    }

    function generateAppointmentModel() {

        var staff_category_id_update = $('#staff_category_id_update').val();
        var nature_of_employment_id = $('#nature_of_employment_id_update').val();
        var teaching_type_id_update = $('#teaching_type_id_update').val();
        var place_of_work_id_update = $('#place_of_work_id_update').val();
        var joining_date_update = $('#joining_date_update').val();
        var salary_scale_update = $('#salary_scale_update').val();

        if (staff_category_id_update == '' || nature_of_employment_id == '' || teaching_type_id_update == '' ||
            place_of_work_id_update == '' || salary_scale_update == '' || joining_date_update == '') {
            toastr.error('Please fill all mandatory fields');
            return false;
        }

        var order_model_id = $('#appointment_order_model_id_update').val();
        if (order_model_id == '' || order_model_id == 'undefined' || order_model_id == null) {
            toastr.error('Please select Appointment order model');
            return false;
        }

        var forms = $('#staff_appointment_order_update').serializeArray();

        var staff_id = $('#outer_staff_id').val();
        forms.push({
            name: 'staff_id',
            value: staff_id
        });
        $('#generate_order').attr('disabled', true);

        $.ajax({
            url: "{{ route('staff.appointment.preview') }}",
            type: "POST",
            data: forms,
            success: function(res) {
                if (res) {
                    $('#generate_order').attr('disabled', false);
                    var link = document.createElement('a');
                    link.href = res;
                    link.target = "_blank";
                    link.click();
                }
            }
        });
    }

    function getSalarySlipView(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('salary.modal.view') }}",
            type: 'POST',
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#kt_dynamic_app').modal('show');
                $('#kt_dynamic_app').html(res);
            }
        })
    }

    function dovalidateAppointmentForm() {
        event.preventDefault();
        var appointment_error = false;

        var key_name = [
            'staff_category_id_update',
            'nature_of_employment_id_update',
            'teaching_type_id_update',
            'place_of_work_id_update',
            'joining_date_update',
            'salary_scale_update',
            'from_appointment_update',
            'to_appointment_update',
            'appointment_order_model_id_update'
        ];

        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                appointment_error = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container appointment-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!appointment_error) {

            loading();
            var forms = $('#staff_appointment_order_update')[0];
            var formData = new FormData(forms);
            var staff_id = $('#outer_staff_id').val();
            formData.append('staff_id', staff_id);
            $('#validate_appointment_button').attr('disabled', true);
            const kycResponse = fetch("{{ route('staff.update.appointment') }}", {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    unloading();

                    $('#validate_appointment_button').attr('disabled', false);
                    if (data.error == 1) {
                        var err_message = '';
                        if (data.message) {
                            data.message.forEach(element => {
                                err_message += '<p>' + element + '</p>';
                            });
                            toastr.error("Error", err_message);
                        }
                        return false;
                    } else {
                        toastr.success("Success", 'Staff Appointment Order Details Saved Successfully');
                        $('#kt_dynamic_app').modal('hide');
                        setTimeout(() => {
                            listStaffAppointment(data.staff_id)
                        }, 1000);
                        return true;
                    }

                });
            return kycResponse;

        } else {
            return true;
        }
    }
</script>
