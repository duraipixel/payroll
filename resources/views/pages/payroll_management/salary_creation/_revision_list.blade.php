<div class="row">
    <div class="col-sm-2">
        <div class="pay-salary-month">
            <ul type="none">
                @if (isset($all_salary_patterns) && count($all_salary_patterns))
                    @foreach ($all_salary_patterns as $item)
                        <li role="button" class="active">
                            {{ date('F Y', strtotime($item->payout_month)) }}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-sm-10" id="payout-salary-revision">
        <div class="payheads-pane p-3 border border-2 w-700px">
            <div class="d-flex m-2 p-2 bg-primary text-white ">
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
            @if (isset($salary_heads) && count($salary_heads) > 0)
                @foreach ($salary_heads as $item)
                    <div class="d-flex w-100 m-2 p-2 bg-secondary text-muted">
                        <div class="w-100">
                            {{ $item->name }}
                        </div>
                    </div>

                    @if (isset($item->fields) && !empty($item->fields))
                        @foreach ($item->fields as $item_fields)
                            @if (isset($salary_info) && !empty($salary_info))
                                @php
                                    $old_data = getSalarySelectedFields($salary_info->staff_id, $salary_info->id, $item_fields->id);
                                @endphp
                            @endif
                            <div class="d-flex w-100 m-2 p-2 payrow">
                                <div class="w-50">
                                    {{ $item_fields->name }}
                                </div>
                                {{-- <div class="w-35 text-end">
                                    <input type="text" name="previous_head" id="">
                                </div> --}}
                                <div class="w-50 text-end">
                                    <label for="">
                                        {{ $old_data->amount ?? '' }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endif

            <div class="d-flex w-100 m-2 p-2 payrow">
                <div class="w-30">
                    Net Salary
                </div>
                <div class="w-35 text-end">
                    <input type="text" class="text-end numberonly" name="previous_head" id=""
                        value="9876">
                </div>
                <div class="w-35 text-end">
                    <input type="text" class="text-end numberonly" name="current_head" id=""
                        value="8745678">
                </div>
            </div>
        </div>
    </div>
</div>
