<form class="" id="dynamic_form">
    @csrf
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="page_type" value="{{ $page_type }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Staff Name
        </label>
        <div>
            <select class="form-control staff_select2" name="staff_id" id="staff_id" data-width="100%">
                <option value=""></option>
                @if (isset($users) && !empty($users))
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}" @if( isset( $info->staff_id ) && $info->staff_id == $item->id ) selected @endif> {{ $item->name }} - {{ $item->institute_emp_code }} </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group mb-10">
        <label class="form-label required" for="">
            Last Working Date
        </label>
        <div>
            <input type="date" class="form-control" name="last_working_date" id="last_working_date"
                value="{{ $info->last_working_date ?? '' }}">
        </div>
    </div>
    <div class="form-group mb-10">
        <label class="form-label" for="">
            Document File
        </label>
        <div>
            <input type="file" class="form-control" name="document" id="document">
            @if( isset( $info->document ) && !empty( $info->document ))
                @php
                    $url = Storage::url($info->document);
                @endphp
                <div class="mt-3">
                    <a href="{{ asset('public'.$url) }}" target="_blank"> View File </a>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group mb-10">
        <label class="form-label required" for="">
            Reason
        </label>
        <div>
            <textarea name="reason" id="reason" cols="30" class="form-control" rows="3">{{ $info->reason ?? '' }}</textarea>
        </div>
    </div>
    <div class="fv-row form-group mb-10">
        <div class="d-flex">
            <div class="w-50">
                <label class="form-label" for="">
                    Status
                </label>
                <div>
                    <input type="radio" id="active" class="form-check-input" value="active" name="status"
                        @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                    <label class="pe-3" for="active">Active</label>
                    <input type="radio" id="inactive" class="form-check-input" value="inactive" name="status"
                        @if (isset($info->status) && $info->status == 'inactive') checked @endif>
                    <label for="inactive">Inactive</label>
                </div>
            </div>
            <div class="w-50">
                <label class="form-label" for="is_completed">
                    Is Completed
                </label>
                <div>
                    <input type="checkbox" name="is_completed" id="is_completed" @if( isset( $info->is_completed) && $info->is_completed == 'yes') checked @endif value="yes">
                </div>
            </div>
        </div>
        
    </div>
    <div class="form-group mb-10 text-end">
        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
        <button type="button" class="btn btn-primary" onclick="return validateCareerForm()" id="form-submit-btn">
            <span class="indicator-label">
                Submit
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</form>

<script>
     $(document).ready(function() {
        $('.staff_select2').select2({
            width: '100%' ,
            placeholder: 'Select an Staff',
        dropdownParent: $('#dynamic_form'),
        theme: 'bootstrap-5',
    });
  });
    function validateCareerForm() {
        var careerform_error = false;

        var key_name = [
            'staff_id',
            'last_working_date',
            'reason'
        ];

        $('.kyc-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                careerform_error = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container kyc-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element + ' + .select2.select2-container').addClass('border-danger')
                // $('#' + element).focus();
            } else {
                $('#' + element).removeClass('border-danger')
                $('#' + element + ' + .select2.select2-container').removeClass('border-danger')
            }
        });
        console.log(careerform_error, 'careerform_error')

        if (!careerform_error) {
            var forms = $('#dynamic_form')[0];
            var formData = new FormData(forms);
            $.ajax({
                url: "{{ route('career.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#form-submit-btn').attr('disabled', true);
                },
                success: function(res) {
                    // Disable submit button whilst loading
                    $('#form-submit-btn').attr('disabled', false);
                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success("Added successfully");
                        $('#kt_dynamic_app').modal('hide');
                        dtTable.draw();
                    }
                }
            })
        }
    }
</script>
