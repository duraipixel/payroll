<div class="card shadow-none rounded-0 w-100">
    <div class="card-header" id="kt_help_header">
        <h5 class="card-title fw-bold text-gray-600" id="medical_remarks_title">
            Add Your Medical Details</h5>
        <div class="card-toolbar">
            <button type="button"
                class="btn btn-sm btn-icon explore-btn-dismiss me-n5"
                id="kt_help_close">
                    {!! plusSvg() !!}
            </button>
        </div>
    </div>
    
    <div class="card-body p-5" id="kt_help_body">
        <form id="medical_remarks_form">
            @include('pages.staff.registration.medical_remarks.form_content')
        </form>
    </div>
    
</div>
