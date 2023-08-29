@extends('layouts.template')
@section('breadcrum')
    {{-- @include('layouts.parts.breadcrum') --}}
@endsection
@section('content')
    <style>
        #cke_document_model {
            width: 100% !important;
        }

    </style>
    <div class="card">
        <div class="card-body">

            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <form action="{{ route('appointment.orders.preview') }}"  method="POST" target="_blank" class="w-100" id="dynamic_form" >
                    @csrf
                    <div class="row w-100">
                        <div class="col-sm-12">
                            <div class="row">
                              
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-8">

                                            <div class="fv-row form-group mb-10 editor-container ">
                                                <textarea name="document_model" id="document_model" class="form-control document_model" cols="30" rows="10">{{ $info->document ?? '' }}</textarea>
                                            </div>
                                            <div class="fv-row form-group mb-1">
                                                <label class="form-label" for="">
                                                    Status
                                                </label>
                                                <div>
                                                    <input type="radio" id="active" class="form-check-input" value="1"
                                                        name="status"
                                                        @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                                                    <label class="pe-3" for="active">Active</label>
                                                    <input type="radio" id="inactive" class="form-check-input" value="0"
                                                        name="status" @if (isset($info->status) && $info->status != 'active') checked @endif>
                                                    <label for="inactive">Inactive</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="col-sm-12 text-start">
                                                <h3>
                                                    Appointment Order Models
                                                </h3>
                                            </div>
                                            <div class="form-group mb-1 text-end">
                                                <a href="{{ route('appointment.orders') }}" class="btn btn-light-primary btn-sm"> Cancel
                                                </a>
                                                
                                                <button type="submit" class="btn btn-info btn-sm ms-2"> Preview </button>
                                                &emsp;
                                                <button type="button" class="btn btn-primary btn-sm" id="form-submit-btn">
                                                    <span class="indicator-label">
                                                        Submit
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait... <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $info->id ?? '' }}">

                                            <div class="fv-row form-group mb-2">
                                                <label class="form-label required" for="">
                                                    Order Model Name
                                                </label>
                                                <div>
                                                    <input type="text" class="form-control" name="order_model" id="order_model"
                                                        value="{{ $info->name ?? '' }}" required>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-hover"
                                                style="caret-color: transparent;">
                                                <tr>
                                                    <td>
                                                        <h3>
                                                            Available Dynamic Variables
                                                        </h3>

                                                    </td>
                                                </tr>
                                                @if (config('constant.appointment_variables'))
                                                    @foreach (config('constant.appointment_variables') as $item)
                                                        <tr>
                                                            <td role="button">
                                                                {{-- <span class="fw-code-copy w-100">
                                                                    <code>${{ $item }}</code>
                                                                    <button
                                                                        class="fw-code-copy-button btn btn-sm btn-success">Copy</button>
                                                                </span> --}}
                                                                <div class="d-flex">
                                                                    <label
                                                                        class="w-75 variable">${{ $item }}</label>

                                                                    <button type="button"
                                                                        class="w-25 fw-code-copy-button btn btn-sm btn-success">Copy</button>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </table>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
    <script>
        new Clipboard(".fw-code-copy-button", {
            text: function(trigger) {
                let copytext = $(trigger).parent().find('.variable').text().trim();
                if (copytext != '') {
                    toastr.success("Copied success");
                }
                return copytext;
            }
        });

        var document_model = CKEDITOR.replace('document_model', {
            // Make the editing area bigger than default.
            height: 500,
            width: 1020,
            toolbar: 'Full',
            language: 'en',
            extraPlugins: 'font,spacingsliders,panelbutton,justify,copyformatting,pagebreak',
            allowedContent: true,

            // Fit toolbar buttons inside 3 rows.
            removeButtons: 'ExportPdf,Form,Checkbox,Radio,TextField,Select,Textarea,Button,ImageButton,HiddenField,NewPage,CreateDiv,Flash,Iframe,About,ShowBlocks,Maximize',

            contentsCss: [
                'http://cdn.ckeditor.com/4.21.0/full-all/contents.css',
                'https://ckeditor.com/docs/ckeditor4/4.21.0/examples/assets/css/pastefromword.css'
            ],

            bodyClass: 'document-editor'
        });


        var KTAppEcommerceSavePlace = function() {

            const handleSubmit = () => {

                let validator;

                const form = document.getElementById('dynamic_form');
                const submitButton = document.getElementById('form-submit-btn');

                validator = FormValidation.formValidation(
                    form, {
                        fields: {
                            'order_model': {
                                validators: {
                                    notEmpty: {
                                        message: 'Order Model is required'
                                    },
                                }
                            },
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

                submitButton.addEventListener('click', e => {
                    e.preventDefault();
                    var data = CKEDITOR.instances.document_model.getData();

                    if (validator) {
                        validator.validate().then(function(status) {

                            if (status == 'Valid') {

                                var forms = $('#dynamic_form')[0];
                                var formData = new FormData(forms);
                                formData.append('document_data', data);
                                $.ajax({
                                    url: "{{ route('appointment.orders.save') }}",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {

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
                                                "Appointment Order Model saved successfully"
                                            );

                                            setTimeout(() => {
                                                window.location.href =
                                                    "{{ route('appointment.orders') }}";
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
            KTAppEcommerceSavePlace.init();
        });
    </script>
@endsection
