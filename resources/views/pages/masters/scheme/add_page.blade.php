@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #cke_document_model {
            width: 100% !important;
        }
    </style>
    <div class="card">

        <div class="card-header border-0 pt-6">
            <div class="card-title w-100">
                <div class="row w-100">
                    <div class="col-sm-8 offset-md-2">
                        <h3> {{ $title ?? '' }} </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <form action="" class="" id="dynamic_form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
                    <div class="row">
                        <div class="col-sm-4">

                            <div class="fv-row form-group mb-10">
                                <label class="form-label required">
                                    Scheme Name
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="scheme_name"
                                        value="{{ $info->name ?? '' }}" id="scheme_name" required>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="fv-row form-group mb-10">
                                <label class="form-label">
                                    Scheme Code
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="scheme_code"
                                        value="{{ $info->scheme_code ?? '' }}" id="scheme_code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="fv-row form-group mb-10">
                                <label class="form-label required">
                                    Start Time
                                </label>
                                <div>
                                    <input type="time" class="form-control" name="start_time"
                                        value="{{ isset($info->start_time) ? date('h:i', strtotime($info->start_time)) : '' }}" id="start_time" onchange="getTotalHours()"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="fv-row form-group mb-10">
                                <label class="form-label required">
                                    End Time
                                </label>
                                <div>
                                    <input type="time" class="form-control" name="end_time"
                                        value="{{ isset($info->end_time) ? date('h:i', strtotime($info->end_time)) : '' }}" id="end_time" onchange="getTotalHours()"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="fv-row form-group mb-10">
                                <label class="form-label required">
                                    Total Hours
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="totol_hours"
                                        value="{{ $info->totol_hours ?? '' }}" id="totol_hours" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 fv-row">
                            <label class="form-label">
                                Permission CutOff Time
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_only" maxlength="3"
                                    name="permission_cutoff_time" id="permission_cutoff_time" placeholder="CutOff Time"
                                    aria-label="Cutoff time" value="{{ $info->permission_cutoff_time ?? '' }}" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Minutes</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 fv-row">
                            <label class="form-label">
                                Late CutOff Time
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_only" maxlength="3"
                                    name="late_cutoff_time" id="late_cutoff_time" placeholder="CutOff Time"
                                    aria-label="Cutoff time" value="{{ $info->late_cutoff_time ?? '' }}" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Minutes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row form-group mb-10 mt-5">
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

                    <div class="form-group mb-10 text-end">
                        <a href="{{ route('scheme') }}" class="btn btn-light-primary" > Cancel </a>
                        <button type="button" class="btn btn-primary" id="form-submit-btn">
                            <span class="indicator-label">
                                Submit
                            </span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        function getTotalHours() {

            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();

            if (start_time && end_time) {

                start_time = start_time + ':00';
                end_time = end_time + ':00';

                var time_start = new Date();
                var time_end = new Date();
                var value_start = start_time.split(':');
                var value_end = end_time.split(':');

                time_start.setHours(value_start[0], value_start[1], value_start[2], 0)
                time_end.setHours(value_end[0], value_end[1], value_end[2], 0)

                var milliseconds = time_end - time_start;

                var d = new Date(1000 * Math.round(milliseconds / 1000)); // round to nearest second
                function pad(i) {
                    return ('0' + i).slice(-2);
                }
                var str = d.getUTCHours() + ':' + pad(d.getUTCMinutes());

                $('#totol_hours').val(str);
            }

        }

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
                            'scheme_name': {
                                validators: {
                                    notEmpty: {
                                        message: 'Scheme Name is required'
                                    },
                                }
                            },
                            'start_time': {
                                validators: {
                                    notEmpty: {
                                        message: 'Start Time is required'
                                    },
                                }
                            },
                            'end_time': {
                                validators: {
                                    notEmpty: {
                                        message: 'End Time is required'
                                    },
                                }
                            },
                            'totol_hours': {
                                validators: {
                                    notEmpty: {
                                        message: 'Total Hours is required'
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
                                submitButton.disabled = true;
                                var forms = $('#dynamic_form')[0];
                                var formData = new FormData(forms);
                                $.ajax({
                                    url: "{{ route('save.scheme') }}",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        // Disable submit button whilst loading
                                        submitButton.disabled = false;
                                      
                                        if (res.error == 1) {
                                            if (res.message) {
                                                res.message.forEach(element => {
                                                    toastr.error("Error",
                                                        element);
                                                });
                                            }
                                        } else {

                                            toastr.success("Scheme added successfully");
                                            setTimeout(() => {
                                                location.href = "{{ route('scheme') }}";
                                            }, 300);
                                            
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
@endsection
