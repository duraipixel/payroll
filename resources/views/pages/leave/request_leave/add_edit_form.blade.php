<div class="modal-dialog modal-xl modal-dialog-centered mw-1000px">
    <style>
        .typeahead-pane {
            position: absolute;
            width: 100%;
            background: #ffffff;
            margin: 0;
            padding: 0;
            border-radius: 6px;
            box-shadow: 1px 2px 3px 2px #ddd;
            z-index: 1;
        }

        .typeahead-pane-ul {
            width: 100%;
            padding: 0;
        }

        .typeahead-pane-li {
            padding: 8px 15px;
            width: 100%;
            margin: 0;
            border-bottom: 1px solid #2e3d4638;

        }

        .typeahead-pane-li:hover {
            background: #3a81bf;
            color: white;
            cursor: pointer;
        }

        #input-close {
            position: absolute;
            top: 11px;
            right: 15px;
        }

        .daterangepicker.show-calendar .ranges {
            height: 0;
        }

        #leave_table_staff th,
        #nature_table_staff th {
            padding: 5px;
        }

        #leave_table_staff td,
        #nature_table_staff td {
            padding: 5px;
        }
    </style>
    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                {!! cancelSvg() !!}
            </div>
        </div>

        <div class="modal-body " id="dynamic_content">
            {{-- {{ dump($info->staff_info) }} --}}
            <form action="" class="p-3" id="leave_form" autocomplete="off" enctype="multipart/form-data">
                <div class="fv-row form-group mb-3 row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-5 mb-3">
                                <label class="form-label required mt-3" for="">
                                    Leave Category
                                </label>
                            </div>
                            <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
                            <div class="col-sm-7">
                                <select name="leave_category_id" id="leave_category_id" class="form-control">
                                    <option value="">-select-</option>
                                    @isset($leave_category)
                                        @foreach ($leave_category as $citem)
                                            <option value="{{ $citem->id }}"
                                                @if (isset($info->leave_category_id) && $info->leave_category_id == $citem->id) selected @endif>{{ $citem->name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">
                                    Dates requested
                                </label>
                            </div>
                            <div class="col-sm-7">
                                @if( isset( $info->from_date ) && !empty( $info->from_date ) )
                                <input type="hidden" name="requested_date" id="requested_date"
                                    value="{{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }}"
                                    class="form-control">
                                    <label for="" class="mt-3"> {{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }} </label>
                                @else 
                                <input type="text" name="requested_date" id="requested_date"
                                    value="{{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }}"
                                    class="form-control">
                                @endif
                                
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">No.of.Days requested </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" readonly name="no_of_days" id="no_of_days"
                                    value="{{ $info->no_of_days ?? '' }}" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row d-none" id="el_eol_form">
                            <div class="col-sm-5">
                                <label class="form-label" for="">
                                    Sundays and holidays, if any, proposed to be prefixed/suffixed to leave
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="holiday_date" id="holiday_date"
                                    value="{{ isset($info->holiday_date) ? date('Y-m-d', strtotime($info->holiday_date)) : '' }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required" for="">
                                    Reason for Leave
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <textarea name="reason" id="reason" cols="30" rows="2" class="form-control">{{ $info->reason ?? '' }}</textarea>
                            </div>
                        </div>
                        <div id="leave-form-content">
                            @if (isset($info->address) && !empty($info->address))
                                @include('pages.leave.request_leave.el_form')
                            @endif
                        </div>
                        @if (isset($info) && !empty($info))
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6 class="fs-6 mt-3 alert alert-danger">Total Leave Taken - {{ count($taken_leave) }} </h6>
                                    @if( isset( $taken_leave ) && count( $taken_leave ) > 0 )
                                    <div class="table-wrap table-responsive " style="max-height: 400px;">
                                        <table id="leave_table_staff" class="table table-hover table-bordered">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>
                                                        Date
                                                    </th>
                                                    <th>
                                                        Type
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($taken_leave as $item)
                                                <tr>
                                                    <td>
                                                        {{ commonDateFormat($item->from_date) .' - '. commonDateFormat($item->to_date) }}
                                                    </td>
                                                    <td>
                                                        {{ $item->leave_category }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-4">
                                    <label class="mt-3 alert alert-info small"> Leave Allocated </label>
                                    <div class="table-wrap table-responsive " style="max-height: 400px;">
                                        <table id="nature_table_staff" class="table table-hover table-bordered">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Allocated</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($info->staff_info->appointment->leaveAllocated) && count($info->staff_info->appointment->leaveAllocated) > 0)
                                                    @foreach ($info->staff_info->appointment->leaveAllocated as $item)
                                                        <tr>
                                                            <td>
                                                                {{ $item->leave_head->name ?? '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $item->leave_days ?? 0 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-sm-6">
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">
                                    Name of the Staff
                                </label>
                            </div>
                            <div class="col-sm-7 position-relative" id="typeahed-click">
                                <input type="text" name="staff_name" value="{{ $info->staff_info->name ?? '' }}"
                                    id="staff_name" class="form-control">
                                <span id="input-close" class="d-none">
                                    {!! cancelSvg() !!}
                                </span>
                                <input type="hidden" name="staff_id" id="staff_id"
                                    value="{{ $info->staff_id ?? '' }}">
                                <div class="typeahead-pane d-none" id="typeadd-panel">
                                    <ul type="none" class="typeahead-pane-ul" id="typeahead-list">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">
                                    Staff ID
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="staff_code"
                                    value="{{ $info->staff_info->emp_code ?? '' }}" readonly id="staff_code"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">
                                    Designation
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="designation" value="{{ $info->designation ?? '' }}"
                                    readonly id="designation" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label " for="">
                                    Reporting Manager
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="reporting_id" id="reporting_id" class="form-control"
                                    readonly value="{{ $info->reporting_info->name ?? '' }}">
                            </div>
                        </div>
                        @if (isset($info) && !empty($info))
                            <div class="fv-row form-group mb-3 row">
                                <div class="col-sm-5">
                                    <label class="form-label required" for="">
                                        Leave Granted
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="radio" name="leave_granted" id="leave_granted_yes"
                                        value="yes">
                                    <label for="leave_granted_yes" role="button"> Yes </label> &emsp;
                                    <input type="radio" name="leave_granted" id="leave_granted_no" value="no">
                                    <label for="leave_granted_no" role="button"> No </label>
                                </div>
                            </div>
                            <div class="fv-row form-group mb-3 row">
                                <div class="col-sm-5">
                                    <label class="form-label required mt-3" for="">
                                        No of Days Granted
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="number" min="1" max="15" name="no_of_days_granted"
                                        id="no_of_days_granted" class="form-control"
                                        value="{{ $info->no_of_days ?? '' }}" required>
                                </div>
                            </div>
                            <div class="fv-row form-group mb-3 row">
                                <div class="col-sm-5">
                                    <label class="form-label required mt-3" for="">
                                        Upload Application
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" name="application_file" id="application_file"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="fv-row form-group mb-3 row">
                                <div class="col-sm-5">
                                    <label class="form-label " for="">
                                        Remarks
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="form-group mt-7 text-end">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
                    <button type="button" class="btn btn-primary" id="form-submit-btn">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('#leave_category_id').change(function() {
        let leave_category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.leave.form') }}",
            type: 'POST',
            data: {
                leave_category_id: leave_category_id,
            },
            success: function(res) {
                if (res) {
                    $('#leave-form-content').html(res);
                } else {
                    $('#leave-form-content').html('');
                    $('#el_eol_form').addClass('d-none');
                }
            }
        })

    })
    window.addEventListener('click', function(e) {
        if (document.getElementById('typeahed-click').contains(e.target)) {
            // Clicked in box
        } else {
            // Clicked outside the box
            $('#typeadd-panel').addClass('d-none');
            // $('#staff_name').val('');
            // $('#staff_id').val('');
            // $('#staff_code').val('');
            // $('#designation').val('');
        }
    });

    var staff_name = document.getElementById('staff_name');

    staff_name.addEventListener('keyup', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.staff') }}",
            type: 'POST',
            data: {
                query: this.value,
            },
            success: function(res) {
                console.log(res);
                if (res && res.length > 0) {
                    $('#typeadd-panel').removeClass('d-none');
                    let panel = '';
                    res.map((item) => {
                        panel +=
                            `<li class="typeahead-pane-li" onclick="return getStaffLeaveInfo(${item.id})">${item.name} - ${item.emp_code}</li>`;
                    })
                    $('#typeahead-list').html(panel);

                } else {
                    $('#typeadd-panel').addClass('d-none');

                }
            }
        })
    })

    function getStaffLeaveInfo(staff_id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.staff.leave.info') }}",
            type: 'POST',
            data: {
                staff_id: staff_id,
            },
            success: function(res) {

                if (res.data) {
                    $('#staff_code').val(res.data.emp_code);
                    $('#designation').val(res.data?.position?.designation?.name);
                    $('#staff_id').val(res.data.id);
                    $('#staff_name').val(res.data.name);
                    $('#typeadd-panel').addClass('d-none');
                    $('#staff_name').attr('disabled', true);
                    $('#input-close').removeClass('d-none');
                    $('#reporting_id').val(res.data?.reporting?.name);
                }
            }
        })
    }
    $('#input-close').click(function() {

        $('#staff_code').val('');
        $('#designation').val('');
        $('#staff_id').val('');
        $('#staff_name').val('');
        $('#typeadd-panel').removeClass('d-none');
        $('#staff_name').attr('disabled', false);
        $('#input-close').addClass('d-none');
        $('#reporting_id').val('');
    })

    function datediff(first, second) {
        return Math.round((second - first) / (1000 * 60 * 60 * 24));
    }

    function parseDate(str) {
        var dmy = str.split('/');
        return new Date(dmy[2], dmy[1] - 1, dmy[0]);
    }

    $(function() {

        $('input[name="requested_date"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="requested_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                'DD/MM/YYYY'));

            let start_date = picker.startDate.format('DD/MM/YYYY');
            let end_date = picker.endDate.format('DD/MM/YYYY');

            let requested_days = datediff(parseDate(start_date), parseDate(end_date));
            $('#no_of_days').val(requested_days + 1);

        });

        $('input[name="requested_date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input[name="holiday_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="holiday_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        $('input[name="holiday_date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


    });
    var KTAppEcommerceSaveBranch = function() {

        const handleSubmit = () => {

            let validator;

            const form = document.getElementById('leave_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'leave_category_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Leave Category is required'
                                },
                            }
                        },
                        'staff_name': {
                            validators: {
                                notEmpty: {
                                    message: 'Staff Name is required'
                                },
                            }
                        },
                        'staff_code': {
                            validators: {
                                notEmpty: {
                                    message: 'Staff ID is required'
                                },
                            }
                        },
                        'designation': {
                            validators: {
                                notEmpty: {
                                    message: 'Designation is required'
                                },
                            }
                        },
                        'requested_date': {
                            validators: {
                                notEmpty: {
                                    message: 'Request Date is required'
                                },
                            }
                        },
                        'reason': {
                            validators: {
                                notEmpty: {
                                    message: 'Reason is required'
                                },
                            }
                        },
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
                            var forms = $('#leave_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('save.leaves') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    // Disable submit button whilst loading
                                    submitButton.disabled = false;
                                    submitButton.removeAttribute(
                                        'data-kt-indicator');
                                    if (res.error == 1) {
                                        if (res.message) {
                                            res.message.forEach(element => {
                                                toastr.error("Error",
                                                    element);
                                            });
                                        }
                                    } else {
                                        toastr.success(
                                            "Leave Request added successfully");
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

        return {
            init: function() {
                handleSubmit();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTAppEcommerceSaveBranch.init();
    });
</script>
