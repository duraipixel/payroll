<div data-kt-stepper-element="content">
    <form id="kyc-form">
        @csrf
        <div class="w-100">
            <div class="pb-5 pb-lg-5">
                <h2 class="fw-bolder text-dark">KYC Details</h2>
            </div>
            <div class="row">
                <div class="col-md-4 fv-row mb-5">
                    <label class="required fs-6 fw-bold mb-2">Date of Birth</label>
                    <div class="position-relative d-flex align-items-center">
                        {!! dobSVG() !!}
                        <input class="form-control  ps-12" autocomplete="off" placeholder="Select a date" name="date_of_birth"
                            id="date_of_birth" autofocus />
                    </div>
                </div>
                <div class="mb-5 col-lg-4 fv-row">
                    <div class="d-inline-block flex-stack">
                        <div class="fw-bold me-5">
                            <label class="fs-6 required">Gender</label>
                        </div>
                        <div class="d-block mt-5 align-items-center cstm-zeed">
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-20px" type="radio" name="gender"
                                    value="Male" />
                                <span class="form-check-label fw-bold">Male</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-20px" type="radio" name="gender"
                                    value="Female" />
                                <span class="form-check-label fw-bold">Female</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input h-20px w-20px" type="radio" name="gender"
                                    value="Others" />
                                <span class="form-check-label fw-bold">Others</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Marital Status</label>
                    <select name="marital_status" id="marital_status" autofocus class="form-select form-select-lg">
                        <option value="">Select Status</option>
                        <option value="married">Married</option>
                        <option value="single">Single</option>
                        <option value="divorced">Divorced</option>
                    </select>
                </div>
                <div class="col-md-4 fv-row mb-5">
                    <label class="fs-6 fw-bold mb-2">Marriage Date</label>
                    <div class="position-relative d-flex align-items-center">
                        {!! dobSVG() !!}
                        <input class="form-control  ps-12" placeholder="Select a date" name="marriage_date"
                            id="marriage_date" />
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Mother Tongue</label>
                    <div class="position-relative">
                        <select name="language_id" autofocus id="language_id" class="form-select form-select-lg select2-option">
                            <option value="">--Select Language--</option>
                            @isset($mother_tongues)
                                @foreach ($mother_tongues as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('language')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Place of Birth </label>
                    <div class="position-relative">
                        <select name="place_of_birth_id" autofocus id="place_of_birth_id"
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Place--</option>
                            @isset($places)
                                @foreach ($places as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('places')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Nationality</label>
                    <div class="position-relative">
                        <select name="nationality_id" autofocus id="nationality_id"
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Nationality--</option>
                            @isset($nationalities)
                                @foreach ($nationalities as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('nationality')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Religion</label>
                    <div class="position-relative">
                        <select name="religion_id" autofocus id="religion_id" class="form-select form-select-lg select2-option">
                            <option value="">--Select Religion--</option>
                            @isset($religions)
                                @foreach ($religions as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('religion')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Caste</label>
                    <div class="position-relative">
                        <select name="caste_id" autofocus id="caste_id" class="form-select form-select-lg select2-option">
                            <option value="">--Select Caste--</option>
                            @isset($castes)
                                @foreach ($castes as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('caste')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Community</label>
                    <div class="position-relative">
                        <select name="community_id" autofocus id="community_id"
                            class="form-select form-select-lg select2-option">
                            <option value="">--Select Community--</option>
                            @isset($communities)
                                @foreach ($communities as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0"
                            onclick="return openAddModel('community')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Phone No.</label>
                    <input name="phone_no" autofocus id="phone_no" class="form-control form-control-lg " />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label">Mobile No - 1</label>
                    <input name="mobile_no_1" class="form-control form-control-lg " />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label ">Mobile No - 2</label>
                    <input name="mobile_no_2" class="form-control form-control-lg " />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label ">Whatsapp No.</label>
                    <input name="whatsapp_no" class="form-control form-control-lg " />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Emergency No.</label>
                    <input name="emergency_no" autofocus id="emergency_no" class="form-control form-control-lg " />
                </div>
                <div class="col-lg-6 mb-5">
                    <label class="form-label required">Contact Address</label>
                    <textarea name="contact_address" autofocus id="contact_address" class="form-control form-control-lg " rows="3" required></textarea>
                </div>
                <div class="col-lg-6 mb-5">
                    <label class="form-label required">Permanent Address</label>
                    <textarea name="permanent_address" autofocus id="permanent_address" class="form-control form-control-lg " rows="3"
                        required></textarea>
                </div>

                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Bank Details</label>
                        <div class="row fv-row">
                            <div class="col-lg-3 mb-5">
                                <div class="position-relative">
                                    <select name="bank_id" id="bank_id"
                                        class="form-select form-select-lg select2-option" onchange="return getBranchDetails(this.value)">
                                        <option value="">--Select Bank--</option>
                                        @isset($banks)
                                            @foreach ($banks as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    <span class="position-absolute btn btn-success btn-md top-0 end-0"
                                        onclick="return openAddModel('bank')">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-3 mb-5">
                                <div class="position-relative">
                                    <select name="branch_id" id="branch_id"
                                        class="form-select form-select-lg select2-option">
                                        <option value="">--Select Bank Branch--</option>
                                        {{-- @isset($banks)
                                            @foreach ($banks as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset --}}
                                    </select>
                                    <span class="position-absolute btn btn-success btn-md top-0 end-0"
                                        onclick="return openAddModel('bankbranch')">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-3">
                                <input name="account_name" class="form-control form-control-lg "
                                    placeholder="Account Name" />
                            </div>

                            <div class="col-3">
                                <input name="account_no" class="form-control form-control-lg "
                                    placeholder="Account Number" />
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Bank Passbook</label>
                        <div class="row fv-row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Upload
                                        File:</label>
                                    <div class="col-lg-6">
                                        <div class="uppy" id="kt_uppy_5">
                                            <div class="uppy-wrapper">
                                                <div class="uppy-Root uppy-FileInput-container">
                                                    <input class="uppy-FileInput-input uppy-input-control"
                                                        style="" type="file" name="bank_passbook"
                                                        id="kt_uppy_5_input_control">
                                                    <label
                                                        class="uppy-input-label btn btn-light-primary btn-sm btn-bold"
                                                        for="kt_uppy_5_input_control">Attach files</label>
                                                </div><span class="form-text text-dark">Maximum file size
                                                    1MB</span>
                                            </div>
                                            <div class="uppy-list"></div>
                                            <div class="uppy-status">
                                                <div class="uppy-Root uppy-StatusBar is-waiting" aria-hidden="true"
                                                    dir="ltr">
                                                    <div class="uppy-StatusBar-progress" style="width: 0%;"
                                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                        aria-valuenow="0"></div>
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
                            <div class="col-4">
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Canceled Cheque</label>
                        <div class="row fv-row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Upload
                                        File:</label>
                                    <div class="col-lg-6">
                                        <div class="uppy" id="kt_uppy_5">
                                            <div class="uppy-wrapper">
                                                <div class="uppy-Root uppy-FileInput-container">
                                                    <input class="uppy-FileInput-input uppy-input-control"
                                                        type="file" name="cancelled_cheque"
                                                        id="kt_uppy_5_input_control">
                                                    <label
                                                        class="uppy-input-label btn btn-light-primary btn-sm btn-bold"
                                                        for="kt_uppy_5_input_control">
                                                        Attach files
                                                    </label>
                                                </div>
                                                <span class="form-text text-dark">
                                                    Maximum file size
                                                    1MB
                                                </span>
                                            </div>
                                            <div class="uppy-list"></div>
                                            <div class="uppy-status">
                                                <div class="uppy-Root uppy-StatusBar is-waiting" aria-hidden="true"
                                                    dir="ltr">
                                                    <div class="uppy-StatusBar-progress" style="width: 0%;"
                                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                        aria-valuenow="0"></div>
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
                            <div class="col-4">
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-10">
                    <div class="col-md-12 mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="">UAN Details</span>
                        </label>
                        <div class="row fv-row">
                            <div class="col-4">
                                <input name="uan_no" id="uan_no" class="form-control form-control-lg "
                                    placeholder="Number" />
                            </div>
                            <div class="col-4">

                                <div class="position-relative d-flex align-items-center">
                                    {!! dobSVG() !!}
                                    <input class="form-control  ps-12" autocomplete="off" placeholder="Start date" name="uan_start_date"
                                        id="uan_start_date" autofocus />
                                </div>
                                
                            </div>
                            <div class="col-4">
                                <input name="uan_area" id="uan_area" class="form-control form-control-lg "
                                    placeholder="Area" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">ESI</label>
                        <div class="row fv-row">
                            <div class="col-3">
                                <input name="esi_no" id="esi_no" class="form-control form-control-lg "
                                    placeholder="Number" />
                            </div>
                            <div class="col-3">
                                <div class="position-relative d-flex align-items-center">
                                    {!! dobSVG() !!}
                                    <input class="form-control  ps-12" autocomplete="off" placeholder="Start date" name="esi_start_date"
                                        id="esi_start_date" autofocus />
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="position-relative d-flex align-items-center">
                                    {!! dobSVG() !!}
                                    <input class="form-control  ps-12" autocomplete="off" placeholder="End date" name="esi_end_date"
                                        id="esi_end_date" autofocus />
                                </div>
                            </div>
                            <div class="col-3">
                                <input name="esi_address" class="form-control form-control-lg " placeholder="Area" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const datepicker = document.getElementById('dob');

    function getBranchDetails(bank_id) {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            url: "{{ route('branch.all') }}",
            type: "POST",
            data: {bank_id:bank_id},
            success: function(res) {
                if( res.branch_data ) {
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
        $("#date_of_birth").datepicker({
                dateFormat:'d-mm-yy'
            });
        $('#marriage_date').datepicker({
                dateFormat:'d-mm-yy'
            });
        $('#uan_start_date').datepicker({
                dateFormat:'d-mm-yy'
            });
        $('#esi_start_date').datepicker({
                dateFormat:'d-mm-yy'
            });
        $('#esi_end_date').datepicker({
                dateFormat:'d-mm-yy'
            });
        $('.select2-option').select2({
                dateFormat:'d-mm-yy'
            });
    });

    
    function validateKycForm() {
        event.preventDefault();
        var kyc_error = false;
        console.log(kyc_error, 'kyc_error');
        var key_name = [
            'date_of_birth',            
            'marital_status',
            'language_id',
            'place_of_birth_id',
            'nationality_id',
            'religion_id',
            'caste_id',
            'community_id',
            'phone_no',
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

            var forms = $('#kyc-form')[0];
            var formData = new FormData(forms);
            $.ajax({
                url: "{{ route('staff.save.kyc') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    unloading();
                    
                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error", element);
                            });
                        }
                        // console.log('form erorro occurres');
                        return true;

                    } else {

                        console.log('form submit success');

                        return false;
                    }
                    console.log('resoponse recevied');
                }
            })
            return true;
        } else {

            return true;
        }
    }
</script>
