<div data-kt-stepper-element="content">

    <div class="w-100">

        <div class="pb-5 pb-lg-5">
            <h2 class="fw-bolder text-dark">Employee Details</h2>
        </div>
        <form id="position_form">

            <div class="row">
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Designation</label>
                    <div class="position-relative">
                        <select name="designation_id" autofocus id="designation_id"
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Designation--</option>
                            @isset($designation)
                                @foreach ($designation as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->position) && $staff_details->position->designation_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('designation')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
    
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Department</label>
                    <div class="position-relative">
                        <select name="department_id" autofocus id="department_id"
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Department--</option>
                            @isset($department)
                                @foreach ($department as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->position) && $staff_details->position->department_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('department')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Subject</label>
                    <div class="position-relative">
                        <select name="subject[]" autofocus id="subject" multiple
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Subject--</option>
                            @isset($subjects)
                                @foreach ($subjects as $item)
                                    <option value="{{ $item->id }}" @if (isset($used_exp_subjects) && in_array($item->id, $used_exp_subjects)) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('subject')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <input type="hidden" name="id" id="staff_id" value="{{ $staff_details->id ?? '' }}">
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Attendance Scheme</label>
                    <div class="position-relative">
                        <select name="scheme_id" autofocus id="scheme_id" class="form-select form-select-lg select2-option">
                            <option value="">--Select Scheme--</option>
                            @isset($scheme)
                                @foreach ($scheme as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->position) && $staff_details->position->attendance_scheme_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('scheme')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
    
                <hr class="bg-lt-clr mt-3">
                </hr>
                <!--begin::Tables Widget 13-->
                <div class="card mb-0 mb-xl-0 wdth-40percent">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Subject studied upto </span>
                        </h3>
                    </div>
    
                    <div class="card-body py-0">
                        <!--begin::Table container-->
                        <div class="table-responsive" id="studied_pane">
                            <!--begin::Table-->
                            @include('pages.staff.registration.emp_position.studied_subject_pane')
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
    
                <!--begin::Tables Widget 13-->
                <div class="tble-fnton mt-5 card mb-5 mb-xl-8">
    
                    <div class="card-header border-0 pt-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Invigilation Duty Details</span>
                        </h3>
                        <button onclick="openInviligationForm()"
                            class="btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-trigger="hover">
                            <span id="kt_engage_demos_label">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                            rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                        </rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                            fill="currentColor"></rect>
                                    </svg>
                                </span> Add New</span>
                        </button>
                        <button id="kt_new_data_toggle_duty" style="display:none"
                            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-trigger="hover">
    
                        </button>
    
                    </div>
    
                    <div class="card-body py-3" id="invigilation-pane">
                        <!--begin::Table container-->
                        @include('pages.staff.registration.emp_position.invigilation_list')
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
    
                <div class="tble-fnton mt-5 card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Training Details</span>
                        </h3>
                        <button onclick="openTrainingForm()"
                            class=" btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-trigger="hover">
                            <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                            height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                                            fill="currentColor">
                                        </rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2"
                                            rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span> Add New </span>
                        </button>
                        <button id="kt_new_data_toggle_train" style="display:none;"
                            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-trigger="hover">
                            <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                            height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                                            fill="currentColor">
                                        </rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2"
                                            rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span> Add New </span>
                        </button>
                        <!--end::Help drawer-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3" id="training-pane">
                        <!--begin::Table container-->
                        @include('pages.staff.registration.emp_position.training_list')
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
                <!--end::Tables Widget 13-->
    
            </div>
        </form>
        <!--end::Input group-->
    </div>
    <!--end::Wrapper-->
</div>
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_data_toggle_duty"
    data-kt-drawer-close="#kt_help_close">
    <!--begin::Card-->
    @include('pages.staff.registration.emp_position.add_invigilation')
    <!--end::Card-->
</div>
<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_data_toggle_train"
    data-kt-drawer-close="#kt_help_close">
    <!--begin::Card-->
    @include('pages.staff.registration.emp_position.add_training')
    <!--end::Card-->
</div>
<script>
    /**
     * Training functions starts here
     * **/
    function openTrainingForm() {
        $('#kt_new_data_toggle_train').click();

        setTimeout(() => {
            $('#training_title').html('Add Your Training Details');
            $('#from_training_date').val('');
            $('#to_training_date').val('');
            $('#trainer_name').val('');
            $('#training_remarks').val('');
            $('#training_topic').val('').trigger('change');
        }, 100);

        event.preventDefault();
    }

    function editTraining(training_id) {
        $('#kt_new_data_toggle_train').click();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('form.training.content') }}",
            type: "POST",
            data: {
                training_id: training_id
            },
            success: function(res) {

                $('#training_form').html(res);
                $('#training_title').html('Update Your Training Details');
            }
        })
    }

    function deleteTraining(training_id, staff_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('staff.training.delete') }}",
                    type: "POST",
                    data: {
                        training_id: training_id
                    },
                    success: function(res) {

                        staffTrainingList(staff_id);

                        Swal.fire(
                            'Deleted!',
                            'Your Training Details has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }


    function staffTrainingList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.training.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#training-pane').html(res);
            }
        })
    }

    function openInviligationForm() {
        $('#kt_new_data_toggle_duty').click();
        setTimeout(() => {
            $('#duty_facility').val('');
            $('#duty_classes').val('').trigger('change');
            $('#duty_type').val('').trigger('change');
            $('#duty_other_school').val('').trigger('change');
            $('#duty_other_place_id').val('').trigger('change');
            $('#inv_from_date').val('');
            $('#inv_to_date').val('');
            $('#drawer_title').html('Add Your Duty Details');
        }, 100);
        event.preventDefault();

    }

    function editDuty(duty_id) {
        $('#kt_new_data_toggle_duty').click();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('form.invigilation.content') }}",
            type: "POST",
            data: {
                duty_id: duty_id
            },
            success: function(res) {

                $('#invigilation').html(res);
                $('#drawer_title').html('Update Your Duty Details');
            }
        })
    }

    function deleteDuty(duty_id, staff_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('staff.invigilation.delete') }}",
                    type: "POST",
                    data: {
                        duty_id: duty_id
                    },
                    success: function(res) {

                        staffInvigilationList(staff_id);

                        Swal.fire(
                            'Deleted!',
                            'Your Duty data has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }

    function staffInvigilationList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.invigilation.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#invigilation-pane').html(res);
            }
        })
    }

    function submitInvigilationForm() {
        var invigilationErrors = false;
        let key_name = [
            'duty_classes',
            'duty_type',
            'other_school',
            'duty_other_place_id',
            'inv_from_date',
            'inv_to_date',
            'duty_facility'
        ];
        $('.invigilation-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                invigilationErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container invigilation-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!invigilationErrors) {
            var staff_id = $('#outer_staff_id').val();
            var forms = $('#invigilation')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);
            $.ajax({
                url: "{{ route('save.invigilation') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // Disable submit button whilst loading

                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success(
                            "Invigilation duty added successfully"
                        );

                        $('#kt_help_close').click();
                        staffInvigilationList(staff_id);
                    }
                }
            })
        }
    }

    function submitTrainingForm() {

        var trainingErrors = false;
        let key_name = [
            'from_training_date',
            'to_training_date',
            'trainer_name',
            'training_topic',
            'training_remarks'
        ];
        $('.training-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;
            if (name_input == '' || name_input == undefined) {
                trainingErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container training-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!trainingErrors) {
            var staff_id = $('#staff_id').val();
            var forms = $('#training_form')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);
            $.ajax({
                url: "{{ route('save.staff.training') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // Disable submit button whilst loading

                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success(
                            "Staff Training added successfully"
                        );

                        $('#kt_help_close').click();
                        staffTrainingList(staff_id);
                    }
                }
            })
        }

    }

    function validateEmployeePosition() {
        event.preventDefault();
        var emp_position_errors = false;

        var key_name = [
            'designation_id',
            'department_id',
            'subject',
            'scheme_id',
            'nationality_id',
            'religion_id',
            'caste_id',

        ];

        $('.kyc-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                emp_position_errors = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container kyc-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!emp_position_errors) {

            var forms = $('#position_form')[0];
            var formData = new FormData(forms);
            $.ajax({
                url: "{{ route('staff.save.employee_position') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    unloading();

                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error", element);
                            });
                        }
                        // console.log('form erorro occurres');
                        return true;

                    } else {
                        event.preventDefault();
                        console.log('form submit success');
                        return false;
                    }
                    console.log('resoponse recevied');
                }
            })
        } else {

            return true;
        }
    }
</script>
@if (isset($staff_details->id))
    <script>
        staffInvigilationList('{{ $staff_details->id }}');
        staffTrainingList('{{ $staff_details->id }}');
    </script>
@endif
