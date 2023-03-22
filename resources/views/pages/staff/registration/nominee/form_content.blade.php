@csrf
<div class="row">
    
    <div class="col-lg-6 mb-5">
        
        <label class="form-label required">Nominee Name</label>
        <input name="business_name" class="form-control form-control-lg form-control-solid" />
        
    </div>
   
    <div class="col-lg-6 mb-5">
        
        <label class="form-label required"> Relationship Type</label>
        
        <input name="business_name" class="form-control form-control-lg form-control-solid" />
        
    </div>
   
    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2">
            Date of Birth</label>
        
        <div class="position-relative d-flex align-items-center">
            {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12"
                placeholder="Select a date" name="due_date" />
        </div>
        
    </div>
   
    <div class="col-lg-6 mb-5">
        
        <label class="form-label required">Gender</label>
        <select name="business_type"
            class="form-select form-select-lg form-select-solid"
            data-control="select2" data-placeholder="Select Gender"
            data-allow-clear="true" data-hide-search="true">
            <option></option>
            <option value="1">Male</option>
            <option value="1">Female</option>
            <option value="1">Others</option>
        </select>
        
    </div>
   
    <div class="col-lg-6 mb-5">
        
        <label class="form-label required">Age</label>
        
        <input name="business_name"
            class="form-control form-control-lg form-control-solid"
            maxlength="2" />
        
    </div>
   
    <div class="col-lg-6 mb-5">
        
        <label class="form-label">Name If Nominee is Minor
        </label>
        
        <input name="business_name"
            class="form-control form-control-lg form-control-solid" />
        
    </div>
   
    <div class="col-lg-6 mb-5">
        
        <label class="form-label">Share %</label>
        
        <input name="business_name"
            class="form-control form-control-lg form-control-solid" />
        
    </div>
   
    <div class="col-lg-12 mb-5">
        <!--end::Label-->
        <label class="form-label">Address & Contact Number If
            Nominee is Minor </label>
        
        <textarea name="business_description" class="form-control form-control-lg form-control-solid" rows="3"></textarea>
        
    </div>
    <!--end::Input group-->
    <div class="d-flex flex-stack pt-5">
        <!--begin::Wrapper-->
        <div>
            <button type="button"
                class="btn btn-lg btn-primary me-3 d-inline-block"
                data-kt-stepper-action="submit">
                <span class="indicator-label">Add
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="18"
                                y="13" width="13" height="2"
                                rx="1" transform="rotate(-180 18 13)"
                                fill="currentColor"></rect>
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="indicator-progress">Please
                    wait...
                    <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
</div>