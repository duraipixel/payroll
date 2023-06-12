<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">

        <div class="pb-0 pb-lg-0 mt-0">
            
            <h2 class="fw-bolder text-dark"> Family Information </h2>
            
        </div>
        <div class="tble-fnton card mt-0 mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header bg-primary border-0 pt-0">
                
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-5 mb-1 text-white"> Family Details </span>
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
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_new_family_toggle" data-kt-drawer-close="#kt_help_close"  style="z-index: 2222;">
    @include('pages.staff.registration.family.family_form')
</div>
<!--end::Help drawer-->

<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_new_nominiee_toggle" data-kt-drawer-close="#kt_help_close"  style="z-index: 2222;">
    <!--begin::Card-->
    @include('pages.staff.registration.nominee.nominee_form')
    <!--end::Card-->
</div>
<!--end::Help drawer-->
<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_new_aews_toggle" data-kt-drawer-close="#kt_help_close"  style="z-index: 2222;">
    <!--begin::Card-->
    @include('pages.staff.registration.relation_working.relation_working_form')
    <!--end::Card-->
</div>
<!--end::Help drawer-->
<script>
    var familyFormContentUrl = "{{ route('form.family.content') }}";
    var deleteStaffFamilyDetailsUrl = "{{ route('staff.family.delete') }}";
    var insertFamilyMemberUrl = "{{ route('staff.member.save') }}";
    var staffMemberList = "{{ route('staff.member.list') }}";
    var nomineeFormContentUrl = "{{ route('staff.nominee.form.content') }}";
    var insertNomineeUrl = "{{ route('staff.nominee.save') }}";
    var staffNomineeList = "{{ route('staff.nominee.list') }}";
    var deleteStaffNomineeUrl = "{{ route('staff.nominee.delete') }}";
    var relationWorkingFormContentUrl = "{{ route('staff.working.relation.content') }}";
    var insertRelationWorkingDetailUrl = "{{ route('staff.save.working_relationship') }}";
    var StaffRelationWorkingListUrl = "{{ route('staff.working.relation.list') }}";
    var deleteStaffRelationWorkingUrl = "{{ route('staff.relation.working.delete') }}";
    var nationalityList = "{{ route('nationality.ajax.list') }}";
    // var getNomineeAjaxurl = "{{ route('staff.relation.working.delete') }}";
</script>
<script src="{{ asset('assets/js/form/registration/validateFamilyFrom.js') }}"></script>
<script src="{{ asset('assets/js/form/registration/nomineeForm.js') }}"></script>
<script src="{{ asset('assets/js/form/registration/workingRelationForm.js') }}"></script>
<script>
    

    async function validateFamilyPhase() {
        event.preventDefault();
        var staff_id = $('#outer_staff_id').val();

        const employeeResponse = await fetch("{{ route('staff.save.familyPhase') }}", {
                    method: 'POST',
                    body: JSON.stringify({staff_id:staff_id}),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Content-Type": "application/json",
                    }
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
        
    }
</script>
