<div class="modal-dialog modal-dialog-centered mw-1000px">
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
    </style>
    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                {!! cancelSvg() !!}
            </div>
        </div>

        <div class="modal-body " id="dynamic_content">

            <form action="" class="p-3" id="leave_form" autocomplete="off">
                <div class="fv-row form-group mb-3 row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-5 mb-3">
                                <label class="form-label required mt-3" for="">
                                    Leave Category
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <select name="leave_category_id" id="leave_category_id" class="form-control">
                                    <option value="">-select-</option>
                                    @isset($leave_category)
                                        @foreach ($leave_category as $citem)
                                            <option value="{{ $citem->id }}">{{ $citem->name }}</option>
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
                                <input type="text" name="requested_date" id="requested_date" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">No.of.Days requested </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" readonly name="no_of_days" id="no_of_days" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row d-none" id="el_eol_form">
                            <div class="col-sm-5">
                                <label class="form-label" for="">
                                    Sundays and holidays, if any, proposed to be prefixed/suffixed to leave
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="holiday_date" id="holiday_date" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required" for="">
                                    Reason for Leave
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <textarea name="reason" id="reason" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div id="leave-form-content">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">
                                    Name of the Staff
                                </label>
                            </div>
                            <div class="col-sm-7 position-relative" id="typeahed-click">
                                <input type="text" name="staff_name" id="staff_name" class="form-control">
                                <span id="input-close" class="d-none">
                                    {!! cancelSvg() !!}
                                </span>
                                <input type="hidden" name="staff_id" id="staff_id" value="">
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
                                <input type="text" name="staff_code" readonly id="staff_code" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label required mt-3" for="">
                                    Designation
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="designation" readonly id="designation" class="form-control">
                            </div>
                        </div>
                        <div class="fv-row form-group mb-3 row">
                            <div class="col-sm-5">
                                <label class="form-label " for="">
                                    Reporting Manager
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="reporting_id" id="reporting_id" class="form-control" readonly>
                            </div>
                        </div>
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
                                        toastr.success("Leave Request added successfully");
                                        $('#kt_dynamic_app').modal('hide');
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
