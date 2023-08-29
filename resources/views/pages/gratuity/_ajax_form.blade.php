<div class="col-sm-12">
    <label for="" class="text-muted">
        Particulars of post held at the time of retirement
    </label>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Last Post held </label>
    </div>
    <div class="col-sm-6">
        <input type="text" readony name="last_post_held" id="last_post_held" value="{{  $staff_info->appointment?->designation?->name ?? '' }}" class="form-control form-control-sm" required>
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6" class="required">
        <label for=""> Date of Regularization on </label>
    </div>
    <div class="col-sm-6">
        <input type="date" value="{{ $staff_info->appointment?->from_appointment ?? '' }}" readonly name="date_of_regularizion" id="date_of_regularizion"
            class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Date of Ending Service </label>
    </div>
    <div class="col-sm-6">
        <input type="date" value="{{ $staff_info->appointment?->to_appointment ?? '' }}" readonly name="date_of_ending_service" id="date_of_ending_service" required
            class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Cause of Ending Service </label>
    </div>
    <div class="col-sm-6">
        <select name="cause_of_ending_service" required id="cause_of_ending_service" class="form-control form-control-sm">
            <option value=""> --select-- </option>
            <option value="superannuation">Superannuation</option>
            <option value="due_to_medical_ground">Due to medical ground</option>
            <option value="invalid_on_medical_ground">Invalid on medical ground</option>
            <option value="death">Death</option>
        </select>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Gross Service </label>
    </div>
    <div class="col-sm-6 d-flex align-items-center">
        <input type="text" class="form-control form-control-sm w-100px me-1 price" required> years and
        <input type="text" class="form-control form-control-sm w-100px ms-3 me-1 price" required> months
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Extraordinary Leave not counting as qualifying service </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="extraordinary_leave" id="extraordinary_leave" class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Periods of suspension not treated as qualifying service </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="suspension_qualifying_service" id="suspension_qualifying_service"
            class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Net qualifying service </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="suspension_qualifying_service" required id="suspension_qualifying_service"
            class="form-control form-control-sm">
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm-6">
        <label for="" class="required">
            Qualifying service expressed in terms of completed six monthly periods
            (period of three months and over is treated as completed six monthly period)
        </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="qualify_service_expressed" required id="qualify_service_expressed"
            class="form-control form-control-sm">
    </div>
</div>
<div class="row mt-3">
    <h4 class="text-muted">Emoluments last drawn</h4>
    <div class="col-sm-12">
        <table class="w-100 table table-borderd table-hover">
            <tr>
                <th> Basic pay </th>
                <td> Rs.900 </td>
            </tr>
            <tr>
                <th> Basic pay </th>
                <td> Rs.900 </td>
            </tr>
            <tr>
                <th> Basic pay </th>
                <td> Rs.900 </td>
            </tr>
        </table>
    </div>

</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Total Emoluments </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="total_emuluments" requried id="total_emuluments"
            class="form-control form-control-sm price">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Gratuity Calculation </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="gratuity_calculation" required id="gratuity_calculation"
            class="form-control form-control-sm price">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Whether nomination made for gratuity </label>
    </div>
    <div class="col-sm-6">
        <input type="radio" name="nomination" value="yes" id="nomination_yes">
        <label for="nomination_yes">Yes</label>
        <input type="radio" name="nomination" value="no" id="nomination_no">
        <label for="nomination_no">No</label>
    </div>
</div>
<div class="row  mt-3" id="nominee_pane ">
    <div class="col-sm-6">
        <label for=""> Nominee </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="gratuity_nomination_name" id="gratuity_nomination_name"
            class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Total Payable of retirement Gratuity </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="total_payable_gratuity" id="total_payable_gratuity"
            class="form-control form-control-sm price">
    </div>
</div>
