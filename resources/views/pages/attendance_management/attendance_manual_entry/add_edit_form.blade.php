<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <div class="row">
        <div class="col-sm-6">
            <div class="fv-row form-group mb-2">
                <label class="form-label required">Employee</label>
                <div class="position-relative">

                    <select name="employee_id" autofocus id="employee_id"
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Employee--</option>
                        @isset($employee_details)
                            @foreach ($employee_details as $item)
                                <option value="{{ $item->id }}" @if (isset($info->employment_id) && $info->employment_id == $item->id) selected @endif>
                                    {{ $item->name }} - {{ $item->institute_emp_code ?? '' }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <lable id="staff_err" class="staff_err" style="color:red">Please choose another Staff This Staff Already Resigned/Retired</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-2">
                <label class="form-label required">Attendance Date</label>
                <div class="position-relative">

                    <input type="date" class="form-control" name="attendance_date"
                        value="{{ $info->attendance_date ?? '' }}" id="attendance_date" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mt-7">

            <div class="fv-row form-group mb-10 mt-7">
                <label class="form-label" for="">
                    From Time
                </label>
                <div>
                    <input type="time" class="form-control" name="from_time" value="{{ $info->from_time ?? '' }}"
                        id="from_time">
                </div>
            </div>
        </div>
        <div class="col-sm-6  mt-7">
            <div class="fv-row form-group mb-10 mt-7">
                <label class="form-label" for="">
                    To Time
                </label>
                <div>
                    <input type="time" class="form-control" name="to_time" value="{{ $info->to_time ?? '' }}"
                        id="to_time" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-sm-6  ">
            <div class="fv-row form-group mb-10 ">
                <label class="form-label required" for="">
                    Reporting Manager
                </label>
                <div>
                    <select name="reporting_id" autofocus id="reporting_id"
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Reporting Manager--</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
            </div>
        </div> --}}
        <div class="col-sm-6">
            <div class="fv-row form-group mb-2">
                <label class="form-label required">Leave Status</label>
                <div class="position-relative">

                    <select name="leave_status_id" autofocus id="leave_status_id"
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Leave Status--</option>
                        @isset($leave_status)
                            @foreach ($leave_status as $item)
                                <option value="{{ $item->id }}" @if (isset($info->attendance_status) && $info->attendance_status == $item->name) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="fv-row form-group mb-10 mt-7">
                <label class="form-label required" for="">
                    Reason
                </label>
                <div>
                    <textarea class="form-control" id="reason" name="reason">{{ $info->reason ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-10 mt-7">
                <label class="form-label" for="">
                    Status
                </label>
                <div>
                    <input type="radio" id="active" class="form-check-input" value="active" name="status"
                        @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                    <label class="pe-3" for="active">Active</label>
                    <input type="radio" id="inactive" class="form-check-input" value="inactive" name="status"
                        @if (isset($info->status) && $info->status == 'inactive') checked @endif>
                    <label for="inactive">Inactive</label>
                </div>
            </div>
        </div>
        <div class="form-group mb-10 text-end">
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

<script>
     $(document).ready(function() {
    $('#employee_id').select2({ 
        dropdownParent: $('#kt_dynamic_app'),
        theme: 'bootstrap-5',
        width: '100%'
    });
   
    $('#leave_status_id').select2({
        dropdownParent: $('#kt_dynamic_app'),
        width: '100%' ,
        placeholder: 'Select an Leave Status',
        theme: 'bootstrap-5',
    });
});
    var KTAppEcommerceSaveLeaveMapping = function() {
        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');
            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'employee_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Employee Name is required'
                                },
                            }
                        },
                        'attendance_date': {
                            validators: {
                                 date: {
                                    format: 'YYYY-MM-DD',
                                  message: 'The value is not a valid date',
                                        },
                                notEmpty: {
                                    message: 'Attendance Date is required'
                                },
                            }
                        },
                        // 'reporting_id': {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Reporting Manager is required'
                        //         },
                        //     }
                        // },
                        'leave_status_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Leave Status is required'
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
                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('save.att-manual-entry') }}",
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
                                       
                                    } else if(res.error == 2){
                                         if(res.message) {
                               toastr.error("Error",res.message);
                                        }
                                    }else {
                                        toastr.success(
                                            "Leave Mapping added successfully");
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
        KTAppEcommerceSaveLeaveMapping.init();
    });
    $("#employee_id,#attendance_date").change(function() {
        $('#staff_err').addClass('staff_err');
         getStaffLeaveDays($('#employee_id').val(), $('#attendance_date').val(), $('#attendance_date').val(),'');
        
    });
    function getStaffLeaveDays(staff_id_alt, start_date, end_date,leave_type) {  
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $("#grid tbody").empty();
        $.ajax({
          url: "{{ route('get.staff.leave.available') }}",
          type: 'POST',
          data: {
            staff_id: staff_id_alt,
            leave_start: start_date,
            leave_end: end_date,
            leave_type: leave_type
          },
          success: function(response) {
          if(response.type=='retired'){
           $('#staff_err').removeClass('staff_err');
           $('#attendance_date').val('');
          
            }

          }
        })
      }
</script>
