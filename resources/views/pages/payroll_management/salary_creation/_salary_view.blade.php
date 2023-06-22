<div class="payheads-pane p-3 border border-2 w-700px">
    <div class="d-flex m-2 p-2 bg-primary text-white w-100 ">
        <div class="w-50">
            Salary Heads
        </div>
        {{-- <div class="w-35 text-end">
            Previous Pay
        </div> --}}
        <div class="w-50 text-end">
            <label for="" class=" ps-3">
                Pay
            </label>
        </div>
    </div>
    @if (isset($current_pattern->patternFields) && count($current_pattern->patternFields) > 0)
        @foreach ($current_pattern->patternFields as $item)
            <div class="d-flex w-100 m-2 p-2 payrow">
                <div class="w-50">
                    {{ $item->field_name }}
                </div>
                {{-- <div class="w-35 text-end">
                    <input type="text" name="previous_head" id="">
                </div> --}}
                <div class="w-50 text-end">
                    <span class="small text-muted">
                        @if ($item->reference_type == 'EARNINGS')
                            (+)
                        @else
                            (-)
                        @endif
                    </span>
                    <label for="">
                        {{ $item->amount ?? '' }}
                    </label>
                </div>
            </div>
        @endforeach
    @endif

    <div class="d-flex w-100 m-2 p-2 payrow">
        <div class="w-50">
            Net Salary
        </div>
        <div class="w-50 text-end">
            <label for="" class="fw-bold fs-5">
                {{ $current_pattern->net_salary ?? '' }}
            </label>
        </div>
    </div>
</div>
<div class="border border-2 mt-2 w-700px p-3">
    <div>
        Effective From {{ commonDateFormat($current_pattern->effective_from) }}
    </div>
    <div class="mt-3">
        <label for="" class="text-muted"> Remarks </label>
        <div>
            {{ $current_pattern->employee_remarks ?? '' }}
        </div>
    </div>
</div>