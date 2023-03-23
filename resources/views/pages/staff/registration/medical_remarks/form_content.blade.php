@csrf
<div class="row">

    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2"> Date </label>
        <div class="position-relative d-flex align-items-center">
            {!! dobSvg() !!}
            <input class="form-control ps-12" placeholder="Select a date" name="medic_remark_date" id="medic_remark_date"
                value="{{ isset($remark_info->medic_date) ? date('d-m-Y', strtotime($remark_info->medic_date)) : '' }}" />
        </div>
    </div>

    <div class="col-lg-6 mt-10">
        <div class="row">
            <div class="col-4">
                <label class="col-form-label text-lg-right">
                    Upload File:
                </label>
            </div>
            <div class="col-8 mb-1">
                <input class="form-control form-control-sm" style="" type="file" name="medic_file">
            </div>
            @isset($remark_info->medic_documents)
                <div class="col-12" id="medic_file_pane">
                    <div class="d-flex justiy-content-around flex-wrap">
                        @php
                            $url = Storage::url($remark_info->medic_documents);
                        @endphp

                        <div class="d-inline-block p-2 bg-light m-1">
                            <a class="btn-sm btn-success" href="{{ asset($url) }}" target="_blank">View File </a>
                        </div>
                    </div>
                </div>
            @endisset
        </div>

    </div>
    <input type="hidden" name="medical_remark_id" id="medical_remark_id" value="{{ $remark_info->id ?? '' }}">
    <div class="col-lg-12 mb-5">
        <label class="form-label required">Reason</label>
        <textarea name="remark_reason" id="remark_reason" class="form-control form-control-lg" rows="3">{{ $remark_info->reason ?? '' }}</textarea>
    </div>

    <div class="d-flex flex-stack pt-5">
        <div>
            <button onclick="return submitMedicalRemarks()" type="button"
                class="btn btn-lg btn-primary me-3 d-inline-block">
                <span class="indicator-label"> Submit
                    {!! arrowSvg() !!}
                </span>
                <span class="indicator-progress">Please
                    wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
</div>

<script>
    $(function() {

        $("#medic_remark_date").datepicker({
            dateFormat: 'd-mm-yy'
        });

    });
</script>
