@if (isset($info) && !empty($info))
    @if (isset($info->emi) && count($info->emi))
        <table class="table table-striped table-hover">
            @foreach ($info->emi as $item)
                <tr class="">
                    <td class="ps-4">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ commonDateFormat($item->emi_date) }}
                        <input type="hidden" name="emi_month[]" value="{{ $item->emi_date }}">
                    </td>
                    <td class="text-end px-2">
                        Rs.{{ $item->amount}}
                        <input type="hidden" name="emi_amount[]" class="form-input text-end price" value="{{$item->amount ?? 0}}"
                            required>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@else
<table class="table table-striped table-hover">
    @if (isset($emi_details) && !empty($emi_details))
        @foreach ($emi_details as $item)
            <tr class="">
                <td class="ps-4">
                    {{$loop->iteration}}
                </td>
                <td>
                    {{ commonDateFormat($item['month']) }}
                    <input type="hidden" name="emi_month[]" value="{{ $item['month']}}">
                </td>
                <td class="text-end px-2">
                    Rs.{{ $item['amount']}}
                    <input type="hidden" name="emi_amount[]" value="{{$item['amount']}}">
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-muted">
                Please select Periods in Month and Insurance start date
            </td>
        </tr>
    @endif
</table>
@endif
