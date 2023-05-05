<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <form id="educateStaffform" class="w-100">
            @csrf
            <div class="pb-5 pb-lg-5">
                <h2 class="fw-bolder text-dark">Education Details</h2>
            </div>

            <div class="tble-fnton card mb-5 mb-xl-8">

                <div class="card-header bg-primary border-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"> Completed / Under going </span>
                    </h3>
                    <button onclick="return openEducationForm()"
                    class="btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                    title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-dismiss="click" data-bs-trigger="hover">
                    <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                    rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                </rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                    fill="currentColor"></rect>
                            </svg>
                        </span> Add New</span>
                </button>
                    <button id="kt_new_data_toggle_educate" style="display:none;"
                        class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                        title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-trigger="hover">
                    </button>
                </div>

                <div class="card-body py-3" id="course-pane">
                    @include('pages.staff.registration.education.course')
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 13-->
            <hr class="bg-lt-clr">
            </hr>
            <!--begin::Tables Widget 13-->
            <div class="card mb-0 mb-xl-0 wdth-30percent">
                <!--begin::Header-->
                <div class="card-header bg-primary border-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Languages Known</span>

                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                    <!--begin::Table container-->
                    <div class="table-responsive" id="language-table">
                        @include('pages.staff.registration.education.language')
                    </div>
                    <!--end::Table container-->
                </div>
                <a class="btn btn-sm btn-primary" onclick="return openAddModel('new_language')"> Add New Language</a>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 13-->
            <hr class="bg-lt-clr">
            </hr>
            <!--begin::Tables Widget 13-->
            <div class="tble-fnton card mt-10 mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header bg-primary border-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Past Experience</span>
                    </h3>

                    <button onclick="return openExperienceForm()" class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                        title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-trigger="hover">
                        <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                    </rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor"></rect>
                                </svg>
                            </span> Add New</span>
                    </button>

                    <button id="kt_new_data1_toggle" style="display: none;"
                        class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                        title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-trigger="hover">
                    
                    </button>

                </div>
            
                <div class="card-body py-3" id="experience-pane">
                    @include('pages.staff.registration.education.experience_list')
                </div>
            </div>

            {{-- <hr class="bg-lt-clr">
            </hr> --}}

            {{-- <div class="tble-fnton card mt-10 mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header order-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">
                            Certificate Request
                        </span>
                    </h3>

                    <button id="kt_new_data1_toggle_1"
                        class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                        title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-trigger="hover">
                        <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                    </rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor"></rect>
                                </svg>
                            </span> Add New</span>
                    </button>

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    @include('pages.staff.registration.education.certificate_list')
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div> --}}
            <!--end::Tables Widget 13-->
            <hr class="bg-lt-clr">
            </hr>
            <input type="hidden" name="id" id="staff_id" value="{{ $staff_details->id ?? '' }}">
            <div class="pb-5 pb-lg-5 mt-10">
                <!--begin::Title-->
                <h2 class="fw-bolder text-dark">Other Talents</h2>
                <!--end::Title-->
            </div>
            <div class="row">
                <!--begin::Input group-->
                <div class="col-lg-6 mb-5">
                
                    <label class="form-label">Sports</label>               
                    <textarea name="sports" class="form-control form-control-lg form-control-solid" rows="3">{{ getTalents($staff_details->id ?? '', 'sports')->talent_descriptions ?? '' }}</textarea>
                
                </div>
            
                <div class="col-lg-6 mb-5">
                
                    <label class="form-label">Fine Arts</label>               
                    <textarea name="fine_arts" class="form-control form-control-lg form-control-solid" rows="3">{{ getTalents($staff_details->id ?? '', 'fine_arts')->talent_descriptions ?? '' }}</textarea>
                
                </div>
            
                <div class="col-lg-6 mb-5">
                
                    <label class="form-label">Vocational</label>               
                    <textarea name="vocational" class="form-control form-control-lg form-control-solid" rows="3">{{ getTalents($staff_details->id ?? '', 'vocational')->talent_descriptions ?? '' }}</textarea>
                
                </div>
            
                <div class="col-lg-6 mb-5">
                
                    <label class="form-label">Others </label>               
                    <textarea name="others" class="form-control form-control-lg form-control-solid" rows="3">{{ getTalents($staff_details->id ?? '', 'others')->talent_descriptions ?? '' }}</textarea>
                
                </div>
                <!--end::Input group-->
            </div>
        </form>
    </div>
    <!--end::Wrapper-->
</div>
<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_data_toggle_educate"
    data-kt-drawer-close="#kt_help_close">
    <!--begin::Card-->
    @include('pages.staff.registration.education.course_form')
    <!--end::Card-->
</div>
<!--end::Help drawer-->

<!--begin::Help drawer Experience  -->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_data1_toggle"
    data-kt-drawer-close="#kt_help_close">
    <!--begin::Card-->
    @include('pages.staff.registration.education.experience_form')
    <!--end::Card-->
</div>
<!--end::Help drawer-->

<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_data1_toggle_1"
    data-kt-drawer-close="#kt_help_close">
    <!--begin::Card-->
    @include('pages.staff.registration.education.certificate_form')
    <!--end::Card-->
</div>
<!--end::Help drawer-->
<script>
    function openEducationForm() {
        event.preventDefault();
        $('#kt_new_data_toggle_educate').click();

        setTimeout(() => {
            $('#education_title').html('Add Your Education Details');
            $('#course_name').val('');
            $('#course_completed_year').val('');
            $('#board_id').val('').trigger('change');
            $('#ancillary_subject_id').val('').trigger('change');
            $('#main_subject_id').val('').trigger('change');
            $('#course_certificate_no').val('');
            $('#course_submitted_date').val('');
            $('#course_professional_type').val('').trigger('change');
            $('#course_file').val('');
            $('#course_id').val('');
        }, 100);

    }

    function editCourse(staff_id, course_id) {
        event.preventDefault();
        $('#kt_new_data_toggle_educate').click();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('form.course.content') }}",
            type: "POST",
            data: {
                staff_id: staff_id,
                course_id: course_id
            },
            success: function(res) {

                $('#education_form').html(res);
                $('#education_title').html('Update Your Education Details');
            }
        })
    }

    function deleteCourse(staff_id, course_id) {
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
                    url: "{{ route('staff.course.delete') }}",
                    type: "POST",
                    data: {
                        course_id: course_id
                    },
                    success: function(res) {

                        staffCourseList(staff_id);

                        Swal.fire(
                            'Deleted!',
                            'Your Course data has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }

    function staffCourseList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.course.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#course-pane').html(res);
            }
        })
    }

    function submitCourseForm() {

        event.preventDefault();

        var courseErrors = false;
        let key_name = [
            'course_name',
            'board_id',
            'course_completed_year',
            'main_subject_id',
            'ancillary_subject_id',
            'course_certificate_no',
            'course_submitted_date',
            'course_professional_type'
        ];
        $('.course-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                courseErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container couser-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!courseErrors) {
            var staff_id = $('#outer_staff_id').val();
            var forms = $('#education_form')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);
            $.ajax({
                url: "{{ route('save.staff.course') }}",
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
                            "Course added successfully"
                        );

                        $('#kt_help_close').click();
                        staffCourseList(staff_id);
                    }
                }
            })
        }
    }

    /**
     *  Past experince starts
     * ***/
    function openExperienceForm() {
        event.preventDefault();
        $('#kt_new_data1_toggle').click();

        setTimeout(() => {
            $('#experience_title').html('Add Your Past Experience');
            $('#experience_institute_name').val('');
            $('#experience_designation').val('');
            $('#experience_from').val('');
            $('#experience_to').val('');
            $('#experince_institute_address').val('');
            $('#salary_drawn').val('');
            $('#experience_year').val('');
            $('#experience_id').val('');
        }, 100);

    }

    function editExperience(staff_id, experience_id) {
        event.preventDefault();
        $('#kt_new_data1_toggle').click();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('form.experience.content') }}",
            type: "POST",
            data: {
                staff_id: staff_id,
                experience_id: experience_id
            },
            success: function(res) {

                $('#experience_form').html(res);
                $('#experience_title').html('Update Your Education Details');
            }
        })
    }

    function deleteExperience(staff_id, experience_id) {
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
                    url: "{{ route('staff.experience.delete') }}",
                    type: "POST",
                    data: {
                        experience_id: experience_id
                    },
                    success: function(res) {

                        staffExperienceList(staff_id);

                        Swal.fire(
                            'Deleted!',
                            'Your Experience data has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }

    function staffExperienceList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.experience.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#experience-pane').html(res);
            }
        })
    }

    function submitExperienceForm() {

        event.preventDefault();

        var experienceErrors = false;
        let key_name = [
            'experience_institute_name',
            'experience_designation',
            'experience_from',
            'experience_to',
            'experince_institute_address',
            'salary_drawn',
            'experience_year'
        ];
        $('.experience-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;
            
            if (name_input == '' || name_input == undefined) {
                experienceErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container experience-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!experienceErrors) {
            var staff_id = $('#outer_staff_id').val();
            var forms = $('#experience_form')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);
            $.ajax({
                url: "{{ route('save.staff.experience') }}",
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
                            "Experience added successfully"
                        );

                        $('#kt_help_close').click();
                        staffExperienceList(staff_id);
                    }
                }
            })
        }
    }

    /*
    starts phase model submits
    */
    async function validateEducationDetails() {
        event.preventDefault();
        var education_staff_errors = false;

        if (!education_staff_errors) {
            loading();

            var forms = $('#educateStaffform')[0];
            var staff_id = $('#outer_staff_id').val();
            var formData = new FormData(forms);
            
            formData.append('id', staff_id);

            const eduResponse = await fetch("{{ route('staff.save.education_details') }}", {
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
            return eduResponse

            $.ajax({
                url: "{{ route('staff.save.education_details') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                beforeSend: function() {
                    
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