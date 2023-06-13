<div class="current" data-kt-stepper-element="content">
    <form id="personal_form">
        @csrf
        <div class="fv-row  row">
            <div class="col-lg-4 mb-5 rd-only">
                <label class="input-label">Employee Code</label>
                <input name="society_employee_code" id="society_employee_code" class="form-input"
                    value="{{ $staff_details->society_emp_code ?? 'Draft' }}" readonly />
            </div>
            <div class="col-lg-4 mb-5">
                <label class="input-label required">Institution Name</label>
                <div class="d-flex">
                    <select name="institute_name" id="institute_name" class="form-input">
                        <option value="">--Select Institution--</option>
                        @isset($institutions)
                            @foreach ($institutions as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->institute_id) && $staff_details->institute_id == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                    @if (access()->buttonAccess('institutions', 'add_edit'))
                        <button type="button" onclick="return openAddModel('intitution')"
                            class="btn-dark text-white"><i class="fa fa-plus"></i></button>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 mb-5 rd-only">
                <label class="input-label">Institution Code</label>
                <input name="institute_code" id="institute_code" class="form-input"
                    value="{{ $staff_details->institute_emp_code ?? 'Draft' }}" readonly />
            </div>
            <div class="col-lg-4 mb-5 rd-only position-relative">
                <label class="input-label required">Previous Code</label>
                <input name="previous_code" id="previous_code" class="form-input"
                    value="{{ $staff_details->emp_code ?? '' }}" />
            </div>

            <div class="col-lg-4 mb-5">
                <label class="input-label required">Name (In English)</label>
                <input name="name" id="name" value="{{ $staff_details->name ?? '' }}" class="form-input" />
            </div>
            <div class="col-lg-4 mb-5 use-latha">
                <label class="d-flex align-items-center input-label required">
                    <span class="">Name (In Tamil)</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover"
                        data-bs-html="true"
                        data-bs-content="&lt;div class='d-flex flex-stack text-dark fw-bolder'&gt; &lt;div&gt;Please Type in Tamil&lt;/div&gt; &lt;/div&gt; &lt;div class='d-flex flex-stack text-muted'&gt;"></i>
                </label>
                <input name="first_name_tamil" value="{{ $staff_details->first_name_tamil ?? '' }}" id="content"
                    class="form-input tamil" />
            </div>
            <div class="col-lg-4 mb-5">
                <label class="input-label">Short Name</label>
                <input name="short_name" id="short_name" value="{{ $staff_details->short_name ?? '' }}"
                    class="form-input" />
            </div>
            <div class="col-lg-4 mb-5">
                <label class="input-label required">Email ID</label>
                <input name="email" id="email" value="{{ $staff_details->email ?? '' }}" class="form-input" />
            </div>

            <input type="hidden" name="id" id="staff_id" value="{{ $staff_details->id ?? '' }}">

            <div class="col-lg-4 mb-5">
                <label class="input-label">Reporting Manager</label>
                <select name="reporting_manager_id" id="reporting_manager_id" class="form-input">
                    <option value=""> --Select Reporting Manager-- </option>
                    @isset($reporting_managers)
                        @foreach ($reporting_managers as $item)
                            <option value="{{ $item->manager_id }}" @if (isset($staff_details->reporting_manager_id) && $staff_details->reporting_manager_id == $item->manager_id) selected @endif>
                                {{ $item->manager->name }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="p-3">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-bold">#Card</th>
                            <th class="fw-bold">Name</th>
                            <th class="fw-bold">Card Number</th>
                            <th class="fw-bold">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Aadhaar</th>
                            <td>
                                <input name="aadhar_name" id="aadhar_name"
                                    value="{{ $staff_details->aadhaar->description ?? '' }}" class="form-input "
                                    placeholder="Name" />
                            </td>
                            <td>
                                <input name="aadhar_no" class="form-input " placeholder="Number"
                                    value="{{ $staff_details->aadhaar->doc_number ?? '' }}" />
                            </td>
                            <td>
                                <input class="form-input" style="" type="file" name="aadhar[]" multiple="">
                                @isset($staff_details->aadhaar->multi_file)
                                    @php
                                        $paths = explode(',', $staff_details->aadhaar->multi_file);
                                        
                                    @endphp
                                    @isset($paths)

                                        @foreach ($paths as $item)
                                            @php
                                                $url = Storage::url($item);
                                            @endphp

                                            <div class="d-inline-block p-2 bg-light m-1">
                                                <a class="btn-sm btn-success" href="{{ asset('public' . $url) }}"
                                                    target="_blank">View File </a>
                                            </div>
                                        @endforeach
                                    @endisset
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Pan</th>
                            <td>
                                <input name="pancard_name" class="form-input " placeholder="Name"
                                    value="{{ $staff_details->pan->description ?? '' }}" />
                            </td>
                            <td>
                                <input name="pancard_no" class="form-input " placeholder="Number"
                                    value="{{ $staff_details->pan->doc_number ?? '' }}" />
                            </td>
                            <td>
                                <input class="form-input" style="" type="file" name="pancard[]"
                                    multiple="">
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
                                                        <a class="btn-sm btn-success" href="{{ asset('public' . $url) }}"
                                                            target="_blank">View File </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    @endisset
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Ration Card</th>
                            <td>
                                <input name="ration_card_name" class="form-input " placeholder="Name"
                                    value="{{ $staff_details->ration->description ?? '' }}" />
                            </td>
                            <td>
                                <input name="ration_card_number" class="form-input " placeholder="Number"
                                    value="{{ $staff_details->ration->doc_number ?? '' }}" />
                            </td>
                            <td>
                                <input class="form-input" style="" type="file" name="ration_card[]"
                                    multiple="">
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
                                                        <a class="btn-sm btn-success" href="{{ asset('public' . $url) }}"
                                                            target="_blank">View File </a>
                                                        <a class="btn-sm btn-outline-danger"
                                                            onclick="removeDocument('{{ $staff_details->ration->id }}'', '{{ $item }}')">
                                                            Remove
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    @endisset
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Driving Licence</th>
                            <td>
                                <input name="license_name" class="form-input " placeholder="Name"
                                    value="{{ $staff_details->driving_license->description ?? '' }}" />
                            </td>
                            <td>
                                <input name="license_number" class="form-input " placeholder="Number"
                                    value="{{ $staff_details->driving_license->doc_number ?? '' }}" />
                            </td>
                            <td>
                                <input class="form-input" style="" type="file" name="driving_license[]"
                                    multiple="">
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
                                                        <a class="btn-sm btn-success" href="{{ asset('public' . $url) }}"
                                                            target="_blank">View File </a>
                                                        <a class="btn-sm btn-outline-danger"
                                                            onclick="removeDocument('{{ $staff_details->driving_license->id }}'', '{{ $item }}')">
                                                            Remove
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    @endisset
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Voter ID</th>
                            <td>
                                <input name="voter_name" class="form-input " placeholder="Name"
                                    value="{{ $staff_details->voter->description ?? '' }}" />
                            </td>
                            <td>
                                <input name="voter_number" class="form-input " placeholder="Number"
                                    value="{{ $staff_details->voter->doc_number ?? '' }}" />
                            </td>
                            <td>
                                <input class="form-input" style="" type="file" name="voter[]"
                                    multiple="">
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
                                                        <a class="btn-sm btn-success" href="{{ asset('public' . $url) }}"
                                                            target="_blank">View File </a>
                                                        <a class="btn-sm btn-outline-danger"
                                                            onclick="removeDocument('{{ $staff_details->voter->id }}'', '{{ $item }}')">
                                                            Remove
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    @endisset
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Passport</th>
                            <td>
                                <input name="passport_name" id="passport_name" class="form-input "
                                    placeholder="Passport Name"
                                    value="{{ $staff_details->passport->description ?? '' }}" />
                            </td>
                            <td>
                                <input name="passport_number" class="form-input " placeholder="Passport Number"
                                    value="{{ $staff_details->passport->doc_number ?? '' }}" />
                            </td>
                            <td>
                                <input class="form-input" style="" type="file" name="passport[]"
                                    multiple="">
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
                                                        <a class="btn-sm btn-success" href="{{ asset('public' . $url) }}"
                                                            target="_blank">View File </a>
                                                        <a class="btn-sm btn-outline-danger"
                                                            onclick="removeDocument('{{ $staff_details->passport->id }}'', '{{ $item }}')">
                                                            Remove
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endisset
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </form>
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
