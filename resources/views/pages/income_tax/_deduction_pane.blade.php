<form id="deduction_form">
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label for="">Section</label>
                    <div>
                        <select onchange="return changeDeductionSectionContent(this.value)" name="section_id"
                            id="section_id" class="form-control w-200px table-select">
                            <option value="">--select -</option>
                            @if (isset($sections) && !empty($sections))
                                @foreach ($sections as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="from-group">
                    @if( isset( $statement_data ) && !empty( $statement_data ) && $statement_data->lock_calculation == 'yes')
                    @else
                    <button type="button" class="btn btn-primary btn-sm" onclick="return addDeductionItem()"> Add New
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="w-100 mt-5 border border-2" id="deduction_table">
                <thead class="bg-primary text-white p-4">
                    <tr>
                        <th class="p-2">Narration</th>
                        <th class="p-2">Section</th>
                        <th class="p-2">Max Limit</th>
                        <th class="p-2">Gross (P.A)</th>
                        <th class="p-2">Remarks</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody id="deduction_body_row">
                    {{-- <tr>
                    <td colspan="6" class="text-center">Select Section to add new </td>
                </tr> --}}
                </tbody>
            </table>

        </div>
        @if( isset( $statement_data ) && !empty( $statement_data ) && $statement_data->lock_calculation == 'no')
        <div class="col-sm-12 text-end mt-3">
            <button class="btn btn-dark btn-sm" type="button"> cancel </button>
            <button class="btn btn-success btn-sm" type="submit"> Save </button>
        </div>
        @endif
    </div>
</form>
<script>
    $('.table-select').select2({
        theme: 'bootstrap-5'
    })

    function addDeductionItem() {

        var section_id = $('#section_id').val();
        var staff_id = $('#staff_id').val();

        if (section_id == '' || section_id == 'undefined') {
            toastr.error('Please Select Section to Add New');
            $('#section_id').focus();
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('it.deduction.row') }}",
            type: 'POST',
            data: {
                section_id: section_id,
                staff_id: staff_id
            },
            beforeSend: function() {
                $('#deduction_body_row').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#deduction_body_row').removeClass('blur_loading_3px');
                $('#deduction_body_row').append(res);
            }
        })

    }

    function changeDeductionSectionContent(section_id) {

        var staff_id = $('#staff_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('it.deduction.row') }}",
            type: 'POST',
            data: {
                section_id: section_id,
                staff_id: staff_id,
                from: 'change'
            },
            beforeSend: function() {
                $('#deduction_body_row').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#deduction_body_row').removeClass('blur_loading_3px');
                $('#deduction_body_row').html(res);
            }
        })

    }

    $('#deduction_form').submit(function() {
        event.preventDefault();

        var staff_id = $('#staff_id').val();
        var forms = $('#deduction_form')[0];
        var formData = new FormData(forms);
        formData.append('staff_id', staff_id);
        $.ajax({
            url: "{{ route('it.deduction.save') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#deduction_form').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#deduction_form').removeClass('blur_loading_3px');
                if( res.error == 0 ){
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
