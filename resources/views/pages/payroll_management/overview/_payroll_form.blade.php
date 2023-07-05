<form action="" class="" id="dynamic_form">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group p-2">
                <input type="checkbox" id="leave_days" name="payroll_points[]" value="leave_days">
                <label for="leave_days" class="mx-3"> Leave Days </label>
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
                <label for="income_tax" class="mx-3"> Income Tax  </label>
            </div>
        </div>
    </div>

    <div class="form-group mt-10 text-start">
        <button type="button" class="btn btn-sm btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
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
