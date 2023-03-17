<div class="row">
    
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
       
        <label class="required fs-6 fw-bold mb-2">Course Started</label>
        <!--begin::Input-->
        <div class="position-relative d-flex align-items-center">
         
           {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                name="course_started_year" required id="course_started_year" value="{{ isset($duty_info->from_date) && !empty( $duty_info->from_date ) ? date('d-m-Y', strtotime($duty_info->from_date)) : ''  }}" />
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
       
        <label class="form-label required"> Board/University </label>
        <div class="position-relative">
            <select name="board_id" autofocus id="board_id"
                class="form-select form-select-lg select2-option" required>
                <option value="">--Select Board --</option>
                @isset($boards)
                    @foreach ($boards as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->school_place_id) && $duty_info->school_place_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <span class="position-absolute btn btn-success btn-md top-0 end-0"
                onclick="return openAddModel('boards')">
                <i class="fa fa-plus"></i>
            </span>
        </div>

    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2">Course Completed</label>
        <!--begin::Input-->
        <div class="position-relative d-flex align-items-center">
         
           {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                name="course_completed_year" required id="course_completed_year" value="{{ isset($duty_info->from_date) && !empty( $duty_info->from_date ) ? date('d-m-Y', strtotime($duty_info->from_date)) : ''  }}" />
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <label class="form-label required"> Main Subject </label>
        <div class="position-relative">
            <select name="main_subject_id" autofocus id="main_subject_id"
                class="form-select form-select-lg select2-option" required>
                <option value="">--Select Main Subject --</option>
                @isset($subjects)
                    @foreach ($subjects as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->school_place_id) && $duty_info->school_place_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <span class="position-absolute btn btn-success btn-md top-0 end-0"
                onclick="return openAddModel('main_subject')">
                <i class="fa fa-plus"></i>
            </span>
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        
        <label class="form-label required"> Ancillary Subject </label>
        <div class="position-relative">
            <select name="ancillary_subject_id" autofocus id="ancillary_subject_id"
                class="form-select form-select-lg select2-option" required>
                <option value="">--Select Ancillary Subject --</option>
                @isset($subjects)
                    @foreach ($subjects as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->school_place_id) && $duty_info->school_place_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <span class="position-absolute btn btn-success btn-md top-0 end-0"
                onclick="return openAddModel('ancillary_subject')">
                <i class="fa fa-plus"></i>
            </span>
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <!--begin::Label-->
        <label class="form-label required">Certificate No</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input name="course_certificate_no" id="course_certificate_no" class="form-control form-control-lg form-control-solid" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2">Submitted Date</label>
        <div class="position-relative d-flex align-items-center">
           {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                name="course_submitted_date" required id="course_submitted_date" value="{{ isset($duty_info->from_date) && !empty( $duty_info->from_date ) ? date('d-m-Y', strtotime($duty_info->from_date)) : ''  }}" />
        </div>
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">

        <label class="form-label required"> Type </label>
        <div class="position-relative">
            <select name="course_professional_type" autofocus id="course_professional_type"
                class="form-select form-select-lg select2-option" required>
                <option value="">--Select Type --</option>
                @isset($types)
                    @foreach ($types as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->school_place_id) && $duty_info->school_place_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <span class="position-absolute btn btn-success btn-md top-0 end-0"
                onclick="return openAddModel('professional_type')">
                <i class="fa fa-plus"></i>
            </span>
        </div>
        
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <div class="form-group row">
            <label class="col-lg-12 col-form-label text-lg-right">Upload
                File:</label>
            <div class="col-lg-12">
                <div class="uppy" id="kt_uppy_5">
                    <div class="uppy-wrapper">
                        <div class="uppy-Root uppy-FileInput-container">
                            <input class="uppy-FileInput-input uppy-input-control" style=""
                                type="file" name="course_file"
                                id="course_file">
                                <label
                                class="uppy-input-label btn btn-light-primary btn-sm btn-bold"
                                for="course_file">Attach
                                files</label>
                        </div><span class="form-text text-dark">Maximum file size
                            1MB</span>
                    </div>
                    <div class="uppy-list"></div>
                    <div class="uppy-status">
                        <div class="uppy-Root uppy-StatusBar is-waiting" aria-hidden="true"
                            dir="ltr">
                            <div class="uppy-StatusBar-progress" style="width: 0%;" role="progressbar"
                                aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>
                            <div class="uppy-StatusBar-actions"></div>
                        </div>
                    </div>
                    <div class="uppy-informer uppy-informer-min">
                        <div class="uppy uppy-Informer" aria-hidden="true">
                            <p role="alert"> </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end::Input group-->
    <div class="d-flex flex-stack pt-5">
        <!--begin::Wrapper-->
        <div>
            <button onclick="return submitCourseForm()" type="button" class="btn btn-lg btn-primary me-3 d-inline-block"
                >
                <span class="indicator-label">Add
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="18" y="13" width="13"
                                height="2" rx="1" transform="rotate(-180 18 13)"
                                fill="currentColor"></rect>
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <!--end::Wrapper-->
    </div>
</div>

<script>
    $(function() {
        
        $("#course_started_year").datepicker({
            dateFormat: 'd-mm-yy'
        });

        $("#course_completed_year").datepicker({
            dateFormat: 'd-mm-yy'
        });

        $("#course_submitted_date").datepicker({
            dateFormat: 'd-mm-yy'
        });

    });
</script>