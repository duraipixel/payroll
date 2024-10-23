<form action="" class="" id="dynamic_form">
    <style>
        #multi_field+.select2.select2-container {
            width: 100% !important;
        }
    </style>
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <div class="fv-row mb-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group ">
                    <label class="form-label required" for="">
                        Salary Heads
                    </label>
                    <div>
                        <select name="salary_head_id" id="salary_head_id" onchange="return getHeadFields(this.value)"
                            class="form-control">
                            <option value="">-select salary head-</option>
                            @isset($heads)
                                @foreach ($heads as $item)
                                    <option value="{{ $item->id }}" @if (isset($info->salary_head_id) && $info->salary_head_id == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label required" for="">
                        Nature of Employee
                    </label>
                    <div>
                        <select name="nature_id" id="nature_id" class="form-control"
                            onchange="return getHeadFields(this.value)">
                            <option value="">-select-</option>
                            @isset($nature)
                                @foreach ($nature as $item)
                                    <option value="{{ $item->id }}" @if (isset($info->nature_id) && $info->nature_id == $item->id) selected @endif>
                                        {{ $item->name }}</option>
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
                        <input type="text" class="form-control" name="name" value="{{ $info->name ?? '' }}"
                            id="name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="form-group">
                    <label class="form-label required" for="">
                        Salary Field Short Name
                    </label>
                    <div>
                        <input type="text" class="form-control" name="short_name"
                            value="{{ $info->short_name ?? '' }}" id="short_name" required>
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
                    <input type="radio" id="inbuilt_calculation" onchange="return getEntryType(this)"
                        class="form-check-input" value="inbuilt_calculation" name="entry_type"
                        @if (isset($info->entry_type) && $info->entry_type == 'inbuilt_calculation') checked @endif>
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

    <div class="fv-row form-group mb-10  @if (isset($info->entry_type) && $info->entry_type == 'manual') d-none @elseif(!isset($info->entry_type)) d-none @endif"
        id="calcuation-pane">
        <h4>Select Fields with Percentage</h4>
        <div class="row" id="field-item-pane">
            <div class="col-sm-6">
                <select name="multi_field[]" id="multi_field" class="form-control" multiple>
                    @if (isset($fields) && !empty($fields) && count($fields) > 0)
                        @php
                            $selected_id = $info->field_items->multi_field_id ?? '';
                            $selected_id = explode(',', $selected_id);
                        @endphp
                        @foreach ($fields as $item)
                            <option value="{{ $item->id }}" @if (isset($selected_id) && in_array($item->id, $selected_id)) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-6">
                <div class="w-100">
                    <input type="text" class="form-control field-input numberonly" id="basic_input"
                        value="{{ $info->field_items->percentage ?? '' }}" placeholder="Percentage %" name="percentage"
                        id="" readonly>
                </div>
            </div>
        </div>
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
                        <input type="radio" id="inactive" class="form-check-input" value="inactive"
                            name="status" @if (isset($info->status) && $info->status != 'active') checked @endif>
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
                    <input type="text" name="order_in_salary_slip"
                        value="{{ $info->order_in_salary_slip ?? '' }}" id="order_in_salary_slip"
                        class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="fv-row form-group mb-10  @if (isset($info->entry_type) && $info->entry_type == 'manual') d-none @elseif(!isset($info->entry_type)) d-none @endif"
        id="calcuation-pane">
       
        <div class="row" id="field-item-pane">
     
            <div class="col-sm-6">
            <h5>Change Percentage</h5>
            <input type="hidden" class="form-control field-input" id="basic_input"
                        value="{{ $info->field_items->percentage ?? '' }}" placeholder="Percentage %" name="initial_percentage"
                        id="" required>
            <input type="text" class="form-control field-input numberonly" id="basic_input"
                        value="{{ $info->field_items->percentage ?? '' }}" placeholder="Percentage %" name="changed_percentage"
                        id="" required>
            </div>
            
            <div class="col-sm-6">
            <h5>Effective From</h5>
                <div class="w-100">
                    <input type="date" class="form-control field-input" id="date"
                        value="{{ $info->field_items->effective_from ?? '' }}" placeholder="Percentage %" name="effective_from"
                        id="" required>
                </div>
            </div>
    </div>
    <br>
    <div class="row" id="field-item-pane">
    <div class="col-sm-6">
    <h5> Payout Month </h5>
          <div class="w-100">
            <select name="payout_month" id="payout_month" class="form-control" required>
              <option value="">-select-</option>
              @if (isset($payout_year) && !empty($payout_year))
              @foreach ($payout_year as $item)
              <option value="{{ $item }}"> {{ date('F Y', strtotime($item)) }}
              </option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-sm-6">
        <h5> Remarks </h5>
          <div class="w-100">
          <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="3"
          placeholder="Remarks"></textarea>
          </div>
        </div>
    </div>
    <br>
   
   
   
    @if(isset($info->Fieldlogs) && count($info->Fieldlogs)>0)
    <hr>
    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Initial Percentage</th>
      <th scope="col">Changed Percentag</th>
      <th scope="col">Effective From</th>
      <th scope="col">Payout Month</th>
      <th scope="col">Remarks</th>
    </tr>
  </thead>
  <tbody>
  @foreach($info->Fieldlogs as $key=>$log)
    <tr>
      <th scope="row">{{$key+1}}</th>
      <td>{{$log->initial_percentage }}</td>
      <td>{{$log->new_percentage }}</td>
      <td>{{date('d-m-Y',strtotime($log->effective_from)) }}</td>
      <td>{{$log->payout_month }}</td>
      <td>{{$log->remarks }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
@endif
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

    $('#multi_field').select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#kt_dynamic_app")
    });

    function getHeadFields(head_id) {
        $('input[name=entry_type]').attr('checked', false);
        let nature_id = $('#nature_id').val();
        let salary_head_id = $('#salary_head_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('salary-field.head.fields') }}",
            type: 'POST',
            data: {
                head_id: salary_head_id,
                nature_id: nature_id
            },
            success: function(res) {
                if (res) {
                    $('#calcuation-pane').addClass('d-none');
                    var html_content = '';
                    res.map((item) => {
                        html_content += `<option value="${item.id}">${item.name}</option>`;
                    })
                    $('#multi_field').html(html_content);
                }
            }
        })
    }

    function getInputValue(en) {

        let types = $(en).data('id');
        if (en.checked) {

            $(`#${types}_input`).attr('disabled', false);
            if (types.toLowerCase() == 'epf') {
                /*
                get pf amount based on nature of employement
                */
                let staff_id = $('#staff_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('salary.get.epf.amount') }}",
                    type: 'POST',
                    data: {
                        staff_id: staff_id,
                        types: types
                    },
                    beforeSend: function() {
                        /* 
                        do loader here  if needed 
                        */
                    },
                    success: function(res) {
                        epf_values = res.field_name;
                        let epf_value_arr = epf_values.split(",");
                        let total = 0;
                        epf_value_arr.map((item) => {
                            let sum = $('#' + item + '_input').val() || 0;
                            total += parseFloat(sum);
                        });
                        let percentage = res.percentage || 0;
                        let final_epf = (percentage / 100) * parseFloat(total);
                        final_epf = Math.round(final_epf);
                        $('#' + types + '_input').val(final_epf);

                        doAmountCalculation();
                    }
                });
            } else if (types.toLowerCase() == 'esi') {
                /*
                get esi amount based on nature of employement
                */
                var esi_amount_gross = 0;
                var add_input = document.querySelectorAll('.add_input');
                add_input.forEach(element => {

                    if (!$(element).is(':disabled')) {

                        if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() !=
                            null) {
                            esi_amount_gross += parseFloat($(element).val());
                        }
                    }
                });

                let total = esi_amount_gross;
                if (total > 21000) {
                    toastr.error('Error', 'Esi amount not eligible for greater than 21000');
                    $(`#${types}_input`).attr('disabled', false);
                    $('#' + types + '_input').val(0);
                    $(en).attr('checked', false);
                } else {

                    let percentage = 0.75; //for esi percentage
                    let esi = (percentage / 100) * parseFloat(total);
                    esi = Math.round(esi);
                    $('#' + types + '_input').val(esi);

                    doAmountCalculation();
                }
            }

        } else {

            $('#' + types + '_input').attr('disabled', true).prop('checked', false);

        }
        doAmountCalculation();
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

        } else if (value.value == 'inbuilt_calculation') {

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
                        'nature_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Employee Nature is required'
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
                        'short_name': {
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
