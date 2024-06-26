@csrf
<div class="fv-row row" >
    {{-- <div id="invigilation_form_content" class="row">
        <!--begin::Input group-->
       @include('pages.staff.registration.emp_position.invigilation_form_content')
    </div> --}}
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Class</label>
        <input type="hidden" name="duty_id" id="duty_id" value="{{ $duty_info->id ?? '' }}">
        <div class="d-flex">
            <select name="duty_classes" autofocus id="duty_classes"
                class="form-input" required>
                <option value="">--Select Class--</option>
                @isset($duty_classes)
                    @foreach ($duty_classes as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->class_id) && $duty_info->class_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('duty-class','add_edit') )
            <button type="button" class="btn-dark text-white"
                onclick="return openAddModel('duty_class')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Type of Duty</label>
        <div class="d-flex">
            <select name="duty_type" autofocus id="duty_type"
                class="form-input" required>
                <option value="">--Select Duty type --</option>
                @isset($duty_types)
                    @foreach ($duty_types as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->type_of_duty_id) && $duty_info->type_of_duty_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('duty-type','add_edit') )

            <button type="button" class="btn-dark text-white"
                onclick="return openAddModel('duty_type')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
    </div>
    
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Name Of School</label>
        <div class="d-flex">
            <select name="duty_other_school" autofocus id="other_school"
                class="form-input" required>
                <option value="">--Select School --</option>
                @isset($other_schools)
                    @foreach ($other_schools as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->school_id) && $duty_info->school_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @if( access()->buttonAccess('other-school','add_edit') )
            <button type="button" class="btn-dark text-white"
                onclick="return openAddModel('other_school')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
    </div>
    
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Place</label>
        <div class="d-flex">
            <select name="duty_other_place_id" autofocus id="duty_other_place_id"
                class="form-input" required>
                <option value="">--Select Place --</option>
                @isset($places)
                    @foreach ($places as $item)
                        <option value="{{ $item->id }}" @if (isset($duty_info->school_place_id) && $duty_info->school_place_id == $item->id) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endisset
            </select>            
            @if( access()->buttonAccess('place','add_edit') )
            <button type="button" class="btn-dark text-white"
                onclick="return openAddModel('other_places')">
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2">From</label>
        <!--begin::Input-->
        <div class="d-flex d-flex align-items-center">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.3"
                        d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                        fill="currentColor" />
                    <path
                        d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                        fill="currentColor" />
                    <path
                        d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
            <!--end::Icon-->
            <!--begin::Datepicker-->
            <input class="form-input ps-12" placeholder="Select a date"
                name="inv_from_date" required id="inv_from_date" type="date" value="{{ $duty_info->from_date ?? '' }}" />
            <!--end::Datepicker-->
        </div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="col-lg-6 mb-5">
        <label class="required fs-6 fw-bold mb-2">To</label>
        <!--begin::Input-->
        <div class="d-flex d-flex align-items-center">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3"
                        d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                        fill="currentColor" />
                    <path
                        d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                        fill="currentColor" />
                    <path
                        d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                        fill="currentColor" />
                </svg>
            </span>
         
            <input class="form-input ps-12" placeholder="Select a date"
                name="inv_to_date" type="date" required id="inv_to_date" value="{{ $duty_info->to_date ?? '' }}" />
        </div>
        <!--end::Input-->
    </div>
    
    <div class="col-lg-12 mb-5">
        
        <label class="form-label required">Facility </label>
        <input name="facility" id="duty_facility" value="{{ $duty_info->facility ?? '' }}" class="form-control form-control-lg form-control-solid" />
    
    </div>

    <!--end::Input group-->
    <div class="d-flex flex-stack pt-5">
        <!--begin::Wrapper-->
        <div>
            <button type="button"  onClick="return submitInvigilationForm()"  class="btn btn-primary">
                <span class="indicator-label" > 
                    Submit
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