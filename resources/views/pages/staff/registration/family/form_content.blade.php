@csrf
<div class="row">

    <div class="col-lg-6 mb-5">

        <label class="form-label required">Relationship Type</label>
        <div class="d-flex">

            <select name="staff_relationship_id" autofocus id="staff_relationship_id"
                class="form-input" required>
                <option value="">--Select Type --</option>
                @isset($relation_types)
                    @foreach ($relation_types as $item)
                        <option value="{{ $item->id }}" @if (isset($family_details->relation_type_id) && $family_details->relation_type_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('relationship','add_edit') )
            <button type="button" class="btn-primary text-white" onclick="return openAddModel('relationship')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
    </div>

    <div class="col-lg-6 mb-5">
        <label class="form-label required">Name</label>
        <input name="family_member_name" id="family_member_name" value="{{ $family_details->first_name ?? '' }}" class="form-control form-control-lg form-control-solid" />
    </div>

    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2">Date of Birth</label>
        
        <div class="d-flex d-flex align-items-center">
            {!! dobSVG() !!}
            <input class="form-control form-control-solid ps-12" placeholder="Select a date" type="date" name="dob" id="dob" value="{{ $family_details->dob ?? '' }}" />
        </div>
    </div>
  
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Gender</label>
        <select name="gender" id="gender" class="form-control" >
            <option value="">--Select--</option>
            <option value="male" @if(isset( $family_details->gender ) && $family_details->gender == 'male') selected @endif>Male</option>
            <option value="female" @if(isset( $family_details->gender ) && $family_details->gender == 'female') selected @endif>Female</option>
            <option value="others" @if(isset( $family_details->gender ) && $family_details->gender == 'others') selected @endif>Others</option>
        </select>
    </div>
    
    <div class="col-lg-6 mb-5">
        
        <label class="form-label required">Age</label>
        <input name="age" id="age" value="{{ $family_details->age ?? '' }}" class="number_only form-control form-control-lg form-control-solid" />
        
    </div>
   
    <div class="col-lg-6 mb-5">
        <!--begin::Label-->
        <label class="form-label required">Qualification</label>
        <div class="d-flex">

            <select name="qualification_id" autofocus id="qualification_id"
                class="form-input" required>
                <option value="">--Select Qualification --</option>
                @isset($qualificaiton)
                    @foreach ($qualificaiton as $item)
                        <option value="{{ $item->id }}" @if (isset($family_details->qualification_id) && $family_details->qualification_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('qualification','add_edit') )
            <button type="button" class="btn-primary text-white" onclick="return openAddModel('qualification')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
        <!--end::Input-->
    </div>
  
    <div class="mb-5 col-lg-6 fv-row">
        <!--begin::Wrapper-->
        <div class="d-inline-block flex-stack">
            <div class="fw-bold me-5">
                <label class="fs-6">Profession Type</label>
            </div>
            
            <div class="d-block mt-5 align-items-center cstm-zeed">
                <!--begin::Checkbox-->
                <label class="form-check form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-20px w-20px" type="radio" name="profession_type"
                        value="profession" @if( isset($family_details->profession) && $family_details->profession == 'profession' ) checked @endif />
                    <span class="form-check-label fw-bold">Profession</span>
                </label>
                
                <label class="form-check form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-20px w-20px" type="radio" name="profession_type"
                        value="studying" @if( isset($family_details->profession) && $family_details->profession == 'studying' ) checked @endif  />
                    <span class="form-check-label fw-bold">Studying</span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="mb-5 col-lg-6 fv-row">
        <div class="d-inline-block flex-stack">
            <div class="fw-bold me-5">
                <label class="fs-6">Premises</label>
            </div>
            <div class="d-block mt-5 align-items-center cstm-zeed">
                <label class="form-check form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-20px w-20px" type="radio" name="premises"
                        value="amalarpavam" @if( isset($family_details->premises) && $family_details->premises == 'amalarpavam' ) checked @endif />
                    <span class="form-check-label fw-bold">Amalarpavam</span>
                </label>
                <label class="form-check form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-20px w-20px" type="radio" name="premises" value="others" @if( isset($family_details->premises) && $family_details->premises == 'others' ) checked @endif />
                    <span class="form-check-label fw-bold">Others</span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Contact No</label>
        <input name="family_contact_no" id="family_contact_no" maxlength="10" value="{{ $family_details->contact_no ?? '' }}" class="number_only form-control form-control-lg form-control-solid" />
    </div>
    <input type="hidden" name="family_id" id="family_id" value="{{ $family_details->id ?? '' }}">
    <div class="col-lg-6 mb-5">
        <!--begin::Label-->
        <label class="form-label required">Blood Group</label>
        <div class="d-flex">
            <select name="blood_group_id" autofocus id="blood_group_id"
                class="form-input" required>
                <option value="">--Select Blood Group --</option>
                @isset($blood_groups)
                    @foreach ($blood_groups as $item)
                        <option value="{{ $item->id }}" @if (isset($family_details->blood_group_id) && $family_details->blood_group_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('blood_group','add_edit') )
            <button type="button" class="btn-primary text-white" onclick="return openAddModel('blood_group')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
        <!--end::Input-->
    </div>
   
    <div class="col-lg-6 mb-5">
        <!--begin::Label-->
        <label class="form-label required">Nationality</label>
        <div class="d-flex">
            <select name="family_nationality" autofocus id="family_nationality"
                class="form-input" required>
                <option value="">--Select Nationality --</option>
                @isset($nationalities)
                    @foreach ($nationalities as $item)
                        <option value="{{ $item->id }}" @if (isset($family_details->nationality_id) && $family_details->nationality_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('nationality','add_edit') )
            <button type="button" class="btn-primary text-white" onclick="return openAddModel('family_nationality')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
        <!--end::Input-->
    </div>
   
    <div class="col-lg-6 mb-5">
        <!--begin::Label-->
        <label class="form-label">Remarks</label>
        <input name="family_remarks" id="family_remarks" value="{{ $family_details->remarks ?? '' }}"  class="form-control form-control-lg form-control-solid" />
        <!--end::Input-->
    </div>
    
    <div class="col-lg-6 mb-5 own_premises" @if( isset($family_details->premises) && $family_details->premises == 'others' ) style="display:none" @endif >
        <!--begin::Label-->
        <label class="form-label">
            If Son/Daughter Regn No
        </label>
        <input name="relation_register_no" id="relation_register_no" value="{{ $family_details->registration_no ?? '' }}" class="form-control form-control-lg form-control-solid" />
        <!--end::Input-->
    </div>
{{--    
    <div class="col-lg-6 mb-5 own_premises"  @if( isset($family_details->premises) && $family_details->premises == 'others' ) style="display:none" @endif>
        <!--begin::Label-->
        <label class="form-label">If Son/Daughter Std</label>
        <input name="relation_standard" id="relation_standard" value="{{ $family_details->standard ?? '' }}"  class="form-control form-control-lg form-control-solid" />
        <!--end::Input-->
    </div> --}}
    <!--end::Input group-->
    <div class="col-lg-12 mb-5">
        <!--end::Label-->
        <label class="form-label">Residential Address</label>
        <textarea name="family_residential_address" id="family_residential_address" class="form-control form-control-lg form-control-solid" rows="3">{{ $family_details->residential_address ?? '' }}</textarea>
        <!--end::Input-->
    </div>

    <div class="col-lg-12 mb-5">
        <!--end::Label-->
        <label class="form-label">
            Occupational address/School address
        </label>
        <textarea name="occupation_address" id="occupation_address" class="form-control form-control-lg form-control-solid" rows="3">{{ $family_details->occupational_address ?? '' }}</textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <div class="d-flex flex-stack pt-5">
        <!--begin::Wrapper-->
        <div>
            <button type="button" class="btn btn-primary"
                onclick="return submitFamilyMemberForm()">
                <span class="indicator-label">Add
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
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
        
        $("#dob").datepicker({
            dateFormat: 'd-mm-yy'
        });

    });

    
    let premises = document.getElementsByName("premises");
    premises.forEach(element => {
        
        element.addEventListener('click',  function() {
            
            if( this.value == 'others') {
                $('.own_premises').hide();
            } else {
                $('.own_premises').show();
            }
        })
    });
    
</script>