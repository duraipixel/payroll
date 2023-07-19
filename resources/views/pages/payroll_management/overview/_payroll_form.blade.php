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
            <form action="" class="" id="dynamic_form">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex">
                            <div class="form-group p-2 w-50">
                                <input type="checkbox" id="leave_days" name="payroll_points[]" value="leave_days">
                                <label for="leave_days" class="mx-3"> Leave Days </label>
                            </div>
                            <div class="w-30 d-flex">
                                @if (isset($leave_data) && !empty($leave_data))
                                    @foreach ($leave_data as $key => $value)
                                        <div class="">
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
                            <div class="w-20">
                                
                            </div>
                        </div>

                        <div class="form-group p-2">
                            <input type="checkbox" id="resigned" name="payroll_points[]" value="resigned">
                            <label for="resigned" class="mx-3"> Resigned </label>
                        </div>
                        <div class="form-group p-2">
                            <input type="checkbox" id="hold_salary" name="payroll_points[]" value="hold_salary">
                            <label for="hold_salary" class="mx-3"> Checked Hold Salary </label>
                        </div>
                        <div class="form-group p-2">
                            <input type="checkbox" id="discipline" name="payroll_points[]" value="discipline">
                            <label for="discipline" class="mx-3"> Hold Due to Discipline </label>
                        </div>
                        <div class="form-group p-2">
                            <input type="checkbox" id="income_tax" name="payroll_points[]" value="income_tax">
                            <label for="income_tax" class="mx-3"> Income Tax </label>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-10 text-start">
                    <button type="button" class="btn btn-sm btn-light-primary" data-bs-dismiss="modal"> Cancel
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="form-submit-btn">
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
