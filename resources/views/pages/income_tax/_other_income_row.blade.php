<tr class="delete_other_income_row">
    <td class="p-2">
        <div class="w-200px">

            <select name="description_id[]" class="form-control table-select" required>
                <option value="">--select--</option>
                @if (isset($other_incomes) && !empty($other_incomes))
                    @foreach ($other_incomes as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </td>
    <td class="p-2">
        <input type="text" name="amount[]" class="form-input price text-end" required>
    </td>
    <td class="p-2">
        <input type="text" name="remarks[]" class="form-input">
    </td>
    <td class="p-2 text-center">
        <i class="fa fa-trash p-2 text-danger" role="button" onclick="return deleteOtherIncomeRow(this)"></i>
    </td>
</tr>
<script>
    $('.table-select').select2({
        theme: 'bootstrap-5'
    })

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });
</script>
