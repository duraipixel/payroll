@csrf
<div class="row">
    
    <div class="col-lg-12 mb-5">
        
        <label class="form-label required">
            Working Relation
        </label>
        {{-- <input name="working_relation_id" id="working_relation_id" class="form-control form-control-lg form-control-solid" /> --}}
        <select name="working_relation_id" id="working_relation_id" onchange="return getStaffWorkingDetails(this.value)" class="form-control ">
            <option value=""> Select Staff </option>
            @isset($other_staff)
                @foreach ($other_staff as $item)
                    <option value="{{ $item->id }}" @if(isset($working_info->belonger_id) && $working_info->belonger_id == $item->id ) selected @endif>{{ $item->name }}</option>
                @endforeach
            @endisset
        </select>
        
    </div>
    <input type="hidden" name="relation_working_id" id="relation_working_id" value="{{ $working_info->id ?? '' }}">
    <div class="col-lg-12 mb-5">
       
        <label class="form-label required">
            Relationship Type
        </label>
        <div class="position-relative">
            <select name="working_relationship_type_id" autofocus id="working_relationship_type_id"
                class="form-select form-select-lg" required>
                <option value="">--Select Reletionship Type --</option>
                @isset($relation_types)
                    @foreach ($relation_types as $item)
                        <option value="{{ $item->id }}" @if (isset($working_info->relationship_type_id) && $working_info->relationship_type_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('relationship','add_edit') )

            <span class="position-absolute btn btn-success btn-md top-0 end-0" onclick="return openAddModel('relationship_working_type')">
                <i class="fa fa-plus"></i>
            </span>
            @endif
        </div>
      
    </div>
    
    <div class="col-lg-12 mb-5">
       
        <label class="form-label required">Emp Code</label>
        <input name="working_emp_code" id="working_emp_code" value="{{ $working_info->belonger_code ?? '' }}" readonly class="form-control form-control-lg form-control-solid" />
      
    </div>
    
    <div class="col-lg-12 mb-5">
       
        <label class="form-label required">Institution</label>
        <input name="working_institute_id" id="working_institute_id" value="{{ $working_info->belonger->institute->name ?? '' }}" readonly class="form-control form-control-lg form-control-solid" />
      
    </div>
   
    <!--end::Input group-->
    <div class="d-flex flex-stack pt-5">
        <!--begin::Wrapper-->
        <div>
            <button type="button" class="btn btn-primary" onclick="return submitRelationWorkingDetails()" >
                <span class="indicator-label"> Submit
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
        <!--end::Wrapper-->
    </div>
</div>
<script>
    var globalOtherStaff = @json($other_staff);
    
    function getStaffWorkingDetails(staff_id) {

        let resl = globalOtherStaff.find( p => p.id == staff_id);
        
        if( resl ) {
            $('#working_institute_id').val(resl.institute.name);
            $('#working_emp_code').val(resl.emp_code);
        } else {
            $('#working_institute_id').val('');
            $('#working_emp_code').val('');
        }

    }
</script>