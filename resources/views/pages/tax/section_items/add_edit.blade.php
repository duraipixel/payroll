<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" id="id" value="{{ $info->id ?? '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="fv-row form-group mb-10">
                <label class="form-label required" for="">
                    Tax Section
                </label>
                <div>
                    <select class="form-control" name="section_id" id="section_id">
                        <option value=""> -- select -- </option>
                        @if (isset($sections) && !empty($sections))
                            @foreach ($sections as $item)
                                <option value="{{ $item->id }}" @if( isset($info->tax_section_id) && $info->tax_section_id == $item->id ) selected @endif  > {{ $item->name }} - {{ $item->scheme->name }} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

        </div>
        <div class="col-sm-12">
            <div class="fv-row form-group mb-10">
                <label class="form-label required" for="">
                    Item Name
                </label>
                <div>
                    <input type="text" class="form-control" name="item_name" value="{{ $info->name ?? '' }}"
                        id="item_name" required>
                </div>
            </div>

        </div>
        {{-- <div class="col-sm-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label" for="">
                    Maximum Limit
                </label>
                <div>
                    <input type="text" class="form-control price" name="maximum_limit"
                        value="{{ $info->maximum_limit ?? '' }}" id="maximum_limit" >
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-sm-6">
            <div class="fv-row form-group mb-10 mt-2">
                <label class="form-label" for="">
                    Status
                </label>
                <div>
                    <input type="radio" id="active" class="form-check-input" value="active" name="status"
                        @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                    <label class="pe-3" for="active">Active</label>
                    <input type="radio" id="inactive" class="form-check-input" value="inactive" name="status"
                        @if (isset($info->status) && $info->status != 'active') checked @endif>
                    <label for="inactive">Inactive</label>
                </div>
            </div>
        </div> --}}

    </div>

    <div class="form-group mb-10 text-end">
        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
        <button type="button" class="btn btn-primary" id="form-submit-btn">
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
    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });
    var KTAppEcommerceSaveReligion = function() {

        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'section_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Tax Section is required'
                                },
                            }
                        },
                        'item_name': {
                            validators: {
                                notEmpty: {
                                    message: 'Item name is required'
                                },
                            }
                        }
                       
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Handle submit button
            submitButton.addEventListener('click', e => {
                e.preventDefault();

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {

                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('taxsection-item.save') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    // Disable submit button whilst loading
                                    submitButton.disabled = false;
                                    submitButton.removeAttribute(
                                        'data-kt-indicator');
                                    if (res.error == 1) {
                                        if (res.message) {
                                            res.message.forEach(element => {
                                                toastr.error("Error",
                                                    element);
                                            });
                                        }
                                    } else {
                                        toastr.success(
                                            "Tax Section Item added successfully");
                                        $('#kt_dynamic_app').modal('hide');

                                        dtTable.draw();

                                    }
                                }
                            })

                        }
                    });
                }
            })
        }

        return {
            init: function() {
                handleSubmit();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTAppEcommerceSaveReligion.init();
    });
</script>
