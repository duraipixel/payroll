<form id="other_income_form">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between">
                <div class="from-group">
                    <label> Other Income </label>
                </div>
                <div class="from-group">
                    @if( isset( $statement_data ) && !empty( $statement_data ))
                    @else
                    <button type="button" class="btn btn-primary btn-sm" onclick="return getOIRow()"> Add New </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="w-100 mt-5 border border-2" id="deduction_table">
                <thead class="bg-primary text-white p-4">
                    <tr>
                        <th class="p-2"> Description </th>
                        <th class="p-2"> Amount (P.A) </th>
                        <th class="p-2"> Remarks </th>
                        <th class="p-2"> Action </th>
                    </tr>
                </thead>
                <tbody id="other_income_body">
                    @if (isset($staff_other_incomes) && !empty($staff_other_incomes) && count($staff_other_incomes) > 0)
                        @foreach ($staff_other_incomes as $sitem)
                            <tr class="delete_other_income_row">
                                <td class="p-2">
                                    <select name="description_id[]" class="form-control table-select w-200px" required>
                                        <option value="">--select--</option>
                                        @if (isset($other_incomes) && !empty($other_incomes))
                                            @foreach ($other_incomes as $item)
                                                <option value="{{ $item->id }}" @if(isset($sitem) && $sitem->other_income_id == $item->id ) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="amount[]" value="{{ $sitem->amount ?? '' }}" class="form-input price text-end" required>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="remarks[]" value="{{ $sitem->remarks ?? '' }}" class="form-input">
                                </td>
                                <td class="p-2 text-center">
                                    <i class="fa fa-trash p-2 text-danger" role="button"
                                        onclick="return deleteOtherIncomeRow(this)"></i>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="delete_other_income_row">
                            <td class="p-2">
                                <select name="description_id[]" class="form-control table-select w-200px" required>
                                    <option value="">--select--</option>
                                    @if (isset($other_incomes) && !empty($other_incomes))
                                        @foreach ($other_incomes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="p-2">
                                <input type="text" name="amount[]" class="form-input price" required>
                            </td>
                            <td class="p-2">
                                <input type="text" name="remarks[]" class="form-input">
                            </td>
                            <td class="p-2 text-center">
                                <i class="fa fa-trash p-2 text-danger" onclick="return deleteOtherIncomeRow(this)"></i>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
        <div class="col-sm-12 text-end mt-3">
            <button class="btn btn-dark btn-sm" type="button"> cancel </button>
            <button class="btn btn-success btn-sm" type="submit"> Save </button>
        </div>
    </div>
</form>
<script>
    $('.table-select').select2({
        theme: 'bootstrap-5'
    })

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    function getOIRow() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('it.other.income.row') }}",
            type: 'POST',
            beforeSend: function() {
                $('#other_income_body').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#other_income_body').removeClass('blur_loading_3px');
                $('#other_income_body').append(res);
            }
        })
    }

    function deleteOtherIncomeRow(element) {
        element.closest('.delete_other_income_row').remove();
    }

    $('#other_income_form').submit(function() {
        event.preventDefault();

        var staff_id = $('#staff_id').val();
        var forms = $('#other_income_form')[0];
        var formData = new FormData(forms);
        formData.append('staff_id', staff_id);
        $.ajax({
            url: "{{ route('it.other.income.save') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#other_income_form').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#other_income_form').removeClass('blur_loading_3px');
                if (res.error == 0) {
                    toastr.success('Success', res.message);
                } else {
                    if (res.message) {
                        toastr.error("Error",
                            res.message);

                    }
                }

            }
        })
    })
</script>
