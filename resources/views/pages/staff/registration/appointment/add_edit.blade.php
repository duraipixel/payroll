<div class="modal-dialog modal-dialog-centered mw-900px">
    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                {!! cancelSvg() !!}
            </div>
        </div>
        <div class="modal-body py-lg-10 px-lg-10" id="dynamic_content">
            <form id="staff_appointment_order_update">
                @csrf
                <div class="w-100">
                    <div class="card card-flush py-0">
                        <div class="pt-0">
                            <div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
                                <div class="row">
                                    <div class="col-lg-4 mb-5">
                                        <label class="form-label required"> Academic Year </label>
                                        <div class="d-flex">
                                            <select name="academic_id" autofocus id="academic_id_update"
                                                class="form-control select2-option"
                                                @if (!empty($details)) disabled @endif>
                                                <option value="">-- Select Year --</option>
                                                @if(getGlobalAcademicYear())
                                                    @foreach (getGlobalAcademicYear() as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (isset($details->academic_id) && $details->academic_id == $item->id) selected @endif>
                                                            {{ $item->from_year . ' - ' . $item->to_year }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" id="order_id" value="{{ $details->id ?? '' }}">
                                    <div class="col-lg-4 mb-5">
                                        <label class="form-label required"> Category of Staff </label>
                                        <div class="d-flex">
                                            <select name="staff_category_id" autofocus id="staff_category_id_update"
                                                class="form-control select2-option" required>
                                                <option value="">-- Select Category --</option>
                                                @isset($staff_category)
                                                    @foreach ($staff_category as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (isset($details->category_id) && $details->category_id == $item->id) selected @endif>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            {{-- @if (access()->buttonAccess('staff-category', 'add_edit'))
                                                <button type="button" class="btn-dark text-white"
                                                    onclick="return openAddModel('staff_category')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            @endif --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-5">

                                        <label class="form-label required">Nature of Employment</label>

                                        <div class="d-flex">
                                            <select name="nature_of_employment_id" autofocus
                                                id="nature_of_employment_id_update" class="form-control select2-option"
                                                required>
                                                <option value="">-- Select Nature --</option>
                                                @isset($employments)
                                                    @foreach ($employments as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (isset($details->nature_of_employment_id) && $details->nature_of_employment_id == $item->id) selected @endif>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            {{-- @if (access()->buttonAccess('nature-of-employeement', 'add_edit'))
                                                <button type="button" class="btn-dark text-white"
                                                    onclick="return openAddModel('nature_of_employeement')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            @endif --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-5">

                                        <label class="form-label required">Designation</label>

                                        <div class="d-flex">
                                            <select name="designation_id"
                                                id="designation_id_update" class="form-control select2-option"
                                                required>
                                                <option value="">-- Select Designation --</option>
                                                @isset($designation)
                                                    @foreach ($designation as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (isset($details->designation_id) && $details->designation_id == $item->id) selected @endif>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-5">
                                        <label class="form-label required"> Teaching Type </label>

                                        <div class="d-flex">
                                            <select name="teaching_type_id" autofocus id="teaching_type_id_update"
                                                class="form-control select2-option" required>
                                                <option value="">-- Select Teaching Type --</option>
                                                @isset($teaching_types)
                                                    @foreach ($teaching_types as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (isset($details->teaching_type_id) && $details->teaching_type_id == $item->id) selected @endif>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            {{-- @if (access()->buttonAccess('teaching-type', 'add_edit'))
                                                <button type="button" class="btn-dark text-white"
                                                    onclick="return openAddModel('teaching_type')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            @endif --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-5">
                                        <label class="form-label required"> Place of Work </label>

                                        <div class="d-flex">
                                            <select name="place_of_work_id" autofocus id="place_of_work_id_update"
                                                class="form-control select2-option" required>
                                                <option value=""> -- Select Place Of Work -- </option>
                                                @isset($place_of_works)
                                                    @foreach ($place_of_works as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (isset($details->place_of_work_id) && $details->place_of_work_id == $item->id) selected @endif>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            {{-- @if (access()->buttonAccess('workplace', 'add_edit'))
                                                <button type="button" class="btn-dark text-white"
                                                    onclick="return openAddModel('place_of_work')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            @endif --}}
                                        </div>
                                    </div>

                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="required fs-6 fw-bold mb-2"> Date of Joining </label>
                                        <div class="position-relative d-flex align-items-center">

                                            <input class="form-control" placeholder="Select a date" name="joining_date"
                                                id="joining_date_update" type="date"
                                                value="{{ $details->joining_date ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-5">
                                        <label class="form-label required">Salary Scale

                                        </label>
                                        <input name="salary_scale" id="salary_scale_update"
                                            value="{{ $details->salary_scale ?? '' }}" class="form-control" />
                                        <small class="text-muted fs-9">( for appointment order purpose and not for
                                            salary
                                            calculation )</small>
                                    </div>
                                    <div class="mb-5 col-lg-4 fv-row">
                                        <div class="d-inline-block flex-stack">

                                            <div class="fw-bold me-5">
                                                <label class="fs-6">probation</label>
                                            </div>
                                            <div class="d-block mt-5 align-items-center cstm-zeed">
                                                <label class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-20px w-20px" type="radio"
                                                        name="probation_update" value="yes"
                                                        @if (isset($details->has_probation) && $details->has_probation == 'yes') checked @endif />
                                                    <span class="form-check-label fw-bold">Yes </span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-20px w-20px" type="radio"
                                                        name="probation_update" value="no"
                                                        @if ((isset($details->has_probation) && $details->has_probation == 'no') || !isset($details->has_probation)) checked @endif />
                                                    <span class="form-check-label fw-bold">No</span>
                                                </label>
                                            </div>

                                        </div>
                                        <div id="probation_pane_update" class="mt-5"
                                            @if (isset($details->has_probation) && $details->has_probation == 'yes') @else style="display:none" @endif>
                                            <input type="text" name="probation_period" placeholder="Probation Period"
                                                value="{{ $details->probation_period ?? '' }}" id="probation_period"
                                                class="form-control">
                                                
                                               
                                        </div>
                                    </div>
<div class="col-md-4 fv-row">
     <div id="probation_pane_update1"
                                            @if (isset($details->has_probation) && $details->has_probation == 'yes') @else style="display:none" @endif>
<label class="fs-6">Probation Order Number</label>
 <input type="text" name="probation_order_no" placeholder="Probation Order No" value="{{ $details->probation_order_no ?? '' }}" id="probation_order_no" class="form-control">
</div>
</div>
<div class="col-md-8 fv-row mb-5">
</div>
                                    <div class="mb-5 col-lg-4 fv-row">
                                        <div class="d-inline-block flex-stack">
                                            <div class="fw-bold me-5">
                                                <label class="fs-6">Till Active</label>
                                            </div>
                                            <div class="d-block mt-5 align-items-center cstm-zeed">
                                                <label class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-20px w-20px" type="radio"
                                                        name="is_till_active" value="yes"
                                                        @if (isset($details->is_till_active) && $details->is_till_active == 'yes') checked @endif />
                                                    <span class="form-check-label fw-bold">Yes </span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-20px w-20px" type="radio"
                                                        name="is_till_active" value="no"
                                                        @if ((isset($details->is_till_active) && $details->is_till_active == 'no') || !isset($details->is_till_active)) checked @endif />
                                                    <span class="form-check-label fw-bold">No</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="" class="text-danger small mt-2"> If Till Active select Yes, then this appointment will continue for until create new order</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row my-3">

                                        <div class="col-lg-6 mb-5">
                                            <label class="form-label required">Period of Appointment
                                                (From)</label>
                                            <div class="position-relative d-flex align-items-center">

                                                <input class="form-control  ps-12" placeholder="Select a date"
                                                    name="from_appointment" id="from_appointment_update"
                                                    type="date" value="{{ $details->from_appointment ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-5">
                                            <label class="form-label required">Period of Appointment
                                                (To)</label>

                                            <div class="position-relative d-flex align-items-center">

                                                <input class="form-control ps-12" placeholder="Select a date"
                                                    name="to_appointment" id="to_appointment_update" type="date"
                                                    value="{{ $details->to_appointment ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-5">
                                            <label class="form-label required">
                                                Appointment order model
                                            </label>
                                            {{-- <a href="javascript:void(0)" class="float-end" onclick="return selectAppointmentModel()"> Select Model </a> --}}
                                            <div class="position-relative">
                                                <select name="appointment_order_model_id" autofocus
                                                    id="appointment_order_model_id_update" class="form-control "
                                                    required>
                                                    <option value=""> -- Select Order Model --
                                                    </option>
                                                    @isset($order_models)
                                                        @foreach ($order_models as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if (isset($details->appointment_order_model_id) && $details->appointment_order_model_id == $item->id) selected @endif>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                {{-- <button type="button"  class="btn-dark text-white"
                                                                onclick="return openAddModel('order_model')">
                                                                <i class="fa fa-plus"></i>
                                                            </button> --}}
                                            </div>
                                        </div>

                                        <br>

                                        <div class="col-lg-6 mb-5">
                                            <label class="form-label">Previous Appointment Number</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input class="form-control  ps-12" placeholder="Previous Appointment Number"
                                                    name="previous_appointment_number" id="previous_appointment_number"
                                                    type="text" value="{{ $details->previous_appointment_number ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-5">
                                            <label class="form-label">Previous Appointment Date</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input class="form-control ps-12" placeholder="Select a date"
                                                    name="previous_appointment_date" id="previous_appointment_date" type="date"
                                                    value="{{ $details->previous_appointment_date ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-5">
                                            <label class="form-label">
                                                Previous Designation
                                            </label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input class="form-control  ps-12" placeholder="Previous Designation"
                                                    name="previous_designation" id="previous_designation"
                                                    type="text" value="{{ $details->previous_designation ?? '' }}" />
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <button type="button" class="btn btn-success mt-8" id="generate_order"
                                                onclick="return generateAppointmentModel()"> Generate
                                                Appointment
                                                Order
                                            </button>
                                        </div>

                                        <div class="col-md-6 fv-row">
                                            <label class=" fs-6 fw-bold form-label mb-2">
                                                Upload Appointment
                                                Order
                                            </label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="col-form-label text-lg-right">Upload
                                                        File:</label>
                                                </div>
                                                <div class="col-8">
                                                    <input class="form-control form-control-sm" style=""
                                                        type="file" name="appointment_order_doc">
                                                </div>
                                                @isset($details->appointment_doc)
                                                    <div class="col-12">
                                                        <div class="d-flex justiy-content-around flex-wrap">
                                                            @php
                                                                $url = Storage::url($details->appointment_doc);
                                                            @endphp
                                                            <div class="d-inline-block p-2 bg-light m-1">
                                                                <a class="btn-sm btn-success"
                                                                    href="{{ asset('public' . $url) }}"
                                                                    target="_blank">View
                                                                    File </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endisset
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-end">
                                        <button type="button" class="btn btn-light-dark mx-2"
                                            data-bs-dismiss="modal"> cancel </button>
                                        <button type="button" class="btn btn-primary"
                                            id="validate_appointment_button"
                                            onclick="return dovalidateAppointmentForm()"> Save </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<script>
    $('input[name=probation_update]').change(function() {

        if ($(this).val() == 'yes') {
            $('#probation_pane_update').show();
            $('#probation_pane_update1').show();
            
        } else {
            $('#probation_pane_update').hide();
            $('#probation_pane_update1').hide();
        }

    })
</script>
