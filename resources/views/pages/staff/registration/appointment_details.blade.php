<div data-kt-stepper-element="content">
    <form id="staff_appointment_order">
        @csrf
        <div class="w-100">
            <div class="card card-flush py-0">
                <div class="pt-0">
                    <div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12 fv-row mt-10 mb-5">
                                    <div class="pb-5 pb-lg-5">
                                        <h2 class="fw-bolder text-dark">Appointment Details</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-5">
                                <label class="form-label required"> Category of Staff </label>
                                <div class="input-group">
                                    <select name="staff_category_id" autofocus id="staff_category_id"
                                        class="form-select form-select-lg select2-option" required>
                                        <option value="">-- Select Category --</option>
                                        @isset($staff_category)
                                            @foreach ($staff_category as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($staff_details->appointment->category_id) && $staff_details->appointment->category_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if (access()->buttonAccess('staff-category', 'add_edit'))
                                        <button type="button"  class="border-0 btn-light-success btn-sm border"
                                            onclick="return openAddModel('staff_category')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 mb-5">

                                <label class="form-label required">Nature of Employment</label>

                                <div class="input-group">
                                    <select name="nature_of_employment_id" autofocus id="nature_of_employment_id"
                                        class="form-select form-select-lg select2-option" required>
                                        <option value="">-- Select Nature --</option>
                                        @isset($employments)
                                            @foreach ($employments as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($staff_details->appointment->nature_of_employment_id) &&
                                                            $staff_details->appointment->nature_of_employment_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if (access()->buttonAccess('nature-of-employeement', 'add_edit'))
                                        <button type="button"  class="border-0 btn-light-success btn-sm border"
                                            onclick="return openAddModel('nature_of_employeement')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 mb-5">
                                <label class="form-label required"> Teaching Type </label>

                                <div class="input-group">
                                    <select name="teaching_type_id" autofocus id="teaching_type_id"
                                        class="form-select form-select-lg select2-option" required>
                                        <option value="">-- Select Teaching Type --</option>
                                        @isset($teaching_types)
                                            @foreach ($teaching_types as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($staff_details->appointment->teaching_type_id) && $staff_details->appointment->teaching_type_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if (access()->buttonAccess('teaching-type', 'add_edit'))
                                        <button type="button"  class="border-0 btn-light-success btn-sm border"
                                            onclick="return openAddModel('teaching_type')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 mb-5">
                                <label class="form-label required"> Place of Work </label>

                                <div class="input-group">
                                    <select name="place_of_work_id" autofocus id="place_of_work_id"
                                        class="form-select form-select-lg select2-option" required>
                                        <option value=""> -- Select Place Of Work -- </option>
                                        @isset($place_of_works)
                                            @foreach ($place_of_works as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($staff_details->appointment->place_of_work_id) && $staff_details->appointment->place_of_work_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if (access()->buttonAccess('workplace', 'add_edit'))
                                        <button type="button"  class="border-0 btn-light-success btn-sm border"
                                            onclick="return openAddModel('place_of_work')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 fv-row mb-5">
                                <label class="required fs-6 fw-bold mb-2"> Date of Joining </label>
                                <div class="position-relative d-flex align-items-center">
                                    
                                    <input class="form-control  ps-12" placeholder="Select a date" name="joining_date"
                                        id="joining_date" type="date"
                                        value="{{ $staff_details->appointment->joining_date ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-lg-4 mb-5">
                                <label class="form-label required">Salary Scale
                                    <small class="text-muted fs-9">( for appointment order purpose and not for salary
                                        calculation )</small>
                                </label>
                                <input name="salary_scale" id="salary_scale"
                                    value="{{ $staff_details->appointment->salary_scale ?? '' }}"
                                    class="form-control form-control-lg" />
                            </div>
                            <div class="mb-5 col-lg-4 fv-row">
                                <div class="d-inline-block flex-stack">

                                    <div class="fw-bold me-5">
                                        <label class="fs-6">probation</label>
                                    </div>
                                    <div class="d-block mt-5 align-items-center cstm-zeed">
                                        <label class="form-check form-check-custom form-check-solid me-10">
                                            <input class="form-check-input h-20px w-20px" type="radio"
                                                name="probation" value="yes"
                                                @if (isset($staff_details->appointment->has_probation) && $staff_details->appointment->has_probation == 'yes') checked @endif />
                                            <span class="form-check-label fw-bold">Yes </span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-solid me-10">
                                            <input class="form-check-input h-20px w-20px" type="radio"
                                                name="probation" value="no"
                                                @if (
                                                    (isset($staff_details->appointment->has_probation) && $staff_details->appointment->has_probation == 'no') ||
                                                        !isset($staff_details->appointment->has_probation)) checked @endif />
                                            <span class="form-check-label fw-bold">No</span>
                                        </label>
                                    </div>

                                </div>
                                <div id="probation_pane" class="mt-5"
                                    @if (isset($staff_details->appointment->has_probation) && $staff_details->appointment->has_probation == 'yes') @else style="display:none" @endif>
                                    <input type="text" name="probation_period" placeholder="Probation Period"
                                        value="{{ $staff_details->appointment->probation_period ?? '' }}"
                                        id="probation_period" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="row my-3">
                                <div class="col-sm-8">

                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 mb-5">
                                                <label class="form-label required">Period of Appointment (From)</label>
                                                <div class="position-relative d-flex align-items-center">
                                                    
                                                    <input class="form-control  ps-12" placeholder="Select a date"
                                                        name="from_appointment" id="from_appointment" type="date"
                                                        value="{{ $staff_details->appointment->from_appointment ?? '' }}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-5">
                                                <label class="form-label required">Period of Appointment (To)</label>

                                                <div class="position-relative d-flex align-items-center">
                                                    
                                                    <input class="form-control ps-12" placeholder="Select a date"
                                                        name="to_appointment" id="to_appointment" type="date"
                                                        value="{{ $staff_details->appointment->to_appointment ?? '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">

                                            <div class="col-lg-6 mb-5">
                                                <label class="form-label required">
                                                    Appointment order model
                                                </label>
                                                {{-- <a href="javascript:void(0)" class="float-end" onclick="return selectAppointmentModel()"> Select Model </a> --}}
                                                <div class="position-relative">
                                                    <select name="appointment_order_model_id" autofocus
                                                        id="appointment_order_model_id"
                                                        class="form-select form-select-lg " required>
                                                        <option value=""> -- Select Order Model -- </option>
                                                        @isset($order_models)
                                                            @foreach ($order_models as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @if (isset($staff_details->appointment->appointment_order_model_id) &&
                                                                            $staff_details->appointment->appointment_order_model_id == $item->id) selected @endif>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                    {{-- <button type="button"  class="border-0 btn-light-success btn-sm border"
                                                        onclick="return openAddModel('order_model')">
                                                        <i class="fa fa-plus"></i>
                                                    </button> --}}
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <button type="button" class="btn btn-success mt-8"
                                                    id="generate_order"
                                                    @if (isset($staff_details->appointment->appointment_order_model_id) &&
                                                            !empty($staff_details->appointment->appointment_order_model_id)) @else disabled @endif
                                                    onclick="return generateAppointmentModel()"> Generate Appointment
                                                    Order
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-6 fw-bold form-label mb-2">Upload Appointment
                                            Order</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="col-form-label text-lg-right">Upload
                                                    File:</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control-sm" style=""
                                                    type="file" name="appointment_order_doc">
                                            </div>
                                            @isset($staff_details->appointment->appointment_doc)
                                                <div class="col-12">
                                                    <div class="d-flex justiy-content-around flex-wrap">
                                                        @php
                                                            $url = Storage::url($staff_details->appointment->appointment_doc);
                                                        @endphp
                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success"
                                                                href="{{ asset('public' . $url) }}" target="_blank">View
                                                                File </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endisset
                                        </div>
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        @if ( isset( $staff_details ) && !empty( $staff_details ) && getStaffVerificationStatus($staff_details->id, 'salary_entry'))
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
                                                        Salary is not processing to create salary database click below
                                                        button
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="btn btn-warning w-100"
                                            @if ( isset( $staff_details ) && !empty( $staff_details ) )
                                                href="{{ route('salary.creation', ['staff_id' => $staff_details->id]) }}"
                                            @else 
                                                href="{{ route('salary.creation') }}"
                                            @endif
                                                >
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
    $(function() {

        // $("#joining_date").datepicker({
        //     dateFormat: 'd-mm-yy'
        // });

        // $("#from_appointment").datepicker({
        //     dateFormat: 'd-mm-yy'
        // });

        // $("#to_appointment").datepicker({
        //     dateFormat: 'd-mm-yy'
        // });

    });

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
            var forms = $('#staff_appointment_order')[0];
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

        var order_model_id = $('#appointment_order_model_id').val();
        if (order_model_id == '' || appointment_order_model_id == 'undefined' || appointment_order_model_id == null) {
            toastr.error('Please select Appointment order model');
            return false;
        }

        var forms = $('#staff_appointment_order').serializeArray();

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
</script>
