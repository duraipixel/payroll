<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">

        <!--begin::Tables Widget 13-->

        <div class="pb-0 pb-lg-0 mt-0">
            <!--begin::Title-->
            <h2 class="fw-bolder text-dark">Family Information</h2>
            <!--end::Title-->
        </div>
        <div class="tble-fnton card mt-0 mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Family Details</span>
                </h3>

                <button onclick="return openFamilyForm()"
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
                <button id="kt_new_family_toggle" style="display:none"
                    class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                    title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-dismiss="click" data-bs-trigger="hover">
                </button>

            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3" id="family-list-pane">
                <!--begin::Table container-->
                @include('pages.staff.registration.family.family_list')
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 13-->

        <div class="card card-flush py-0">
            <div class="pt-5">
                <div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">

                    @include('pages.staff.registration.nominee.nominee_pane')

                    @include('pages.staff.registration.relation_working.working_pane')

                </div>
            </div>
        </div>
    </div>
</div>
<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_family_toggle"
    data-kt-drawer-close="#kt_help_close">
    @include('pages.staff.registration.family.family_form')
</div>
<!--end::Help drawer-->

<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_nominiee_toggle"
    data-kt-drawer-close="#kt_help_close">
    <!--begin::Card-->
    @include('pages.staff.registration.nominee.nominee_form')
    <!--end::Card-->
</div>
<!--end::Help drawer-->
<script>
    var familyFormContentUrl = "{{ route('form.family.content') }}";
    var deleteStaffFamilyDetailsUrl = "{{ route('staff.family.delete') }}";
    var insertFamilyMemberUrl = "{{ route('staff.member.save') }}";
    var staffMemberList = "{{ route('staff.member.list') }}";
</script>
<script src="{{ asset('assets/js/form/registration/validateFamilyFrom.js') }}"></script>
<script>

    function openNomineeForm() {
        event.preventDefault();
        $('#kt_new_nominiee_toggle').click();
        $('#nominee_id').val('');
        $('#nominee_age').val('');
        $('#share').val('');
        $('#minor_name').val('');
        $('#minor_contact').val('');
        $('#minor_address').val('');
        $('#staff_nominee_id').val('');
    }

    function editNomineeForm(staff_id, nominee_id ){
        event.preventDefault();
        $('#kt_new_nominiee_toggle').click();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.nominee.form.content') }}",
            type: "POST",
            data: {
                nominee_id: nominee_id
            },
            success: function(res) {
                $('#nominee_form').html(res);
                $('#nominee_form_title').html('Update Your Nominee Details');
            }
        })

    }

    function addNominee() {
        var nomineeErrors = false;
        let key_name = [
            'nominee_id',
            'nominee_age',
            'share'           
        ];
        $('.nominee-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                nomineeErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container nominee-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!nomineeErrors) {
            var staff_id = $('#outer_staff_id').val();
            var forms = $('#nominee_form')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);
            $.ajax({
                url: "{{ route('staff.nominee.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success(
                            "Staff Nominee added successfully"
                        );
                        $('#kt_help_close').click();
                        getStaffNomineeList(staff_id);
                    }
                }
            })
        }
    }

    function getStaffNomineeList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.nominee.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#nominee-list-pane').html(res);
            }
        })
    }

    function deleteNominee(staff_id, nominee_id) {
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
                    url: "{{ route('staff.nominee.delete') }}",
                    type: "POST",
                    data: {
                        nominee_id: nominee_id
                    },
                    success: function(res) {

                        getStaffNomineeList(staff_id);

                        Swal.fire(
                            'Deleted!',
                            'Your Nominee data has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }

    async function validateFamilyPhase() {
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
