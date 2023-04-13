<div class="current" data-kt-stepper-element="content">
    <div class="w-100">
        <div class="pb-5 pb-lg-5">
            <h2 class="fw-bolder text-dark">Personal Details</h2>
        </div>
        <form id="personal_form">
            @csrf

            <div class="fv-row  row">
                <div class="col-lg-4 mb-5 rd-only">
                    <label class="form-label">Employee Code</label>
                    <input name="society_employee_code" id="society_employee_code" class="form-control form-control-lg "
                        value="{{ $staff_details->society_emp_code ?? 'Draft' }}" readonly />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Institution Name</label>
                    <div class="position-relative">
                        <select name="institute_name" id="institute_name" class="form-select form-select-lg ">
                            <option value="">--Select Institution--</option>
                            @isset($institutions)
                                @foreach ($institutions as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_details->institute_id) && $staff_details->institute_id == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="position-absolute btn btn-success btn-md top-0 end-0 p-4"
                            onclick="return openAddModel('intitution')">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2 mb-5 rd-only">
                    <label class="form-label">Institution Code</label>
                    <input name="institute_code" id="institute_code" class="form-control form-control-lg "
                        value="{{ $staff_details->institute_emp_code ?? 'Draft' }}" readonly />
                </div>
                <div class="col-lg-2 mb-5 rd-only position-relative">
                    <label class="form-label required">Previous Code</label>
                    <input name="previous_code" id="previous_code" class="form-control form-control-lg "
                        value="{{ $staff_details->emp_code ?? '' }}" />
                </div>

                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Name (In English)</label>
                    <input name="name" id="name" value="{{ $staff_details->name ?? '' }}"
                        class="form-control form-control-lg " />
                </div>
                <div class="col-lg-4 mb-5 use-latha">
                    <label class="d-flex align-items-center form-label required">
                        <span class="">Name (In Tamil)</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover"
                            data-bs-html="true"
                            data-bs-content="&lt;div class='d-flex flex-stack text-dark fw-bolder'&gt; &lt;div&gt;Please Type in Tamil&lt;/div&gt; &lt;/div&gt; &lt;div class='d-flex flex-stack text-muted'&gt;"></i>
                    </label>
                    <input name="first_name_tamil" value="{{ $staff_details->first_name_tamil ?? '' }}" id="content"
                        class="form-control form-control-lg  tamil" />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label">Short Name</label>
                    <input name="short_name" id="short_name" value="{{ $staff_details->short_name ?? '' }}"
                        class="form-control form-control-lg " />
                </div>
                <div class="col-lg-4 mb-5">
                    <label class="form-label required">Email ID</label>
                    <input name="email" id="email" value="{{ $staff_details->email ?? '' }}"
                        class="form-control form-control-lg " />
                </div>
                
                <input type="hidden" name="id" id="staff_id" value="{{ $staff_details->id ?? '' }}">
                
                <div class="col-lg-4 mb-5">
                    <label class="form-label">Reporting Manager</label>
                    <select name="reporting_manager_id" id="reporting_manager_id" class="form-select form-select-lg ">
                        <option value=""> --Select Reporting Manager-- </option>
                        @isset($reporting_managers)
                            @foreach ($reporting_managers as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->reporting_manager_id) && $staff_details->reporting_manager_id == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <hr>

                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Aadhaar Card</label>
                        <div class="row fv-row">
                            <div class="col-4">
                                <input name="aadhar_name" id="aadhar_name"
                                    value="{{ $staff_details->aadhaar->description ?? '' }}"
                                    class="form-control form-control-sm " placeholder="Name" />
                            </div>
                            <div class="col-4">
                                <input name="aadhar_no" class="form-control form-control-sm " placeholder="Number"
                                    value="{{ $staff_details->aadhaar->doc_number ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8 mb-1">
                                        <input class="form-control form-control-sm" style="" type="file" name="aadhar[]"
                                            multiple="">
                                    </div>
                                    @isset($staff_details->aadhaar->multi_file)
                                        @php
                                            $paths = explode(',', $staff_details->aadhaar->multi_file);
                                        @endphp

                                        @isset($paths)
                                            <div class="col-12">
                                                <div class="d-flex justiy-content-around flex-wrap">
                                                    @foreach ($paths as $item)
                                                        @php
                                                            $url = Storage::url($item);
                                                        @endphp

                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success" href="{{ asset('public'.$url) }}"
                                                                target="_blank">View File </a>
                                                            {{-- <a class="btn-sm btn-outline-danger"
                                                                onclick="removeDocument('{{ $staff_details->aadhaar->id }}'', '{{ $item }}')">
                                                                Remove
                                                            </a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @endisset
                                    @endisset
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Pan Card</label>
                        <div class="row fv-row">
                            <div class="col-4">
                                <input name="pancard_name" class="form-control form-control-sm " placeholder="Name"
                                    value="{{ $staff_details->pan->description ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <input name="pancard_no" class="form-control form-control-sm " placeholder="Number"
                                    value="{{ $staff_details->pan->doc_number ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8">
                                        <input class="form-control form-control-sm" style="" type="file" name="pancard[]"
                                            multiple="">
                                    </div>
                                    @isset($staff_details->pan->multi_file)
                                        @php
                                            $paths = explode(',', $staff_details->pan->multi_file);
                                        @endphp

                                        @isset($paths)
                                            <div class="col-12">
                                                <div class="d-flex justiy-content-around flex-wrap">
                                                    @foreach ($paths as $item)
                                                        @php
                                                            $url = Storage::url($item);
                                                        @endphp

                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success" href="{{ asset('public'.$url) }}"
                                                                target="_blank">View File </a>
                                                            {{-- <a class="btn-sm btn-outline-danger"
                                                                onclick="removeDocument('{{ $staff_details->pan->id }}'', '{{ $item }}')">
                                                                Remove
                                                            </a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @endisset
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Ration Card</label>
                        <div class="row fv-row">
                            <div class="col-4">
                                <input name="ration_card_name" class="form-control form-control-sm "
                                    placeholder="Name" value="{{ $staff_details->ration->description ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <input name="ration_card_number" class="form-control form-control-sm "
                                    placeholder="Number" value="{{ $staff_details->ration->doc_number ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8">
                                        <input class="form-control form-control-sm" style="" type="file"
                                            name="ration_card[]" multiple="">
                                    </div>
                                    @isset($staff_details->ration->multi_file)
                                        @php
                                            $paths = explode(',', $staff_details->ration->multi_file);
                                        @endphp

                                        @isset($paths)
                                            <div class="col-12">
                                                <div class="d-flex justiy-content-around flex-wrap">
                                                    @foreach ($paths as $item)
                                                        @php
                                                            $url = Storage::url($item);
                                                        @endphp

                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success" href="{{ asset('public'.$url) }}"
                                                                target="_blank">View File </a>
                                                            {{-- <a class="btn-sm btn-outline-danger"
                                                                onclick="removeDocument('{{ $staff_details->ration->id }}'', '{{ $item }}')">
                                                                Remove
                                                            </a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @endisset
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Driving Licence</label>
                        <div class="row fv-row">
                            <div class="col-4">
                                <input name="license_name" class="form-control form-control-sm " placeholder="Name"
                                    value="{{ $staff_details->driving_license->description ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <input name="license_number" class="form-control form-control-sm "
                                    placeholder="Number"
                                    value="{{ $staff_details->driving_license->doc_number ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">
                                            Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8">
                                        <input class="form-control form-control-sm" style="" type="file"
                                            name="driving_license[]" multiple="">
                                    </div>
                                    @isset($staff_details->driving_license->multi_file)
                                        @php
                                            $paths = explode(',', $staff_details->driving_license->multi_file);
                                        @endphp

                                        @isset($paths)
                                            <div class="col-12">
                                                <div class="d-flex justiy-content-around flex-wrap">
                                                    @foreach ($paths as $item)
                                                        @php
                                                            $url = Storage::url($item);
                                                        @endphp

                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success" href="{{ asset('public'.$url) }}"
                                                                target="_blank">View File </a>
                                                            {{-- <a class="btn-sm btn-outline-danger"
                                                                onclick="removeDocument('{{ $staff_details->driving_license->id }}'', '{{ $item }}')">
                                                                Remove
                                                            </a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @endisset
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Voter ID</label>
                        <div class="row fv-row">
                            <div class="col-4">
                                <input name="voter_name" class="form-control form-control-sm " placeholder="Name"
                                    value="{{ $staff_details->voter->description ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <input name="voter_number" class="form-control form-control-sm " placeholder="Number"
                                    value="{{ $staff_details->voter->doc_number ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8">
                                        <input class="form-control form-control-sm" style="" type="file" name="voter[]"
                                            multiple="">
                                    </div>
                                    @isset($staff_details->voter->multi_file)
                                        @php
                                            $paths = explode(',', $staff_details->voter->multi_file);
                                        @endphp

                                        @isset($paths)
                                            <div class="col-12">
                                                <div class="d-flex justiy-content-around flex-wrap">
                                                    @foreach ($paths as $item)
                                                        @php
                                                            $url = Storage::url($item);
                                                        @endphp
                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success" href="{{ asset('public'.$url) }}"
                                                                target="_blank">View File </a>
                                                            {{-- <a class="btn-sm btn-outline-danger"
                                                                onclick="removeDocument('{{ $staff_details->voter->id }}'', '{{ $item }}')">
                                                                Remove
                                                            </a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @endisset
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold form-label mb-2">Passport</label>
                        <div class="row fv-row">
                            <div class="col-3">
                                <input name="passport_name" id="passport_name" class="form-control form-control-sm "
                                    placeholder="Passport Name"
                                    value="{{ $staff_details->passport->description ?? '' }}" />
                            </div>
                            <div class="col-3">
                                <input name="passport_number" class="form-control form-control-sm "
                                    placeholder="Passport Number"
                                    value="{{ $staff_details->passport->doc_number ?? '' }}" />
                            </div>
                            <div class="col-2">
                                <input type="date" name="passport_valid_upto"
                                    class="form-control form-control-sm " placeholder="Valid Upto"
                                    value="{{ $staff_details->passport->doc_date ?? '' }}" />
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-form-label text-lg-right">Upload
                                            File:</label>
                                    </div>
                                    <div class="col-8">
                                        <input class="form-control form-control-sm" style="" type="file" name="passport[]"
                                            multiple="">
                                    </div>
                                    @isset($staff_details->passport->multi_file)
                                        @php
                                            $paths = explode(',', $staff_details->passport->multi_file);
                                        @endphp

                                        @isset($paths)
                                            <div class="col-12">
                                                <div class="d-flex justiy-content-around flex-wrap">
                                                    @foreach ($paths as $item)
                                                        @php
                                                            $url = Storage::url($item);
                                                        @endphp
                                                        <div class="d-inline-block p-2 bg-light m-1">
                                                            <a class="btn-sm btn-success" href="{{ asset('public'.$url) }}"
                                                                target="_blank">View File </a>
                                                            {{-- <a class="btn-sm btn-outline-danger"
                                                                onclick="removeDocument('{{ $staff_details->passport->id }}'', '{{ $item }}')">
                                                                Remove
                                                            </a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endisset
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    async function validatePersonalForm() {

        var personsal_error = false;

        var key_name = [
            'institute_name',
            'name',
            'previous_code',
            'email',           
        ];
        $('.personal-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                personsal_error = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container personal-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!personsal_error) {
            var formHasValidated = true;
            var forms = $('#personal_form')[0];
            var formData = new FormData(forms);

            loading();

            const urlRespon = await fetch("{{ route('staff.save.personal') }}", {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    unloading();
                    if (data.id) {
                        setTimeout(() => {
                            $('#staff_id').val(data.id);
                            $('#outer_staff_id').val(data.id);
                        }, 1000);
                    }
                    if (data.error == 1) {

                        if (data.message) {
                            data.message.forEach(element => {
                                toastr.error("Error", element);
                            });
                        }
                        return true;

                    } else {

                        return false;

                    }
                });
            return urlRespon


        } else {

            return true;
        }
    }

    function getStaffData(code) {

        var code = $(code).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.get.draft.data') }}",
            type: 'POST',
            data: {
                code: code
            },
            success: function(res) {
                console.log(res);
            }
        })

    }
</script>
