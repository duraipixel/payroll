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
            value="{{ $info->last_post_held ?? ($staff_info->appointment?->designation?->name ?? '') }}"
            class="form-control form-control-sm" required>
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6" class="required">
        <label for=""> Date of Regularization on </label>
    </div>
    <div class="col-sm-6">
        <input type="date"
            value="{{ $info->date_of_regularizion ?? ($staff_info->appointment?->from_appointment ?? '') }}" readonly
            name="date_of_regularizion" id="date_of_regularizion" class="form-control form-control-sm">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Date of Ending Service </label>
    </div>
    <div class="col-sm-6">
        <input type="date"
            value="{{ $info->date_of_ending_service ?? ($staff_info->appointment?->to_appointment ?? '') }}" readonly
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
            <option value="superannuation" @if (isset($info->cause_of_ending_service) && $info->cause_of_ending_service == 'superannuation') selected @endif>Superannuation</option>
            <option value="due_to_medical_ground" @if (isset($info->cause_of_ending_service) && $info->cause_of_ending_service == 'due_to_medical_ground') selected @endif>Due to medical
                ground</option>
            <option value="invalid_on_medical_ground" @if (isset($info->cause_of_ending_service) && $info->cause_of_ending_service == 'invalid_on_medical_ground') selected @endif>Invalid on
                medical ground</option>
            <option value="death" @if (isset($info->cause_of_ending_service) && $info->cause_of_ending_service == 'death') selected @endif>Death</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-3">
        <table class="table table-bordered w-100 p-2">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="p-2"> From </th>
                    <th class="p-2"> To </th>
                    <th class="p-2"> Total EL </th>
                    <th class="p-2"> EL Availed </th>
                    <th class="p-2"> EL Deduct </th>
                    <th class="p-2"> Balance </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_allocated = 0;
                    $balance = 0;

                @endphp
                @if (isset($el_days) && !empty($el_days))
                    @foreach ($el_days as $item)
                    @php
                        $all_dayas = $allocated_year_el_day;
                        if( $item['is_final'] == 'yes') {
                            $month_days = findMonthBetweenDates($item['from_date'], $item['to_date']);
                            if( $month_days <= 6 ) {
                                $all_dayas = 5;
                            }
                        }
                        $total_allocated += $all_dayas; 

                        $balance += $all_dayas;
                    @endphp
                        <tr>
                            <td>
                                <label for="" class="pt-2">
                                    {{ commonDateFormat( $item['from_date'] ) }}
                                </label>
                            </td>
                            <td>
                                <label for="" class="pt-2">
                                    {{ commonDateFormat( $item['to_date'] ) }}
                                </label>
                            </td>
                            <td>
                                <input type="text" readonly id="total_availed"
                                    class="total_availed form-control allocated text-end form-control-sm w-70px price" value="{{ $allocated_year_el_day ?? 10 }}">
                            </td>
                            <td>
                                <input type="text" name="el_availed" class="form-control form-control-sm ">
                            </td>
                            <td>
                                <input type="text" name="el_deducted" class="el_deduct form-control  form-control-sm text-end w-70px price" id="" value="">
                            </td>
                            <td>
                                <input type="text" name="balace_el" value="{{ $balance }}" class="form-control el_balance form-control-sm text-end w-70px price">
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="2">
                        Total
                    </td>
                    <td>
                        <input type="text" readonly name="total_allocated" id="total_allocated" class="form-control w-70px text-end" value="{{ $total_allocated }}">
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="text" name="total_balance_el" id="total_balance_el" value="{{ $balance }}" class="form-control text-end w-70px form-control-sm">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row mt-3">
    <h4 class="text-muted">Emoluments last drawn</h4>
    <div class="col-sm-12">
        <table class="w-100 table table-borderd table-hover">
            <tr>
                <th> Basic pay </th>
                <td class="text-end">
                    <input type="hidden" name="basic"
                        value="{{ $info->basic->amount ?? ($staff_info->currentSalaryPattern->basic->amount ?? 0) }}">
                    Rs.{{ $info->basic->amount ?? ($staff_info->currentSalaryPattern->basic->amount ?? 0) }}
                </td>
            </tr>
            <tr>
                <th> Basic DA </th>
                <td class="text-end">
                    Rs.{{ $info->basicDa->amount ?? ($staff_info->currentSalaryPattern->da->amount ?? 0) }}
                    <input type="hidden" name="basic_da"
                        value="{{ $info->basicDa->amount ?? ($staff_info->currentSalaryPattern->da->amount ?? 0) }}">
                </td>
            </tr>
            @if ($page_type == 'retired')
                <tr>
                    <th> PBA </th>
                    <td class="text-end">
                        Rs.{{ $info->pba->amount ?? ($staff_info->currentSalaryPattern->pba->amount ?? 0) }}
                        <input type="hidden" name="basic_pba"
                            value="{{ $info->pba->amount ?? ($staff_info->currentSalaryPattern->pba->amount ?? 0) }}">

                    </td>
                </tr>
                <tr>
                    <th> PBADA </th>
                    <td class="text-end">
                        Rs.{{ $info->pbada->amount ?? ($staff_info->currentSalaryPattern->pbada->amount ?? 0) }}
                        <input type="hidden" name="basic_pbada"
                            value="{{ $info->pbada->amount ?? ($staff_info->currentSalaryPattern->pbada->amount ?? 0) }}">
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
        if ($page_type == 'retired') {
            $retired_amount = ($staff_info->currentSalaryPattern->pba->amount ?? 0) + ($staff_info->currentSalaryPattern->pbada->amount ?? 0);
        }
        $total_emul = $resigned_amount + ($retired_amount ?? 0);
    @endphp
    <div class="col-sm-6">
        <input type="text" name="total_emuluments" requried id="total_emuluments"
            class="form-control form-control-sm price text-end"
            value="{{ $info->total_emuluments ?? ($total_emul ?? 0) }}">
    </div>
</div>
<div class="row  mt-3">
    <div class="col-sm-6">
        <label for="" class="required"> Earned Leave Encashment Calculation </label>
    </div>
    <div class="col-sm-6">
        <input type="text" name="gratuity_calculation" required id="gratuity_calculation"
            class="form-control form-control-sm price text-end" value="{{ $info->gratuity_calculation ?? '' }}">
    </div>
</div>

<div class="row  mt-3">
    <div class="col-sm-6">
        <label for=""> Total amount of Earned Leave encashment </label>
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
