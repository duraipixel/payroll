<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <div class="fv-row mb-10">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group col-sm-6">
                    <label class="form-label required" for="">
                        Salary Heads
                    </label>
                    <div>
                        <select name="salary_head_id" id="salary_head_id" onchange="return getHeadFields(this.value)"
                            class="form-control">
                            <option value="">-select salary head-</option>
                            @isset($heads)
                                @foreach ($heads as $item)
                                    <option value="{{ $item->id }}" @if( isset($info->salary_head_id) && $info->salary_head_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="form-group">
                    <label class="form-label required" for="">
                        Salary Field Name
                    </label>
                    <div>
                        <input type="text" class="form-control" name="name" value="{{ $info->name ?? '' }}" id="name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="form-group">
                    <label class="form-label required" for="">
                        Salary Field Short Name
                    </label>
                    <div>
                        <input type="text" class="form-control" name="short_name" value="{{ $info->short_name ?? '' }}"
                            id="short_name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="">
                    Entry Type
                </label>
                <div>
                    <input type="radio" id="manual" onchange="return getEntryType(this)" class="form-check-input"
                        value="manual" name="entry_type"
                        @if (isset($info->entry_type) && $info->entry_type == 'manual') checked @elseif(!isset($info->entry_type)) checked @endif>
                    <label class="pe-3" for="manual">Manual</label>
                    <input type="radio" id="calculation" onchange="return getEntryType(this)" class="form-check-input"
                        value="calculation" name="entry_type" @if (isset($info->entry_type) && $info->entry_type == 'calculation') checked @endif>
                    <label for="calculation" class="pe-3">Calculation</label>
                    <input type="radio" id="inbuilt_calculation" onchange="return getEntryType(this)" class="form-check-input"
                        value="inbuilt_calculation" name="entry_type" @if (isset($info->entry_type) && $info->entry_type == 'inbuilt_calculation') checked @endif>
                    <label for="inbuilt_calculation">InBuilt Calculation</label>
                </div>
            </div>
            <div class="col-sm-6 @if (isset($info->entry_type) && $info->entry_type == 'calculation') d-none @endif" id="entry_type_pane">
                <div class="form-group mt-3">
                    <label class="form-label required" for="">
                        Total no of Numerals
                    </label>
                    <div>
                        <input type="text" class="form-control number_only" name="no_of_numerals"
                            value="{{ $info->no_of_numerals ?? '' }}" id="no_of_numerals" required>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <div class="fv-row form-group mb-10  @if (isset($info->entry_type) && $info->entry_type == 'manual') d-none @endif" id="calcuation-pane">
        <h4>Select Fields with Percentage</h4>
        <ul type="none" class="w-75 p-0" id="field-item-pane">
            @isset($info->field_items)
                @foreach ($info->field_items as $items)
                    
                <li class="border border-2 p-2 field-item-pane">
                    <div class="d-flex w-100">
                        <div class="w-50 d-flex align-items-center">
                            <input type="checkbox" checked name="field_name[]" id="basic{{ $items->field_id }}" value="{{ $items->field_id }}" data-id="basic{{ $items->field_id }}" onchange="getInputValue(this)" class="mx-5 field-checbox">
                            <input type="hidden" name="field_id[]" value="{{ $items->field_id }}">
                            <label for="basic{{ $items->field_id }}" role="button"> {{ $items->field_name }} </label>
                        </div>
                        <div class="w-50">
                            <input type="text" class="form-control field-input" id="basic{{ $items->field_id }}_input" value="{{ $items->percentage }}" name="percentage[]"
                                id="" required>
                        </div>
                    </div>
                </li>
                @endforeach
            @endisset

        </ul>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="fv-row form-group mb-10 d-flex">
                <div class="form-group mb-10 ">
                    <label class="form-label" for="">
                        Status
                    </label>
                    <div class="mt-3">
                        <input type="radio" id="active" class="form-check-input" value="active" name="status"
                            @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                        <label class="pe-3" for="active">Active</label>
                        <input type="radio" id="inactive" class="form-check-input" value="inactive" name="status"
                            @if (isset($info->status) && $info->status != 'active') checked @endif>
                        <label for="inactive">Inactive</label>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-10">
                <label class="form-label" for="">
                    Order in the Salary slip
                </label>
                <div>
                    <input type="text" name="order_in_salary_slip" value="{{ $info->order_in_salary_slip ?? '' }}" id="order_in_salary_slip" class="form-control">
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group mb-10 text-end">
        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
        <button type="button" class="btn btn-primary" id="form-submit-btn">
            <span class="indicator-label">
                Submit
            </span>
        </button>
    </div>
</form>

<script>
    $(".number_only").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    function getHeadFields(head_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('salary-field.head.fields') }}",
            type: 'POST',
            data: {
                head_id: head_id,
            },
            success: function(res) {
                if (res) {
                    $('#calcuation-pane').addClass('d-none');
                    var html_content = '';
                    res.map((item) => {
                        html_content += `<li class="border border-2 p-2 field-item-pane">
                                            <div class="d-flex w-100">
                                                <div class="w-50 d-flex align-items-center">
                                                    <input type="checkbox" name="field_name[]" id="basic${item.id}" value="${item.id}" data-id="basic${item.id}" onchange="getInputValue(this)" class="mx-5 field-checbox">
                                                    <input type="hidden" name="field_id[]" value="${item.id}">
                                                    <label for="basic${item.id}" role="button"> ${item.name} </label>
                                                </div>
                                                <div class="w-50">
                                                    <input type="text" class="form-control field-input" id="basic${item.id}_input" value="" name="percentage[]"
                                                        id="" disabled required>
                                                </div>
                                            </div>
                                        </li>`;
                    })
                    $('#field-item-pane').html(html_content);
                }
            }
        })
    }

    function getInputValue(en) {
        
        let types = $(en).data('id');
        if (en.checked) {

            $('#' + types + '_input').attr('disabled', false);

        } else {

            $('#' + types + '_input').attr('disabled', true).prop('checked', false);

        }
    }

    function getEntryType(value) {
        var salary_head_id = $('#salary_head_id').val();
        if (salary_head_id == '') {
            toastr.error('Please select salary head');
            $(value).attr('checked', false);
            $('#salary_head_id').focus();
            return false;
        }
        if (value.value == 'manual') {
            $('#entry_type_pane').removeClass('d-none');
            $('#calcuation-pane').addClass('d-none');

        } else if(value.value == 'inbuilt_calculation') {

            $('#calcuation-pane').addClass('d-none');
            $('#entry_type_pane').addClass('d-none');

        } else {
            $('#entry_type_pane').addClass('d-none');
            $('#calcuation-pane').removeClass('d-none');
        }
    }
    var KTAppEcommerceSaveSalaryField = function() {
        const form = document.querySelector('#dynamic_form');

        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'salary_head_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Salary Head is required'
                                },
                            }
                        },
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'Salary Field Name is required'
                                },
                            }
                        },
                        'short_name':{
                            validators: {
                                notEmpty: {
                                    message: 'Salary Field Short Name is required'
                                },
                            }
                        }

                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Handle submit button
            submitButton.addEventListener('click', e => {
                e.preventDefault();
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {
                            submitButton.disabled = true;
                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('save.salary-field') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    // Disable submit button whilst loading
                                    submitButton.disabled = false;

                                    if (res.error == 1) {
                                        if (res.message) {
                                            res.message.forEach(element => {
                                                toastr.error("Error",
                                                    element);
                                            });
                                        }
                                    } else {
                                        toastr.success(
                                            "Salary field Status added successfully"
                                        );
                                        $('#kt_dynamic_app').modal('hide');
                                        dtTable.draw();
                                    }
                                }
                            })

                        }
                    });
                }
            })
        }

        // Select all handler
        const handleSelectAll = () => {
            // Define variables
            var defaultDisable = form.querySelectorAll('.field-checbox');


            defaultDisable.forEach(en => {

                en.addEventListener('change', e => {

                    console.log($(en));
                    let types = $(en).data('id');
                    if (en.checked) {

                        $('#' + types + '_input').attr('disabled', false);

                    } else {

                        $('#' + types + '_input').attr('disabled', true).prop('checked', false);

                    }
                });
            })



        }

        return {
            init: function() {
                handleSubmit();
                handleSelectAll();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTAppEcommerceSaveSalaryField.init();
    });
</script>
