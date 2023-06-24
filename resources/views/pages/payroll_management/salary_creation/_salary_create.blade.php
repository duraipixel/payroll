<hr>
<form id="update_new_revision">
    @csrf
    <input type="hidden" name="staff_id" value="{{ $staff_id }}">
    <div class="row mt-3">
        @if ($message)
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            </div>
        @else
            <div class="col-sm-12 m-auto">

                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="row">

                        @isset($earnings_data)
                            <div class="col-sm-6">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            Earnings
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <div class="list-group">

                                                @foreach ($earnings_data as $item_fields)
                                                    @if (isset($salary_info) && !empty($salary_info))
                                                        @php
                                                            $old_data = getSalarySelectedFields($salary_info->staff_id, $salary_info->id, $item_fields->id);
                                                        @endphp
                                                    @endif
                                                    <label class="list-group-item p-3 d-flex justify-content-between">
                                                        <input class="form-check-input me-1" type="checkbox"
                                                            data-id="{{ str_replace(' ', '_', $item_fields->short_name) }}"
                                                            onchange="getInputValue(this)" value=""
                                                            @if (isset($old_data) && !empty($old_data)) checked @endif>
                                                        <span class="px-3 w-50"> {{ $item_fields->name }}
                                                            ({{ $item_fields->short_name }})
                                                            <div class="text-muted small">

                                                                @if (isset($item_fields->field_items) && !empty($item_fields->field_items))
                                                                    [

                                                                    {{ $item_fields->field_items->field_name }}*{{ $item_fields->field_items->percentage }}%
                                                                    ]
                                                                @endif
                                                            </div>
                                                            @if ($item_fields->short_name == 'LIC' || strtolower($item_fields->short_name) == 'bank loan')
                                                                <i class="fa fa-exclamation-circle loans_info"
                                                                    role="button"
                                                                    data-id="{{ $item_fields->short_name }}"></i>
                                                            @endif
                                                        </span>
                                                        <input type="text" name="amount_{{ $item_fields->id }}"
                                                            onkeyup="getNetSalary(this.value, '{{ $item_fields->id }}', '{{ $item_fields->short_name }}')"
                                                            id="{{ str_replace(' ', '_', $item_fields->short_name) }}_input"
                                                            value="{{ $old_data->amount ?? '' }}"
                                                            @if ($item_fields->no_of_numerals) maxlength="{{ $item_fields->no_of_numerals }}" @endif
                                                            class="border border-2 float-end text-end price add_input @if (isset($item_fields->field_items) && !empty($item_fields->field_items)) automatic_calculation @endif"
                                                            data-id=""
                                                            @if (isset($old_data) && !empty($old_data)) @else disabled @endif>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endisset
                        @isset($deduction_data)
                            <div class="col-sm-6">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            Deductions
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <div class="list-group">

                                                @foreach ($deduction_data as $item_fields)
                                                    @if (isset($salary_info) && !empty($salary_info))
                                                        @php
                                                            $old_data = getSalarySelectedFields($salary_info->staff_id, $salary_info->id, $item_fields->id);
                                                        @endphp
                                                    @endif
                                                    <label class="list-group-item p-3 d-flex justify-content-between">
                                                        <input class="form-check-input me-1" type="checkbox"
                                                            data-id="{{ str_replace(' ', '_', $item_fields->short_name) }}"
                                                            onchange="getInputValue(this)" value=""
                                                            @if (isset($old_data) && !empty($old_data)) checked @endif>
                                                        <span class="px-3 w-50"> {{ $item_fields->name }}
                                                            ({{ $item_fields->short_name }})
                                                            <div class="text-muted small">

                                                                @if (isset($item_fields->field_items) && !empty($item_fields->field_items))
                                                                    [

                                                                    {{ $item_fields->field_items->field_name }}*{{ $item_fields->field_items->percentage }}%
                                                                    ]
                                                                @endif
                                                            </div>
                                                            @if ($item_fields->short_name == 'LIC' || strtolower($item_fields->short_name) == 'bank loan')
                                                                <i class="fa fa-exclamation-circle loans_info"
                                                                    role="button"
                                                                    data-id="{{ $item_fields->short_name }}"></i>
                                                            @endif
                                                        </span>
                                                        <input type="text" name="amount_{{ $item_fields->id }}"
                                                            onkeyup="getNetSalary(this.value, '{{ $item_fields->id }}', '{{ $item_fields->short_name }}')"
                                                            id="{{ str_replace(' ', '_', $item_fields->short_name) }}_input"
                                                            value="{{ $old_data->amount ?? '' }}"
                                                            @if ($item_fields->no_of_numerals) maxlength="{{ $item_fields->no_of_numerals }}" @endif
                                                            class="border border-2 float-end text-end price minus_input @if (isset($item_fields->field_items) && !empty($item_fields->field_items)) automatic_calculation @endif"
                                                            data-id=""
                                                            @if (isset($old_data) && !empty($old_data)) @else disabled @endif>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endisset
                        <div class="col-sm-12">

                            <h2 class="accordion-header netsalary" id="panelsStayOpen-headingOne">

                                Net Salary
                                <span class="float-end">₹
                                    <input type="text" class="w-200px text-end h-25px" name="net_salary"
                                        id="net_salary" value="">
                                    {{-- <span id="net_salary_text">
                                    {{ $salary_info->net_salary ?? '0.00' }}
                                </span> --}}
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4 px-10">

                            <div class="form-group">
                                <label for="" class="fs-5 required"> Effective From </label>
                                <div class="mt-3">
                                    <input type="date" name="effective_from" id="effective_from" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="form-group mt-5">
                                <label for="" class="fs-5"> Employee Remarks </label>
                                <div class="mt-3">
                                    <textarea name="employee_remarks" class="form-control" id="employee_remarks" cols="30" rows="3"
                                        placeholder="This will be visible to employee"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-4 px-10">
                            <div class="form-group">
                                <label for="" class="fs-5 required"> Payout Month </label>
                                <div class="mt-3">
                                    <select name="payout_month" id="payout_month" class="form-control" required>
                                        <option value="">-select-</option>
                                        @if (isset($payout_year) && !empty($payout_year))
                                            @foreach ($payout_year as $item)
                                                <option value="{{ $item }}">
                                                    {{ date('F Y', strtotime($item)) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-5 text-end">
                        <button class="btn btn-primary btn-sm" id="submit_button" type="button" onclick="return addRevisionFormSubmit()"> Submit & Lock </button>
                        <a class="btn btn-dark btn-sm"
                            href="@if (isset($staff_id) && !empty($staff_id)) {{ route('staff.register', ['id' => $staff_id]) }} @else {{ route('salary.creation') }} @endif">
                            Cancel </a>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {

                        $(document).on('mouseenter', '.loans_info', function(event) {
                            var staff_id = $('#staff_id').val();
                            var data_id = $(this).data('id');
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "{{ route('show.loans.info') }}",
                                type: 'POST',
                                data: {
                                    staff_id: staff_id,
                                    data_id: data_id
                                },
                                beforeSend: function() {

                                },
                                success: function(res) {
                                    $('#kt_dynamic_app').modal('show');
                                    $('#kt_dynamic_app').html(res);
                                }
                            });

                        }).on('mouseleave', '.loans_info', function() {
                            console.log('outside');
                        });
                    })

                    function addRevisionFormSubmit() {

                        var form = document.getElementById('update_new_revision');
                        const submitButton = document.getElementById('submit_button');

                        event.preventDefault();
                        var revision_form_error = false;

                        var key_name = [
                            'effective_from',
                            'payout_month',
                            'net_salary',
                        ];

                        $('.revision-form-errors').remove();
                        $('.form-control,.form-select').removeClass('border-danger');

                        const pattern = /_/gi;
                        const replacement = " ";

                        key_name.forEach(element => {
                            var name_input = document.getElementById(element).value;

                            if (name_input == '' || name_input == undefined) {

                                revision_form_error = true;
                                var elementValues = element.replace(pattern, replacement);
                                var name_input_error =
                                    '<div class="fv-plugins-message-container revision-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                                    elementValues.toUpperCase() + ' is required</div></div>';
                                $('#' + element).after(name_input_error);
                                $('#' + element).addClass('border-danger')
                                $('#' + element).focus();
                            }
                        });

                        // Validate form before submit

                        if (!revision_form_error) {
                            submitButton.disabled = true;
                            let staff_id = $('#staff_id').val();
                            var forms = $('#update_new_revision')[0];
                            var formData = new FormData(forms);
                            formData.append('staff_id', staff_id);

                            $.ajax({
                                url: "{{ route('salary.creation_add') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {

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
                                            "Salary revision updated successfully"
                                        );

                                        getSalaryHeadFields(staff_id);

                                    }
                                }
                            })

                        }

                    }
                </script>
            </div>
        @endif
    </div>
</form>
