@csrf
<div class="row">
    <div class="col-lg-6 mb-5">

        <label class="form-label required"> Institution Name </label>
        <div class="position-relative">
            <select name="experience_institute_name" autofocus id="experience_institute_name"
                class="form-select form-select-lg select2-option" required>
                <option value="">--Select Institute --</option>
                @isset($other_schools)
                    @foreach ($other_schools as $item)
                        <option value="{{ $item->id }}" @if (isset($experience_info->institue_id) && $experience_info->institue_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <span class="position-absolute btn btn-success btn-md top-0 end-0"
                onclick="return openAddModel('experience_institute_name')">
                <i class="fa fa-plus"></i>
            </span>
        </div>

    </div>
    <input type="hidden" name="experience_id" id="experience_id" value="{{ $experience_info->id ?? '' }}">
    <div class="col-lg-6 mb-5">
        <label class="form-label required"> Designation </label>
        <div class="position-relative">
            <select name="experience_designation" autofocus id="experience_designation"
                class="form-select form-select-lg select2-option" required>
                <option value="">--Select Designation --</option>
                @isset($designation)
                    @foreach ($designation as $item)
                        <option value="{{ $item->id }}" @if (isset($experience_info->designation_id) && $experience_info->designation_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <span class="position-absolute btn btn-success btn-md top-0 end-0"
                onclick="return openAddModel('experience_designation')">
                <i class="fa fa-plus"></i>
            </span>
        </div>
    </div>

    <div class="col-lg-6 mb-5">
        <label class="form-label required">Period (From)</label>
        <div class="position-relative d-flex align-items-center">
            {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                name="experience_from" required id="experience_from" value="{{ isset($experience_info->from) && !empty( $experience_info->from ) ? date('d-m-Y', strtotime($experience_info->from)) : ''  }}" />
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Period (To)</label>
        <div class="position-relative d-flex align-items-center">
            {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                name="experience_to" required id="experience_to" value="{{ isset($experience_info->to) && !empty( $experience_info->to ) ? date('d-m-Y', strtotime($experience_info->to)) : ''  }}" />
        </div>
    </div>

    <div class="col-lg-6 mb-5">
        <label class="form-label required">Institution Address</label>
        <input name="experince_institute_address" id="experince_institute_address" value="{{ $experience_info->address ?? '' }}" class="form-control form-control-lg form-control-solid" />
    </div>

    <div class="col-lg-6 mb-5">
        <label class="form-label required"> Salary drawn</label>
        <input name="salary_drawn" id="salary_drawn" value="{{ $experience_info->salary_drawn ?? '' }}" class="form-control form-control-lg form-control-solid" />
    </div>

    <div class="col-lg-6 mb-5">
        <label class="form-label required"> Years of Experience </label>
        <input name="experience_year" id="experience_year" type="number" value="{{ $experience_info->experience_year ?? '' }}" min="0" class="form-control form-control-lg form-control-solid" />
    </div>

    <div class="col-lg-6 mb-5">
        <label class="form-label">Remarks</label>
        <input name="experience_remarks" id="experience_remarks" value="{{ $experience_info->remarks ?? '' }}" class="form-control form-control-lg form-control-solid" />
    </div>

    <div class="col-lg-6 mb-5">
        <div class="row">
            <div class="col-4">
                <label class="col-form-label text-lg-right">
                    Upload File:
                </label>
            </div>
            <div class="col-8">
                <input class="form-control" style="" type="file" name="experince_file"
                    multiple="">
            </div>
            @isset($staff_details->passport->multi_file)
                @php
                    
                @endphp

                @isset($paths)
                    <div class="col-12">
                        <div class="d-flex justiy-content-around flex-wrap">
                          
                            @php
                                $url = Storage::url($paths);
                            @endphp
                            <div class="d-inline-block p-2 bg-light m-1">
                                <a class="btn-sm btn-outline-info" href="{{ asset($url) }}"
                                    target="_blank">View File </a>
                            </div>
                        </div>
                    </div>
                @endisset
            @endisset
        </div>
    </div>

    <div class="d-flex flex-stack pt-5">
        <div>
            <button type="button" onclick="return submitExperienceForm()" class="btn btn-lg btn-primary me-3 d-inline-block" >
                <span class="indicator-label">Add
                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                </span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
</div>

<script>
    $(function() {
        
        $("#experience_from").datepicker({
            dateFormat: 'd-mm-yy'
        });

        $("#experience_to").datepicker({
            dateFormat: 'd-mm-yy'
        });

    });
</script>
