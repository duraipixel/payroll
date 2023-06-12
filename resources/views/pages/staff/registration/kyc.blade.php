<div data-kt-stepper-element="content">
    <form id="kyc-form">
        @csrf
        <div class="w-100">
            <div class="pb-5 pb-lg-5">
                <h2 class="fw-bolder text-dark">KYC Details</h2>
            </div>
            <input type="hidden" name="id" id="staff_id" value="{{ $staff_details->id ?? '' }}">
            <div class="row">
                <div class="col-md-4 fv-row mb-5">
                    <label class="required fs-6 fw-bold mb-2">Date of Birth</label>
                    <div class="position-relative d-flex align-items-center">
                        
                        <input class="form-control  ps-12" autocomplete="off" placeholder="Select a date"
                            name="date_of_birth" id="date_of_birth" autofocus type="date"
                            value="{{ $staff_details->personal->dob ?? '' }}" />
                    </div>
                </div>
                <div class="mb-5 col-lg-4 fv-row">
                    <div class="d-inline-block flex-stack">
                        <div class="fw-bold me-5">
                            <label class="fs-6 required">Gender</label>
                        </div>
                        <div class="d-block mt-5 align-items-center cstm-zeed">
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input h-20px w-20px" type="radio" name="gender"
                                    value="male" @if (isset($staff_details->personal) && $staff_details->personal->gender == 'male') checked @endif />
                                <span class="form-check-label fw-bold">Male</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input h-20px w-20px" type="radio" name="gender"
                                    value="female" @if (isset($staff_details->personal) && $staff_details->personal->gender == 'female') checked @endif />
                                <span class="form-check-label fw-bold">Female</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input h-20px w-20px" type="radio" name="gender"
                                    value="others" @if (isset($staff_details->personal) && $staff_details->personal->gender == 'others') checked @endif />
                                <span class="form-check-label fw-bold">Others</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Marital Status</label>
                    <select name="marital_status" id="marital_status" autofocus class="form-input">
                        <option value="">Select Status</option>
                        <option value="married" @if (isset($staff_details->personal) && $staff_details->personal->marital_status == 'married') selected @endif>Married</option>
                        <option value="single" @if (isset($staff_details->personal) && $staff_details->personal->marital_status == 'single') selected @endif>Single</option>
                        <option value="divorced" @if (isset($staff_details->personal) && $staff_details->personal->marital_status == 'divorced') selected @endif>Divorced</option>
                    </select>
                </div>
                <div class="col-md-4 fv-row mb-5" id="marriage_data"
                    @if (isset($staff_details->personal) && $staff_details->personal->marital_status == 'married') style="display:block" @else style="display:none;" @endif>
                    <label class="fs-6 fw-bold mb-2 required">Marriage Date</label>
                    <div class="position-relative d-flex align-items-center">
                        
                        <input class="form-control  ps-12" type="date" placeholder="Select a date"
                            name="marriage_date" id="marriage_date"
                            value="{{ $staff_details->personal->marriage_date ?? '' }}" />
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Mother Tongue</label>
                    <div class="d-flex">
                        <select name="language_id" autofocus id="language_id" class="select2-option">
                            <option value="">--Select Language--</option>
                            @isset($mother_tongues)
                                @foreach ($mother_tongues as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->mother_tongue == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if (access()->buttonAccess('language', 'add_edit'))
                            <button type="button" class="text-white btn-primary"
                                onclick="return openAddModel('language')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Place of Birth </label>
                    <div class="d-flex">
                        <select name="place_of_birth_id" autofocus id="place_of_birth_id" class="select2-option">
                            <option value="">--Select Place--</option>
                            @isset($places)
                                @foreach ($places as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->birth_place == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if (access()->buttonAccess('place', 'add_edit'))
                            <button type="button" class="text-white btn-primary"
                                onclick="return openAddModel('places')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Nationality</label>
                    <div class="d-flex">
                        <select name="nationality_id" autofocus id="nationality_id" class="select2-option">
                            <option value="">--Select Nationality--</option>
                            @isset($nationalities)
                                @foreach ($nationalities as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->nationality_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if (access()->buttonAccess('nationality', 'add_edit'))
                            <button type="button" class="text-white btn-primary"
                                onclick="return openAddModel('nationality')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Religion</label>
                    <div class="d-flex">
                        <select name="religion_id" autofocus id="religion_id" class="select2-option">
                            <option value="">--Select Religion--</option>
                            @isset($religions)
                                @foreach ($religions as $item)
                                    <option value="{{ $item->id }}"
                                        @if (isset($staff_details->personal) && $staff_details->personal->religion_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if (access()->buttonAccess('religion', 'add_edit'))
                            <button type="button" class="text-white btn-primary"
                                onclick="return openAddModel('religion')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Caste</label>
                    <div class="d-flex">
                        <select name="caste_id" autofocus id="caste_id" class="select2-option">
                            <option value="">--Select Caste--</option>
                            @isset($castes)
                                @foreach ($castes as $item)
                                    <option value="{{ $item->id }}"
                                        @if (isset($staff_details->personal) && $staff_details->personal->caste_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if (access()->buttonAccess('caste', 'add_edit'))
                            <button type="button" class="text-white btn-primary"
                                onclick="return openAddModel('caste')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Community</label>
                    <div class="d-flex">
                        <select name="community_id" autofocus id="community_id" class="select2-option">
                            <option value="">--Select Community--</option>
                            @isset($communities)
                                @foreach ($communities as $item)
                                    <option value="{{ $item->id }}"
                                        @if (isset($staff_details->personal) && $staff_details->personal->community_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @if (access()->buttonAccess('community', 'add_edit'))
                            <button type="button" class="text-white btn-primary"
                                onclick="return openAddModel('community')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label ">Phone No ( Landline No )</label>
                    <input name="phone_no" autofocus id="phone_no" 
                        class="form-input "
                        value="{{ $staff_details->personal->phone_no ?? '' }}" />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Mobile No - 1</label>
                    <input name="mobile_no_1" id="mobile_no_1" class="form-input number_only" maxlength="10"
                        value="{{ $staff_details->personal->mobile_no1 ?? '' }}" />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label ">Mobile No - 2</label>
                    <input name="mobile_no_2" class="form-input number_only" maxlength="10"
                        value="{{ $staff_details->personal->mobile_no2 ?? '' }}" />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label ">Whatsapp No.</label>
                    <input name="whatsapp_no" class="form-input number_only" maxlength="10"
                        value="{{ $staff_details->personal->whatsapp_no ?? '' }}" />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Emergency No.</label>
                    <input name="emergency_no" autofocus id="emergency_no"
                        class="form-input number_only" maxlength="10"
                        value="{{ $staff_details->personal->emergency_no ?? '' }}" />
                </div>
                <div class="col-lg-4 mb-5">
                    <div>

                        <label class="form-label"> Profile Image </label>
                        <input name="profile_image" type="file" autofocus id="profile_image"
                            class="form-input" />
                    </div>
                    <div>
                        @if (isset($staff_details->image) && !empty($staff_details->image))
                            @php
                                $profile_image = Storage::url($staff_details->image);
                            @endphp
                            <a class="" href="{{ asset('public' . $profile_image) }}" target="_blank">
                                <img src="{{ asset('public' . $profile_image) }}" alt="" width="75">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-4 mb-5">
                        <label class="form-label required">Contact Address</label>
                        <textarea name="contact_address" autofocus id="contact_address" class="form-input " rows="3"
                            required>{{ $staff_details->personal->contact_address ?? '' }}</textarea>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <label class="form-label required">Permanent Address
                            <span class="float-right">
                                <small class="fs-10">
                                    <input type="checkbox" name="is_same" id="is_same"> Same as Contact Address
                                </small>
                            </span>
                        </label>
                        <textarea name="permanent_address" autofocus id="permanent_address" class="form-input "
                            rows="3" required>{{ $staff_details->personal->permanent_address ?? '' }}</textarea>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <label class="form-label ">Pincode</label>
                        <input name="pincode" class="form-input number_only" maxlength="6"
                            value="{{ $staff_details->personal->pincode ?? '' }}" />
                    </div>
                </div>
                <hr>
                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Bank Details</label>
                        <div class="row fv-row">
                            <div class="col-lg-3 mb-5">
                                <div class="d-flex">
                                    <select name="bank_id" id="bank_id" class="select2-option"
                                        onchange="return getBranchDetails(this.value)">
                                        <option value="">--Select Bank--</option>
                                        @isset($banks)
                                            @foreach ($banks as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($staff_details->bank) && $staff_details->bank->bank_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if (access()->buttonAccess('bank', 'add_edit'))
                                        <button type="button" class="text-white btn-primary"
                                            onclick="return openAddModel('bank')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3 mb-5">
                                <div class="d-flex">
                                    <select name="branch_id" id="branch_id" class="select2-option">
                                        <option value="">--Select Bank Branch--</option>
                                        @isset($branch_details)
                                            @foreach ($branch_details as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($staff_details->bank) && $staff_details->bank->bank_branch_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if (access()->buttonAccess('bank-branch', 'add_edit'))
                                        <button type="button" class="text-white btn-primary"
                                            onclick="return openAddModel('bankbranch')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-3">
                                <input name="account_name" class="form-input "
                                    placeholder="Account Name"
                                    value="{{ $staff_details->bank->account_name ?? '' }}" />
                            </div>

                            <div class="col-3">
                                <input name="account_no" class="number_only form-input "
                                    placeholder="Account Number"
                                    value="{{ $staff_details->bank->account_number ?? '' }}" />
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Bank Passbook</label>
                        <div class="row fv-row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8 mb-1">
                                        <input class="form-control" style="" type="file"
                                            name="bank_passbook" multiple="">
                                    </div>

                                    @isset($staff_details->bank->passbook_image)
                                        <div class="col-12">
                                            <div class="d-flex justiy-content-around flex-wrap">

                                                @php
                                                    $url = Storage::url($staff_details->bank->passbook_image);
                                                @endphp

                                                <div class="d-inline-block p-2 bg-light m-1">
                                                    <a class="btn-sm btn-outline-info"
                                                        href="{{ asset('public' . $url) }}" target="_blank">View File
                                                    </a>
                                                    {{-- <a class="btn-sm btn-outline-danger"
                                                    onclick="removeDocument('{{ $staff_details->aadhaar->id }}'', '{{ $item }}')">
                                                    Remove
                                                </a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endisset
                                </div>

                            </div>
                            <div class="col-4">
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Canceled Cheque</label>
                        <div class="row fv-row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8 mb-1">
                                        <input class="form-control" style="" type="file"
                                            name="cancelled_cheque" multiple="">
                                    </div>
                                    @isset($staff_details->bank->cancelled_cheque)
                                        <div class="col-12">
                                            <div class="d-flex justiy-content-around flex-wrap">

                                                @php
                                                    $url = Storage::url($staff_details->bank->cancelled_cheque);
                                                @endphp

                                                <div class="d-inline-block p-2 bg-light m-1">
                                                    <a class="btn-sm btn-outline-info"
                                                        href="{{ asset('public' . $url) }}" target="_blank">View File
                                                    </a>
                                                    {{-- <a class="btn-sm btn-outline-danger"
                                                    onclick="removeDocument('{{ $staff_details->aadhaar->id }}'', '{{ $item }}')">
                                                    Remove
                                                </a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endisset
                                </div>

                            </div>
                            <div class="col-4">
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-10">
                    <div class="col-md-12 mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold form-label my-4">
                            <span class="">UAN Details</span>
                            <div class="mx-5 cstm-zeed">

                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-20px" type="radio" name="is_uan"
                                        onclick="handleClick(this)" value="yes"
                                        @if ($staff_details->pf->ac_number ?? '') checked @endif />
                                    <span class="form-check-label fw-bold">Yes</span>
                                </label>
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-20px" type="radio" name="is_uan"
                                        onclick="handleClick(this)" value="no"
                                        @if (!($staff_details->pf->ac_number ?? '')) checked @endif />
                                    <span class="form-check-label fw-bold"> No </span>
                                </label>

                            </div>
                        </label>
                        <div class="row fv-row" id="uan_display_pane">
                            <div class="col-4">
                                <input name="uan_no" id="uan_no" class="form-input "
                                    placeholder="Number" value="{{ $staff_details->pf->ac_number ?? '' }}" />
                            </div>
                            <div class="col-4">

                                <div class="position-relative d-flex align-items-center">
                                    
                                    <input class="form-control  ps-12" autocomplete="off" placeholder="Start date"
                                        name="uan_start_date" id="uan_start_date" type="date"
                                        value="{{ $staff_details->pf->start_date ?? '' }}" autofocus />
                                </div>

                            </div>
                            <div class="col-4">
                                <input name="uan_name" id="uan_name" class="form-input "
                                    placeholder="Name" value="{{ $staff_details->pf->name ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 fv-row">

                        <label class="d-flex align-items-center fs-6 fw-bold form-label my-4">
                            <span class="me-15 pe-3">ESI</span>
                            <div class="mx-5 cstm-zeed">

                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-20px" type="radio" name="is_esi"
                                        onclick="handleEsiClick(this)" value="yes"
                                        @if ($staff_details->esi->ac_number ?? '') checked @endif />
                                    <span class="form-check-label fw-bold">Yes</span>
                                </label>
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-20px" type="radio" name="is_esi"
                                        onclick="handleEsiClick(this)" value="no"
                                        @if (!($staff_details->esi->ac_number ?? '')) checked @endif />
                                    <span class="form-check-label fw-bold"> No </span>
                                </label>

                            </div>
                        </label>
                        <div class="row fv-row" id="esi_display_pane">
                            <div class="col-3">
                                <input name="esi_no" id="esi_no" class="form-input "
                                    placeholder="Number" value="{{ $staff_details->esi->ac_number ?? '' }}" />
                            </div>
                            <div class="col-3">
                                <div class="position-relative d-flex align-items-center">
                                    
                                    <input class="form-control  ps-12" autocomplete="off" placeholder="Start date"
                                        name="esi_start_date" id="esi_start_date" autofocus type="date"
                                        value="{{ $staff_details->esi->start_date ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="position-relative d-flex align-items-center">
                                    
                                    <input class="form-control  ps-12" autocomplete="off" placeholder="End date"
                                        name="esi_end_date" id="esi_end_date" autofocus type="date"
                                        value="{{ $staff_details->esi->end_date ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-3">
                                <input name="esi_address" class="form-input " placeholder="Area"
                                    value="{{ $staff_details->esi->location ?? '' }}" />
                            </div>
                            <div class="col-3 mt-3">
                                <input name="esi_name" class="form-input " placeholder="Name"
                                    value="{{ $staff_details->esi->name ?? '' }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    @if ($staff_details->pf->ac_number ?? '')
        $('#uan_display_pane').show();
    @else
        $('#uan_display_pane').hide();
    @endif
    function handleClick(myRadio) {

        if (myRadio.value == 'no') {
            $('#uan_display_pane').hide();
        } else {
            $('#uan_display_pane').show();
        }
    }

    @if ($staff_details->esi->ac_number ?? '')
        $('#esi_display_pane').show();
    @else
        $('#esi_display_pane').hide();
    @endif
    function handleEsiClick(myRadio) {
        if (myRadio.value == 'no') {
            $('#esi_display_pane').hide();
        } else {
            $('#esi_display_pane').show();
        }
    }

    const datepicker = document.getElementById('dob');
    const marital_status = document.getElementById('marital_status');
    marital_status.addEventListener('change', function() {
        if (this.value == 'married') {
            document.getElementById('marriage_data').style.display = 'block';
        } else {
            document.getElementById('marriage_data').style.display = 'none';
        }
    });

    function getBranchDetails(bank_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('branch.all') }}",
            type: "POST",
            data: {
                bank_id: bank_id
            },
            success: function(res) {
                if (res.branch_data) {
                    var option = '';
                    res.branch_data.forEach(element => {
                        let selected = '';

                        option += `<option value="${element.id}" >${element.name}</option>`;
                    });
                    $('#branch_id').html(option);
                }
            }
        })
    }
    $(function() {
        // $("#date_of_birth").datepicker({
        //     dateFormat: 'd-mm-yy'
        // });
        // $('#marriage_date').datepicker({
        //     dateFormat: 'd-mm-yy'
        // });
        // $('#uan_start_date').datepicker({
        //     dateFormat: 'd-mm-yy'
        // });
        // $('#esi_start_date').datepicker({
        //     dateFormat: 'd-mm-yy'
        // });
        // $('#esi_end_date').datepicker({
        //     dateFormat: 'd-mm-yy'
        // });
        // $('.select2-option').select2({
        //     dateFormat: 'd-mm-yy'
        // });
        $('.select2-option').select2({
            theme: 'bootstrap-5'
        });
    });


    async function validateKycForm() {
        event.preventDefault();
        var kyc_error = false;

        var key_name = [
            'date_of_birth',
            'marital_status',
            'language_id',
            'place_of_birth_id',
            'nationality_id',
            'religion_id',
            'caste_id',
            'community_id',
            'mobile_no_1',
            'emergency_no',
            'contact_address',
            'permanent_address'
        ];

        $('.kyc-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                kyc_error = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container kyc-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!kyc_error) {
            loading();
            var forms = $('#kyc-form')[0];
            var formData = new FormData(forms);
            var staff_id = $('#outer_staff_id').val();
            formData.append('outer_staff_id', staff_id);

            const kycResponse = await fetch("{{ route('staff.save.kyc') }}", {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    unloading();

                    if (data.error == 1) {
                        var err_message = '';
                        if (data.message) {
                            data.message.forEach(element => {
                                err_message += '<p>' + element + '</p>';
                            });
                            toastr.error("Error", err_message);
                        }
                        return true;
                    } else {
                        return false;
                    }

                });
            return kycResponse;

        } else {

            return true;
        }
    }

    $('#is_same').change(function(){
        if( $(this).is(":checked") ) {
            var old_data = $('#contact_address').val();
            $('#permanent_address').val(old_data);
        } else {
            $('#permanent_address').val('');
        }
    })
</script>
