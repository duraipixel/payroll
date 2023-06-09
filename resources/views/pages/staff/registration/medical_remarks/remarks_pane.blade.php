<div class="tble-fnton card mt-5 mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header bg-primary border-0 pt-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-5 mb-1">Medical remarks</span>
        </h3>

        <button onclick="return openMedicalRemarkForm()"
            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
            title="Click Here to add More" data-bs-toggle="tooltip"
            data-bs-placement="left" data-bs-dismiss="click"
            data-bs-trigger="hover">
            <span id="kt_engage_demos_label">
                {!! plusSvg() !!}
                Add New</span>
        </button>
        <button id="kt_new_family1_toggle" style="display: none;"
            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
            title="Click Here to add More" data-bs-toggle="tooltip"
            data-bs-placement="left" data-bs-dismiss="click"
            data-bs-trigger="hover">
            
        </button>
        <!--begin::Help drawer-->
        <div id="kt_help" class="bg-body" data-kt-drawer="true"
            data-kt-drawer-name="help" data-kt-drawer-activate="true"
            data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'350px', 'md': '725px'}"
            data-kt-drawer-direction="end"
            data-kt-drawer-toggle="#kt_new_family1_toggle"
            data-kt-drawer-close="#kt_help_close"  style="z-index: 2222;">
            @include('pages.staff.registration.medical_remarks.medical_form')
        </div>
        <!--end::Help drawer-->
    </div>
 
    <div class="card-body py-3" id="medical_remarks_list">
        @include('pages.staff.registration.medical_remarks.list')
    </div>
</div>