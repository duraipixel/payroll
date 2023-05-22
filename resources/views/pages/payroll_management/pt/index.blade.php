@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .salary-selection .select2-selection {
            /* height: 45px; */
            display: grid;
            align-items: center;
            justify-items: center;

        }

        .salary-selection .select2-container {
            width: 300px !important;
            text-align: center;
        }
    </style>
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="alert alert-warning w-100">
                    <small>
                        Recent research has indicated an increased risk of the occurrence of the brain and CNS tumors in
                        interventional radiologists and technicians
                    </small>
                </div>
            </div>
            <div class="card-toolbar">
            </div>
        </div>

        <div class="card-body py-4">
            <div class="card">
                <form id="slab_form">
                    @csrf
                    <div id="pt-slab">
                        <div class="row">
                            <div class="col-sm-12 text-end">
                                <div class="form-group mt-7">
                                    <button class="btn btn-sm btn-primary" type="button" onclick="addMoreSlab()"> Add More
                                    </button>
                                </div>
                            </div>
                        </div>
                        @isset($details)
                            @foreach ($details as $item)
                                <div class="row p-4 border border-1 each_row_slab">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Above Salary</label>
                                            <input type="text" name="above_salary[]" id="above_salary"
                                                class="form-control form-control-sm price" value="{{ $item->from_amount ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Less than or Equal Salay</label>
                                            <input type="text" name="lq_salary[]" id="lq_salary"
                                                class="form-control form-control-sm price" value="{{ $item->to_amount ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for=""> Tax Amount </label>
                                            <input type="text" name="tax_amount[]" id="tax_amount"
                                                class="form-control form-control-sm price" value="{{ $item->tax_fee ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-7">
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-danger remove_slab" type="button"> <i
                                                    class="fa fa-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset

                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 text-end">
                            <button class="btn btn-sm btn-primary" type="submit"> Submit </button>
                            <button class="btn btn-sm btn-dark"> Cancel </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        var slab_html = `<div class="row p-4 border border-1 each_row_slab">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Above Salary</label>
                                    <input type="text" name="above_salary[]" id="above_salary" class="form-control form-control-sm price" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Less than or Equal Salay</label>
                                    <input type="text" name="lq_salary[]" id="lq_salary" class="form-control form-control-sm price" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for=""> Tax Amount </label>
                                    <input type="text" name="tax_amount[]"  id="tax_amount" class="form-control form-control-sm price" required>
                                </div>
                            </div>
                            <div class="col-sm-3 mt-7">
                                <div class="form-group">
                                    <button class="btn btn-sm btn-danger remove_slab"  type="button"> <i class="fa fa-close"></i> </button>
                                </div>
                            </div>
                        </div>`;

        function addMoreSlab() {
            $('#pt-slab').append(slab_html);
        }

        $("#slab_form").on("submit", function(event) {

            event.preventDefault();
            var formData = $('#slab_form').serialize();
            $.ajax({
                url: "{{ route('save.professional-tax') }}",
                type: 'POST',
                data: formData,
                success: function(res) {
                    if (res.error) {
                        toastr.success('success', 'Slab added success');
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                }
            })

        });

        $('#slab_form').on('click', '.remove_slab', function() {
            var child = $(this).closest('.each_row_slab').remove();
        });
    </script>
@endsection
