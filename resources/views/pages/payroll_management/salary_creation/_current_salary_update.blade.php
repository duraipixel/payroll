<div class="payheads-pane p-3 border border-2">
    <form id="update_new_revision">
        @csrf
        <input type="hidden" name="from" value="ajax_revision">
        <input type="hidden" name="id" value="{{ $current_pattern->id }}">
        <div class="d-flex w-100 m-2 p-2 bg-primary text-white">
            <div class="w-30">
                Salary Heads
            </div>
            <div class="w-35 text-end">
                Current Pay
            </div>
            <div class="w-35 text-end">
                Revision Pay
            </div>
        </div>
        <div class="d-flex w-100 m-2 p-2 bg-secondary text-muted">
            <div class="w-100">
                Earnings
            </div>
        </div>
        @if (isset($earnings_data) && count($earnings_data) > 0)
            @foreach ($earnings_data as $item)
                <div class="d-flex w-100 m-2 p-2 payrow">
                    <div class="w-30 d-flex">
                        <div class="me-2">

                            <input class="form-check-input me-1" type="checkbox"
                                data-id="{{ str_replace(' ', '_', $item->short_name) }}" onchange="getInputValue(this)"
                                value="" @if (isset($old_data) && !empty($old_data)) checked @endif>
                        </div>
                        <div>

                            {{ $item->name ?? '' }}
                            <div class="text-muted small">

                                @if (isset($item->field_items) && !empty($item->field_items))
                                    [

                                    {{ $item->field_items->field_name }}*{{ $item->field_items->percentage }}%
                                    ]
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="w-35 text-end">
                        <label for=""
                            class="">{{ previousSalaryData($current_pattern->id, $item->id)->amount ?? '0.00' }}</label>
                    </div>
                    <div class="w-35 text-end">
                        <input type="text" name="amount_{{ $item->id }}"
                            id="{{ str_replace(' ', '_', $item->short_name) }}_input"
                            onkeyup="getNetSalary(this.value, '{{ $item->id }}', '{{ $item->short_name }}')"
                            @if ($item->no_of_numerals) maxlength="{{ $item->no_of_numerals }}" @endif
                            class="add_input form-control form-control-sm w-200px float-end text-end" disabled>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="d-flex w-100 m-2 p-2 bg-secondary text-muted">
            <div class="w-100">
                Deductions
            </div>
        </div>
        @if (isset($deduction_data) && count($deduction_data) > 0)
            @foreach ($deduction_data as $item)
                <div class="d-flex w-100 m-2 p-2 payrow">
                    <div class="w-30 d-flex">
                        <div class="me-2">

                            <input class="form-check-input me-1" type="checkbox"
                                data-id="{{ str_replace(' ', '_', $item->short_name) }}" onchange="getInputValue(this)"
                                value="" @if (isset($old_data) && !empty($old_data)) checked @endif>
                        </div>
                        <div>

                            {{ $item->name ?? '' }}
                            <div class="text-muted small">

                                @if (isset($item->field_items) && !empty($item->field_items))
                                    [

                                    {{ $item->field_items->field_name }}*{{ $item->field_items->percentage }}%
                                    ]
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="w-35 text-end">
                        <label for=""
                            class="">{{ previousSalaryData($current_pattern->id, $item->id)->amount ?? '0.00' }}</label>
                    </div>
                    <div class="w-35 text-end">
                        <input type="text" name="amount_{{ $item->id }}"
                            id="{{ str_replace(' ', '_', $item->short_name) }}_input"
                            onkeyup="getNetSalary(this.value, '{{ $item->id }}', '{{ $item->short_name }}')"
                            @if ($item->no_of_numerals) maxlength="{{ $item->no_of_numerals }}" @endif
                            class="minus_input form-control form-control-sm w-200px float-end text-end" disabled>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="d-flex w-100 m-2 p-2 payrow">
            <div class="w-30">
                Net Salary
            </div>
            <div class="w-35 text-end">
                <label for="" class="fw-bold fs-5">{{ $current_pattern->net_salary }}</label>
            </div>
            <div class="w-35 text-end">
                <input type="text" class="form-control form-control-sm w-200px float-end text-end numberonly"
                    name="net_salary" id="net_salary" value="">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4 px-10">

                <div class="form-group">
                    <label for="" class="fs-5 required"> Effective From </label>
                    <div class="mt-3">
                        <input type="date" value="{{ $current_pattern->effective_from ?? '' }}"
                            name="effective_from" id="effective_from" class="form-control" required>
                    </div>
                </div>

                <div class="form-group mt-5">
                    <label for="" class="fs-5"> Employee Remarks </label>
                    <div class="mt-3">
                        <textarea name="employee_remarks" class="form-control" id="employee_remarks" cols="30" rows="3"
                            placeholder="This will be visible to employee">{{ $current_pattern->employee_remarks ?? '' }}</textarea>
                    </div>
                </div>
                

            </div>

            <div class="col-sm-4 px-10">
                <div class="form-group">
                    <label for="" class="fs-5 required"> Payout Month </label>
                    <div class="mt-3">
                        <input type="text" name="payout_month" id="payout_month" class="form-control"
                            value="{{ date('F Y', strtotime($current_pattern->payout_month)) }}" readonly>
                        {{-- <select name="payout_month" id="payout_month" class="form-control" required readonly>
                            <option value="">-select-</option>
                            @if (isset($payout_year) && !empty($payout_year))
                                @foreach ($payout_year as $item)
                                    <option value="{{ $item }}" @if (isset($current_pattern->payout_month) && $current_pattern->payout_month == $item) selected @endif> {{ date('F Y', strtotime($item)) }}
                                    </option>
                                @endforeach
                            @endif
                        </select> --}}
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label for="" class="fs-5"> Employer Remarks </label>
                    <div class="mt-3">
                        <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="3"
                            placeholder="This will be visible to employee">{{ $current_pattern->remarks ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-5 text-end">
            <button class="btn btn-primary btn-sm" type="button" id="submit_button"
                onclick="return updateRevisionFormSubmit()"> Save </button>
            <a class="btn btn-danger btn-sm" href="javascript:void(0)"
                onclick="return deleteRevision('{{ $current_pattern->id }}')">
                Delete Revision
            </a>
        </div>
    </form>
</div>
<script>
    function updateRevisionFormSubmit() {

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
                            toastr.error("Error", res.message);
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

    function deleteRevision(pattern_id) {

        Swal.fire({
            text: "Are you sure you would like to delete salary?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('salary.pattern.delete') }}",
                    type: 'POST',
                    data: {
                        id: pattern_id
                    },
                    success: function(res) {
                        if (res.error == 0) {
                            Swal.fire({
                                title: "Deleted!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });
                            getSalaryHeadFields(res.staff_id);
                        } else {
                            Swal.fire({
                                title: "Can not Delete!",
                                text: res.message,
                                icon: "warning",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, err) {
                        if (xhr.status == 403) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });
            }
        });
    }
</script>
