<div class="tble-fnton card mt-10 mb-5 mb-xl-8">
    <div class="card-header bg-primary border-0 pt-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-5 mb-1 text-white">Nominee required</span>
        </h3>

        <button onclick="return openNomineeForm()"
            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-dismiss="click" data-bs-trigger="hover">
            <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16"
                            height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                            fill="currentColor"></rect>
                        <rect x="4.36396" y="11.364" width="16" height="2"
                            rx="1" fill="currentColor"></rect>
                    </svg>
                </span> Add New </span>
        </button>
        <button id="kt_new_nominiee_toggle" style="display: none"
            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-dismiss="click" data-bs-trigger="hover">
        </button>

    </div>
    <div class="card-body py-3" id="nominee-list-pane">
        @include('pages.staff.registration.nominee.nominee_list')
    </div>
</div>