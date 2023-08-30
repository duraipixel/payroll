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
        <input type="text" readony name="last_post_held" id="last_post_held"
            value="{{ $info->last_post_held ?? $staff_info->appointment?->designation?->name ?? '' }}" class="form-control form-control-sm"
            required>
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6" class="required">
        <label for=""> Date of Regularization on </label>
    </div>
    <div class="col-sm-6">
        <input type="date" value="{{ $info->date_of_regularizion ?? $staff_info->appointment?->from_appointment ?? '' }}" readonly
            name="date_of_regularizion" id="date_of_regularizion" class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Date of Ending Service </label>
    </div>
    <div class="col-sm-6">
        <input type="date" value="{{ $info->date_of_ending_service ?? $staff_info->appointment?->to_appointment ?? '' }}" readonly
            name="date_of_ending_service" id="date_of_ending_service" required class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Cause of Ending Service </label>
    </div>
    <div class="col-sm-6">
        <select name="cause_of_ending_service" required id="cause_of_ending_service"
            class="form-control form-control-sm">
            <option value=""> --select-- </option>
            <option value="superannuation" @if( isset( $info->cause_of_ending_service ) && $info->cause_of_ending_service == 'superannuation') selected @endif>Superannuation</option>
            <option value="due_to_medical_ground" @if( isset( $info->cause_of_ending_service ) && $info->cause_of_ending_service == 'due_to_medical_ground') selected @endif>Due to medical ground</option>
            <option value="invalid_on_medical_ground" @if( isset( $info->cause_of_ending_service ) && $info->cause_of_ending_service == 'invalid_on_medical_ground') selected @endif>Invalid on medical ground</option>
            <option value="death" @if( isset( $info->cause_of_ending_service ) && $info->cause_of_ending_service == 'death') selected @endif>Death</option>
        </select>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Gross Service </label>
    </div>
    <div class="col-sm-6 d-flex align-items-center">
        <input type="text" name="gross_service_year" value="{{ $info->gross_service_year ?? '' }}" id="gross_service_year" onkeyup="qulifyingServiceAmountCalculation()" class="form-control form-control-sm w-100px me-1 price" required> years and
        <input type="text" name="gross_service_month" value="{{ $info->gross_service_month ?? '' }}" id="gross_service_month" onkeyup="qulifyingServiceAmountCalculation()" class="form-control form-control-sm w-100px ms-3 me-1 price" > months
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Extraordinary Leave not counting as qualifying service </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="extraordinary_leave" value="{{ $info->extraordinary_leave ?? '' }}" onkeyup="qulifyingServiceAmountCalculation()"  id="extraordinary_leave" class="form-control price form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Periods of suspension not treated as qualifying service </label>
    </div>
    <div class="col-sm-6">
        <input type="text" value="{{ $info->suspension_qualifying_service ?? '' }}" name="suspension_qualifying_service" onkeyup="qulifyingServiceAmountCalculation()"  id="suspension_qualifying_service"
            class="form-control form-control-sm price">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Net qualifying service </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="net_qualifying_service" value="{{ $info->net_qualifying_service ?? '' }}" required id="net_qualifying_service"
            class="form-control form-control-sm price">
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
            class="form-control form-control-sm price" value="{{ $info->qualify_service_expressed ?? '' }}">
    </div>
</div>
<div class="row mt-3">
    <h4 class="text-muted">Emoluments last drawn</h4>
    <div class="col-sm-12">
        <table class="w-100 table table-borderd table-hover">
            <tr>
                <th> Basic pay </th>
                <td class="text-end"> 
                    <input type="hidden" name="basic" value="{{ $info->basic->amount ?? $staff_info->currentSalaryPattern->basic->amount ?? 0 }}">
                    Rs.{{ $info->basic->amount ?? $staff_info->currentSalaryPattern->basic->amount ?? 0 }} 
                </td>
            </tr>
            <tr>
                <th> Basic DA   </th>
                <td class="text-end"> 
                    Rs.{{ $info->basicDa->amount ?? $staff_info->currentSalaryPattern->da->amount ?? 0 }} 
                    <input type="hidden" name="basic_da" value="{{ $info->basicDa->amount ?? $staff_info->currentSalaryPattern->da->amount ?? 0 }}">

                </td>
            </tr>
            @if( $page_type == 'retired')
            <tr>
                <th> PBA </th>
                <td class="text-end"> 
                    Rs.{{ $info->pba->amount ?? $staff_info->currentSalaryPattern->pba->amount ?? 0 }}
                    <input type="hidden" name="basic_pba" value="{{ $info->pba->amount ?? $staff_info->currentSalaryPattern->pba->amount ?? 0 }}">

                </td>
            </tr>
            <tr>
                <th> PBADA </th>
                <td class="text-end"> 
                    Rs.{{ $info->pbada->amount ?? $staff_info->currentSalaryPattern->pbada->amount ?? 0 }}
                    <input type="hidden" name="basic_pbada" value="{{ $info->pbada->amount ?? $staff_info->currentSalaryPattern->pbada->amount ?? 0 }}">

                </td>
            </tr>
            @endif
        </table>
    </div>

</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Total Emoluments </label>
    </div>
    @php
        $resigned_amount = ($staff_info->currentSalaryPattern->basic->amount ?? 0) + ($staff_info->currentSalaryPattern->da->amount ?? 0);
        if( $page_type == 'retired') {
            $retired_amount = ($staff_info->currentSalaryPattern->pba->amount ?? 0) + ($staff_info->currentSalaryPattern->pbada->amount ?? 0);
        }
        $total_emul =  $resigned_amount + ($retired_amount ?? 0);
    @endphp
    <div class="col-sm-6">
        <input type="text" name="total_emuluments" requried id="total_emuluments"
            class="form-control form-control-sm price text-end" value="{{ $info->total_emuluments ?? $total_emul ?? 0 }}">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Gratuity Calculation </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="gratuity_calculation" required id="gratuity_calculation"
            class="form-control form-control-sm price text-end" value="{{ $info->gratuity_calculation ?? '' }}">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Whether nomination made for gratuity </label>
    </div>
    <div class="col-sm-6">
        <select name="gratuity_type" id="gratuity_type" class="form-control form-control-sm" required>
            <option value="">--select--</option>
            <option value="resigned_gratuity" @if( isset( $info->gratuity_type ) && $info->gratuity_type == 'resigned_gratuity') selected="selected" @endif>Resigned Gratuity</option>
            @if( $page_type == 'retired')
            <option value="retirement_gratuity" @if( isset( $info->gratuity_type ) && $info->gratuity_type == 'retirement_gratuity') selected="selected" @endif> Retirement gratuity </option>
            <option value="death_gratuity" @if( isset( $info->gratuity_type ) && $info->gratuity_type == 'death_gratuity') selected="selected" @endif> Death Gratuity  </option>
            @endif
        </select>
    </div>
</div>
<div class="row  mt-3" id="nominee_pane ">
    <div class="col-sm-6">
        <label for=""> Nominee </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="gratuity_nomination_name" id="gratuity_nomination_name"
            class="form-control form-control-sm" value="{{ $info->gratuity_nomination_name ?? '' }}">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Total Payable of retirement Gratuity </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="total_payable_gratuity" id="total_payable_gratuity"
            class="form-control form-control-sm price text-end" value="{{ $info->total_payable_gratuity ?? '' }}">
    </div>
</div>

<script>
    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });
</script>
