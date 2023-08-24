<table class="table mt-3 align-middle  table-hover table-bordered table-striped fs-7 no-footer" id="earnings_table">
    <thead class="bg-primary">
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="px-3 text-white">
                <div>
                    <input role="button" type="checkbox" name="select_all" id="select_all">
                </div>
            </th>
            <th class="px-3 text-white">
                Emp Code
            </th>
            <th class="px-3 text-white">
                Emp Name
            </th>
            <th class="px-3 text-white w-200px">
                Amount
            </th>
            <th class="px-3 text-white text-center">
                Remarks
            </th>
        </tr>
    </thead>

    <tbody class="text-gray-600 fw-bold">
        @if (isset($earnings_details) && !empty($earnings_details))
            @foreach ($earnings_details as $item)
                <tr>
                    <td class="p-3">
                        <input type="checkbox" checked role="button" name="bonus[]" class="bonus_check"
                            value="{{ $item->staff->id }}">
                    </td>
                    <td>
                        {{ $item->staff->institute_emp_code }}
                    </td>
                    <td>
                        {{ $item->staff->name }}
                    </td>
                    <td>
                        <input type="text" name="amount_{{ $item->staff->id }}"
                            class="price form-control form-control-sm text-end" placeholder="Bonus amount"
                            value="{{ $item->amount }}">
                    </td>
                    <td>
                        <textarea name="remarks_{{ $item->staff->id }}" cols="30" rows="1"
                            class="form-control form-control-sm h-30px">{{ $item->remarks }}</textarea>
                    </td>
                </tr>
            @endforeach
        @elseif (isset($employees) && !empty($employees))
            @foreach ($employees as $item)
                @php
                    $earning_info = getDeductionInfo($item->id, $page_type, $salary_date);
                @endphp
                <tr>
                    <td class="p-3">
                        <input type="checkbox" @if (getDeductionInfo($item->id, $page_type, $salary_date)) checked @endif role="button"
                            name="bonus[]" class="bonus_check" value="{{ $item->id }}">
                    </td>
                    <td>
                        {{ $item->institute_emp_code }}
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        <input type="text" name="amount_{{ $item->id }}"
                            class="price form-control form-control-sm text-end" placeholder="amount"
                            value="{{ $earning_info->amount ?? '' }}">
                    </td>
                    <td>
                        <textarea name="remarks_{{ $item->id }}" cols="30" rows="1" class="form-control form-control-sm h-30px">{{ $earning_info->remarks ?? '' }}</textarea>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>

<script>
    $('#select_all').change(function() {
        if (this.checked) {
            $('.bonus_check').prop('checked', true);
        } else {
            $('.bonus_check').attr('checked', false);
        }
    })
</script>
