<!--begin::Card-->
<div class="card shadow-none rounded-0 w-100">
    <!--begin::Header-->
    <div class="card-header" id="kt_help_header">
        <h5 class="card-title fw-bold text-gray-600" id="family-form-title">Add Your Family Details</h5>
        <div class="card-toolbar">
            <button type="button"
                class="btn btn-sm btn-icon explore-btn-dismiss me-n5"
                id="kt_help_close">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="6" y="17.3137"
                            width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)"
                            fill="currentColor" />
                        <rect x="7.41422" y="6" width="16"
                            height="2" rx="1"
                            transform="rotate(45 7.41422 6)"
                            fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body p-5" id="kt_help_body">
       <form id="family_form" autocomplete="off">
            @include('pages.staff.registration.family.form_content')
       </form>
    </div>
    <!--end::Body-->
</div>
<!--end::Card-->