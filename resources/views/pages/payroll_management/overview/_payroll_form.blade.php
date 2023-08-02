<div class="modal-dialog modal-dialog-centered modal-xl">
    <style>
        .w-30 {
            width: 30% !important;
        }

        .w-20 {
            width: 20% !important;
        }

        .w-40 {
            width: 40% !important;
        }
    </style>
    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="modal-body py-lg-10 px-lg-10" id="dynamic_content">
            <form method="POST" id="checklist_form" action="{{ route('payroll.set.processing') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date ?? '' }}">
                <input type="hidden" name="payout_id" value="{{ $payout_id ?? '' }}">
                <input type="hidden" name="is_entried_min_attendance" id="is_entried_min_attendance" value="{{$is_entried_min_attendance}}">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex border-bottom mb-3 p-3">
                            <div class="form-group p-2 w-30">
                                <input type="checkbox" id="leave_days" onchange="setCompleted(this)"
                                    name="payroll_points[]" value="leave_days">
                                <label for="leave_days" class="mx-3"> Leave Days </label>
                            </div>
                            <div class="w-50 d-flex" id="leave_days_pane">
                                @if (isset($leave_data) && !empty($leave_data))
                                    @foreach ($leave_data as $key => $value)
                                        <div class="px-2 border border-2">
                                            <div class="small">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </div>
                                            <div class="text-muted">
                                                {{ $value }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div id="leave_days_approved" class="w-30 d-flex justify-content-center align-items-center">
                                <div>
                                    <a class="btn btn-light-primary btn-sm small" href="{{ route('leaves.list') }}"> Go
                                        to Approve
                                        Leave</a>
                                </div>
                            </div>
                            <div id="leave_days_message"
                                class="w-30 d-none small p-1 text-danger d-flex justify-content-center align-items-center">
                                <div>
                                    Employees will lose compensation if they don't request a leave of absence, their
                                    request is denied, and it remains outstanding.
                                </div>
                            </div>
                        </div>
                        <div class="d-flex border-bottom mb-3 p-3">
                            <div class="form-group p-2 w-30">
                                <input type="checkbox" id="employees" onchange="setCompleted(this)"
                                    name="payroll_points[]" value="employees">
                                <label for="employees" class="mx-3"> Employees </label>
                            </div>
                            <div class="w-50 d-flex" id="employees_pane">
                                @if (isset($employee_data) && !empty($employee_data))
                                    <div class="px-2 border border-2">
                                        <div class="small">
                                            Verification Approved
                                        </div>
                                        <div class="text-muted">
                                            {{ $employee_data['approved'] }}
                                        </div>
                                    </div>

                                    <div class="px-2 border border-2">
                                        <div class="small">
                                            Verification Pending
                                        </div>
                                        <div class="text-muted">
                                            {{ $employee_data['pending_approval'] }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="employees_approved" class="w-30 d-flex justify-content-center align-items-center">
                                <div>
                                    <a class="btn btn-light-primary btn-sm small" href="{{ route('staff.list') }}">
                                        Go to Staff List
                                    </a>
                                </div>
                            </div>
                            <div id="employees_message"
                                class="w-30 d-flex d-none p-1 text-danger small justify-content-center align-items-center">
                                <div>
                                    All employee verification must be completed before the payroll process can begin.
                                    Whenever an employee's verification is pending. Payroll processing is limited to
                                    verified employees only.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex border-bottom mb-3 p-3">
                            <div class="form-group p-2 w-30">
                                <input type="checkbox" id="income_tax" onchange="setCompleted(this)"
                                    name="payroll_points[]" value="income_tax">
                                <label for="income_tax" class="mx-3"> Income Tax </label>
                                <input type="hidden" name="process_it" id="process_it"
                                    value="{{ $income_tax_data['process_it'] }}">
                            </div>
                            <div class="w-50 d-flex" id="income_tax_pane">
                                @if (isset($income_tax_data) && !empty($income_tax_data))
                                    <div class="px-2 border border-2">
                                        <div class="small">
                                            Verified Employee
                                        </div>
                                        <div class="text-muted">
                                            {{ $income_tax_data['pending_it'] }} /
                                            {{ $income_tax_data['verified_user'] }}
                                        </div>
                                    </div>

                                    <div class="px-2 border border-2">
                                        <div class="small">
                                            Verification Pending
                                        </div>
                                        <div class="text-muted">
                                            {{ $employee_data['pending_approval'] }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="income_tax_approved"
                                class="w-30 d-flex justify-content-center align-items-center">
                                <div>
                                    <a class="btn btn-light-primary btn-sm small"
                                        href="{{ route('it-calculation') }}">
                                        Go to Income Tax
                                    </a>
                                </div>
                            </div>
                            <div id="income_tax_message"
                                class="w-30 d-none p-1 d-flex justify-content-center text-danger small align-items-center">
                                <div>
                                    Income tax Entries all should be done.Otherwise Payroll process will not continue
                                </div>
                            </div>
                        </div>

                        <div class="d-flex border-bottom mb-3 p-3">
                            <div class="form-group p-2 w-30">
                                <input type="checkbox" id="hold_salary" onchange="setCompleted(this)"
                                    name="payroll_points[]" value="hold_salary">
                                <label for="hold_salary" class="mx-3"> Checked Hold Salary </label>
                                <input type="hidden" name="hold_salary" id="hold_salary" value="">
                            </div>
                            <div class="w-50 d-flex" id="hold_salary_pane">
                                <div class="px-2 border border-2">
                                    <div class="small">
                                        Hold Salary Employee
                                    </div>
                                    <div class="text-muted">    
                                        {{ $hold_salary_employee->count() }}
                                    </div>
                                </div>
                            </div>
                            <div id="hold_salary_approved"
                                class="w-30 d-flex justify-content-center align-items-center">
                                <div>
                                    <a class="btn btn-light-primary btn-sm small"
                                        href="{{ route('it-calculation') }}">
                                        Go to Hold Salary
                                    </a>
                                </div>
                            </div>
                            <div id="hold_salary_message"
                                class="w-30 d-none p-1 d-flex justify-content-center text-danger small align-items-center">
                                <div>
                                    Hold salary Staff will not receive salary untill release salary.
                                </div>
                            </div>
                        </div>
                      
                        {{-- <div class="form-group p-2">
                            <input type="checkbox" id="resigned" name="payroll_points[]" value="resigned">
                            <label for="resigned" class="mx-3"> Resigned </label>
                        </div> --}}

                    </div>
                </div>

                <div class="form-group mt-10 text-start">
                    <button type="button" class="btn btn-sm btn-light-primary" data-bs-dismiss="modal"> Cancel
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="form-submit-process-btn"
                        onclick="doPayrollProcess()">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>

            <script></script>
        </div>
    </div>
</div>

<script>
    function setCompleted(element) {
        // console.log(element, 'element');
        var id_name = $(element).attr('id');
        if ($(element).is(':checked')) {

            $('#' + id_name + '_pane').addClass('text-decoration-line-through');
            $('#' + id_name + '_approved').addClass('d-none');
            $('#' + id_name + '_message').removeClass('d-none');
        } else {
            $('#' + id_name + '_pane').removeClass('text-decoration-line-through');
            $('#' + id_name + '_approved').removeClass('d-none');
            $('#' + id_name + '_message').addClass('d-none');

        }
    }

    function doPayrollProcess() {

        var total_check = 4;
        var arrays = []
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
            arrays.push(checkboxes[i].value)
        }
        if (total_check == arrays.length) {
            console.log('do payroll process');
        } else {
            toastr.error('Error', 'Please select all checklist to continue');
            return false;
        }

        var process_it = $('#process_it').val();
        if (!process_it) {
            toastr.error('Error', 'Can not continue Payroll process. Please complete all income tax entries');
            return false;
        }

        var is_entried_min_attendance = $('#is_entried_min_attendance').val();
        if( is_entried_min_attendance == 0 ) {

            toastr.error('Error', 'Can not continue Payroll process. Attendance entries not found');
            return false;

        }

        $('#checklist_form').submit();
    }
</script>
