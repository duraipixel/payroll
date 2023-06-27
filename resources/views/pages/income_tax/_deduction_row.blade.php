@if (isset($pf_calc_data) && count($pf_calc_data) > 0  && $pf_data )
    {{-- @foreach ($pf_calc_data as $pf_item) --}}
        <tr class="delete_row">
            <td class="p-2">
                <div class="w-250px">

                    <select id="" class="form-control table-select" disabled>
                        <option value="">--select--</option>
                        @if (isset($pf_calc_data) && !empty($pf_calc_data))
                            @foreach ($pf_calc_data as $row)
                                <option value="{{ $row->id }}" @if($row->is_pf_calculation == 'yes') selected @endif>
                                    {{ $row->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </td>
            <td class="p-2">
                <label> {{ $section_info->name ?? '' }} </label>
            </td>
            <td class="p-2">
                {{-- RS. {{ $section_info->maximum_limit }} --}}
            </td>
            <td class="p-2">
                <input type="text" class="form-input price text-end" value="{{( $pf_data->amount ?? 0 ) * 12  }}"
                    disabled>
            </td>
            <td class="p-2">
                <input type="text" value="{{ $ded->remarks ?? '' }}" class="form-input" disabled>
            </td>
            <td class="p-2 text-center">
                {{-- <i class="fa fa-trash p-2 text-danger" role="button" onclick="return removeDeductionRow(this)"></i> --}}
            </td>
        </tr>
    {{-- @endforeach --}}
@endif
@if ($from)
    @if (isset($deductions) && !empty($deductions) && count($deductions) > 0)
        @foreach ($deductions as $ded)
            <tr class="delete_row">
                <td class="p-2">
                    <div class="w-250px">

                        <select name="items[]" id="" class="form-control table-select" required>
                            <option value="">--select--</option>
                            @if (isset($items) && !empty($items))
                                @foreach ($items as $row)
                                    <option value="{{ $row->id }}"
                                        @if (isset($ded) && $ded->tax_section_item_id == $row->id) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </td>
                <td class="p-2">
                    <label> {{ $section_info->name }} </label>
                </td>
                <td class="p-2">
                    RS. {{ $section_info->maximum_limit }}
                </td>
                <td class="p-2">
                    <input type="text" name="amount[]" class="form-input price text-end" value="{{ $ded->amount ?? '' }}"
                        required>
                </td>
                <td class="p-2">
                    <input type="hidden" name="id[]" value="{{ $ded->id ?? '' }}">
                    <input type="text" name="remarks[]" value="{{ $ded->remarks ?? '' }}" class="form-input">
                </td>
                <td class="p-2 text-center">
                    <i class="fa fa-trash p-2 text-danger" role="button" onclick="return removeDeductionRow(this)"></i>
                </td>
            </tr>
        @endforeach
    @else
        <tr class="delete_row">
            <td class="p-2">
                <div class="w-250px">

                    <select name="items[]" id="" class="form-control table-select" required>
                        <option value="">--select--</option>
                        @if (isset($items) && !empty($items))
                            @foreach ($items as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </td>
            <td class="p-2">
                <label> {{ $section_info->name ?? '' }} </label>
            </td>
            <td class="p-2">
                RS. {{ $section_info->maximum_limit ?? '' }}
            </td>
            <td class="p-2">
                <input type="text" name="amount[]" class="form-input price text-end" required>
            </td>
            <td class="p-2">
                <input type="text" name="remarks[]" class="form-input">
            </td>
            <td class="p-2 text-center">
                <i class="fa fa-trash p-2 text-danger" role="button" onclick="return removeDeductionRow(this)"></i>
            </td>
        </tr>
    @endif
@else
    <tr class="delete_row">
        <td class="p-2">
            <div class="w-250px">

                <select name="items[]" id="" class="form-control table-select" required>
                    <option value="">--select--</option>
                    @if (isset($items) && !empty($items))
                        @foreach ($items as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </td>
        <td class="p-2">
            <label> {{ $section_info->name }} </label>
        </td>
        <td class="p-2">
            RS. {{ $section_info->maximum_limit }}
        </td>
        <td class="p-2">
            <input type="text" name="amount[]" class="form-input price text-end" required>
        </td>
        <td class="p-2">
            <input type="text" name="remarks[]" class="form-input">
        </td>
        <td class="p-2 text-center">
            <i class="fa fa-trash p-2 text-danger" role="button" onclick="return removeDeductionRow(this)"></i>
        </td>
    </tr>
@endif
<script>
    $('.table-select').select2({
        theme: 'bootstrap-5'
    })

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    function removeDeductionRow(element) {
        element.closest('.delete_row').remove();
    }
</script>
