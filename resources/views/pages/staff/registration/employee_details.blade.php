<div data-kt-stepper-element="content">

    <div class="w-100">

        <div class="pb-5 pb-lg-5">
            <h2 class="fw-bolder text-dark">Employee Details</h2>
        </div>
        <form id="position_form">
            @csrf
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
                        @if( access()->buttonAccess('designation','add_edit') )
                        <span class="z-index-85 position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('designation')">
                            <i class="fa fa-plus"></i>
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Department</label>
                    <div class="position-relative">
                        <select name="department_id" autofocus id="department_id"
                            onchange="return checkTeachingType(this.value)"
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
                        @if( access()->buttonAccess('department','add_edit') )
                        <span class="z-index-85 position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('department')">
                            <i class="fa fa-plus"></i>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Division</label>
                    <div class="position-relative">
                        <select name="division_id" id="division_id" class="form-select form-select-lg ">
                            <option value="">--Select Division--</option>
                            @isset($divisions)
                                @foreach ($divisions as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->position) && $staff_details->position->division_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if( access()->buttonAccess('division','add_edit') )
                        <span class="z-index-85 position-absolute btn btn-success btn-md top-0 end-0 p-4"
                            onclick="return openAddModel('division')">
                            <i class="fa fa-plus"></i>
                        </span>
                        @endif
                    </div>
                </div>
                <!--end::Input group-->
                <div class="col-lg-4 mb-5 teaching" style="display: @if(isset( $staff_details->position->is_teaching_staff ) && $staff_details->position->is_teaching_staff == 'yes' ) block @else none @endif">
                    <label class="form-label required">Class Handling</label>
                    <div class="position-relative">
                        <select id="classes" name="class_id[]" class="form-control big_box select2-option"
                            placeholder="" multiple>
                            @isset($classes)
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}" @if (isset($used_classes) && in_array($item->id, $used_classes)) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        @if( access()->buttonAccess('class','add_edit') )
                        <span class="z-index-85 position-absolute btn btn-success btn-md top-0 end-0 p-4"
                            onclick="return openAddModel('class')">
                            <i class="fa fa-plus"></i>
                        </span>
                        @endif
                    </div>
                </div>
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5 teaching" style="display: @if(isset( $staff_details->position->is_teaching_staff ) && $staff_details->position->is_teaching_staff == 'yes' ) block @else none @endif">
                    <label class="form-label required">Handling Subject</label>
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
                        <span class="z-index-85 position-absolute btn btn-success btn-md top-0 end-0"
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
                        <select name="scheme_id" autofocus id="scheme_id"
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Scheme--</option>
                            @isset($scheme)
                                @foreach ($scheme as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->position) && $staff_details->position->attendance_scheme_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        {{-- @if( access()->buttonAccess('scheme','add_edit') )
                        <span class="z-index-85 position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('scheme')">
                            <i class="fa fa-plus"></i>
                        </span>
                        @endif --}}
                    </div>
                </div>

                <hr class="bg-lt-clr mt-3">
                </hr>
                <!--begin::Tables Widget 13-->
                <div class="card mb-0 mb-xl-0 wdth-40percent teaching" style="display: @if(isset( $staff_details->position->is_teaching_staff ) && $staff_details->position->is_teaching_staff == 'yes' ) block @else none @endif">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Subject Handling upto </span>
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

                    <div class="card-header bg-primary border-0 pt-0">
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
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                            height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                                            fill="currentColor">
                                        </rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2"
                                            rx="1" fill="currentColor"></rect>
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
                    <div class="card-header bg-primary border-0 pt-0">
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
    var global_is_teaching = false;
    @if(isset( $staff_details->position->is_teaching_staff ) && $staff_details->position->is_teaching_staff == 'no' )
        global_is_teaching = true;
    @endif
    function checkTeachingType(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.department') }}",
            type: 'POST',
            data: {
                id: id
            },
            success: function(res) {
                console.log(res);
                if (res.is_teaching == 'no') {
                    $('.teaching').hide();
                    global_is_teaching = true;
                } else {
                    $('.teaching').show();
                    global_is_teaching = false;
                }
            }
        })
    }
    /**
     * Training functions starts here
     * **/
    function getStudiedSubjectElements() {
        var staff_id = $('#outer_staff_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.studied.subject') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#studied_pane').html(res);
            }
        })
    }

    function openTrainingForm() {
        $('#kt_new_data_toggle_train').click();

        setTimeout(() => {
            $('#training_title').html('Add Your Training Details');
            $('#from_training_date').val('');
            $('#to_training_date').val('');
            $('#trainer_name').val('');
            $('#training_remarks').val('');
            $('#training_topic').val('').trigger('change');
            $('#training_id').val('');
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
            $('#duty_id').val('');
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

    async function validateEmployeePosition() {
        event.preventDefault();
        console.log(global_is_teaching, 'global_is_teaching');
        var emp_position_errors = false;
        if (global_is_teaching) {
            var key_name = [
                'designation_id',
                'department_id',
                'division_id',
                'scheme_id'              
            ];
        } else {

            var key_name = [
                'designation_id',
                'department_id',
                'division_id',
                'subject',
                'scheme_id',
                'classes'              
            ];
        }

        $('.kyc-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            console.log(element);
            var name_input = document.getElementById(element).value;
            console.log(name_input)

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
            loading();
            var forms = $('#position_form')[0];
            var formData = new FormData(forms);
            var staff_id = $('#outer_staff_id').val();
            formData.append('outer_staff_id', staff_id);
            formData.append('id', staff_id);
            formData.append('global_is_teaching', global_is_teaching);

            const employeeResponse = await fetch("{{ route('staff.save.employee_position') }}", {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    unloading();

                    if (data.error == 1) {
                        if (data.message) {
                            data.message.forEach(element => {
                                toastr.error("Error", element);
                            });
                        }
                        return true;
                    } else {
                        return false;
                    }

                });
            return employeeResponse;

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
