<div class="payheads-pane p-3 border border-2">
    <div class="d-flex w-100 m-2 p-2 bg-primary text-white">
        <div class="w-30">
            Salary Heads
        </div>
        <div class="w-35 text-end">
            Previous Pay
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
                        class="add_input form-control form-control-sm w-200px float-end text-end"
                        disabled
                        >
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
                        class="minus_input form-control form-control-sm w-200px float-end text-end"
                        disabled
                        >
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
            <input type="text" class="form-control form-control-sm w-200px float-end text-end numberonly" name="net_salary" id="net_salary" value="">
        </div>
    </div>
</div>
