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
                Please select Period of Loan and Loan start date
            </td>
        </tr>
    @endif
</table>
