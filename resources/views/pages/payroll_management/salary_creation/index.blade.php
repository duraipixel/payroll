@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .netsalary {
            padding: 10px 20px;
            background: #b1e1fc;
        }

        .blur-loading {
            filter: blur(2px);
        }

        .pay-salary-month ul li {
            padding: 20px 10px;
            font-size: 15px;
            font-weight: 600;
            color: #173377;
            background-image: linear-gradient(120deg, #616789, #6464bf, #183479);
            background: #80808024;
            text-align: center;
            border-radius: 3px;
            box-shadow: 2px 2px 2px 2px #ddd;
        }

        .pay-salary-month ul li:hover {
            background: #ffffc4;
            box-shadow: 2px 2px 2px 2px #f9f9b8;
        }

        .pay-salary-month ul li.active {
            background: #1a3a88;
            box-shadow: 2px 2px 2px 2px #4e57d2;
            color: white;
        }

        .w-35 {
            width: 35% !important;
        }

        .w-30 {
            width: 30% !important;
        }

        .payrow:hover {
            background: #f6f7ff;
        }

        .payrow {
            border-bottom: 1px dashed #ddd
        }
    </style>
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="card-header border-0 pt-6">

            <div class="card-title w-100">
                <input type="hidden" name="from" value="@if (isset($staff_id) && !empty($staff_id)) 'staff' @endif">
                <div class=" w-100 custom_select position-relative my-1 salary-selection">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="pe-8">
                                <h4> Select Staff </h4>
                            </div>
                            <div class="form-group mt-3">

                                <select name="staff_id" id="staff_id" class="form-control"
                                    onchange="getSalaryHeadFields(this.value)" required>
                                    <option value="">--Select Employee--</option>
                                    @isset($employees)
                                        @foreach ($employees as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                                {{ $item->name }} - {{ $item->society_emp_code }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-4" id="payroll_button_pane">

                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-body py-4 @if (isset($staff_id) && !empty($staff_id)) @else d-none @endif" id="salary-creation-panel">
        </div>
        {{-- <div class="py-4 bg">
                @include('pages.payroll_management.salary_creation._list')
            </div> --}}
    </div>

@endsection

@section('add_on_script')
    <script>
        var staff_id = '{{ $staff_id }}';
        if (staff_id) {
            getSalaryHeadFields(staff_id);
        }
        var epf_values = '';

        function doAmountCalculation() {
            var earnings = 0;
            var deductions = 0;
            var netSalary = 0;
            var add_input = document.querySelectorAll('.add_input');
            var minus_input = document.querySelectorAll('.minus_input');
            var automatic_calculation_input = document.querySelector('.automatic_calculation');
            // console.log(automatic_calculation_input, 'automatic_calculation_input');
            add_input.forEach(element => {

                if (!$(element).is(':disabled')) {

                    if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                        earnings += parseFloat($(element).val());
                    }
                }
            });

            minus_input.forEach(element => {
                if (!$(element).is(':disabled')) {
                    if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                        deductions += parseFloat($(element).val());
                    }
                }
            });

            netSalary = earnings - deductions;
            $('#net_salary').val(netSalary.toFixed(2));
            $('#earnings_total').text(earnings.toFixed(2));
            $('#deduction_total').text(deductions.toFixed(2));
            // $('#net_salary_text').html(netSalary.toFixed(2));
        }

        function getNetSalary(amount, field_id = '', field_name = '') {
            // console.log(field_name, 'field_name');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('salary.get.field.amount') }}",
                type: 'POST',
                data: {
                    amount: amount,
                    field_id: field_id,
                    field_name: field_name
                },
                beforeSend: function() {

                },
                success: function(res) {

                    if (res.length > 0) {
                        res.map((item) => {
                            // console.log(item);
                            $('#' + item.short_name + '_input').val(item.basic_percentage_amount
                                .toFixed(2));
                        })
                    }
                    doAmountCalculation();

                    //    $('#amount_'+res)
                }
            });

        }

        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        function getInputValue(en) {

            let types = $(en).data('id');
            if (en.checked) {
                var inputName = $(`#${types}_input`).attr("name");
                $(`#${types}_input`).attr('disabled', false);
                var intValue = parseInt(inputName.match(/\d+/)[0]);
                $(`#addtional_tax_${intValue}`).attr('disabled', false);
                if (types.toLowerCase() == 'epf') {
                    /*
                    get pf amount based on nature of employement
                    */
                    let staff_id = $('#staff_id').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('salary.get.epf.amount') }}",
                        type: 'POST',
                        data: {
                            staff_id: staff_id,
                            types: types
                        },
                        beforeSend: function() {
                            /* 
                            do loader here  if needed 
                            */
                        },
                        success: function(res) {
                            epf_values = res.field_name;
                            let epf_value_arr = epf_values.split(",");
                            let total = 0;
                            epf_value_arr.map((item) => {
                                let sum = $('#' + item + '_input').val() || 0;
                                total += parseFloat(sum);
                            });
                            let percentage = res.percentage || 0;
                            let final_epf = (percentage / 100) * parseFloat(total);
                            final_epf = Math.round(final_epf);
                            $('#' + types + '_input').val(final_epf);

                            doAmountCalculation();
                        }
                    });
                } else if (types.toLowerCase() == 'esi') {
                    /*
                    get esi amount based on nature of employement
                    */
                   var esi_amount_gross = 0;
                    var add_input = document.querySelectorAll('.add_input');
                    add_input.forEach(element => {

                        if (!$(element).is(':disabled')) {

                            if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() !=
                                null) {
                                esi_amount_gross += parseFloat($(element).val());
                            }
                        }
                    });

                    let total = esi_amount_gross;
                    if( total > 21000 ) {
                        toastr.error('Error', 'Esi amount not eligible for greater than 21000');
                        $(`#${types}_input`).attr('disabled', false);
                        $('#' + types + '_input').val(0);
                        $(en).attr('checked', false);
                    } else {

                        let percentage = 0.75; //for esi percentage
                        let esi = (percentage / 100) * parseFloat(total);
                        esi = Math.round(esi);
                        $('#' + types + '_input').val(esi);
    
                        doAmountCalculation();
                    }
                }

            } else {

                $('#' + types + '_input').attr('disabled', true).prop('checked', false);

            }
            doAmountCalculation();
        }

        function getSalaryHeadFields(staff_id) {

            if (staff_id) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('salary.get.staff') }}",
                    type: 'POST',
                    data: {
                        staff_id: staff_id,
                    },
                    beforeSend: function() {
                        $('#payroll_button_pane').html('');
                        $('#salary-creation-panel').html('');
                        loading()
                    },
                    success: function(res) {
                        unloading();
                        $('#salary-creation-panel').removeClass('d-none');
                        $('#salary-creation-panel').html(res);
                    }
                });

            } else {
                $('#salary-creation-panel').addClass('d-none')
            }

        }

        function getPayrollDetails(staff_id) {

            if (staff_id) {

                $('#salary-creation-panel').removeClass('d-none');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('salary.get.staff') }}",
                    type: 'POST',
                    data: {
                        staff_id: staff_id,
                    },
                    beforeSend: function() {
                        $('#salary-creation-panel').addClass('blur-loading');
                    },
                    success: function(res) {
                        $('#salary-creation-panel').removeClass('blur-loading');
                        $('#salary-creation-panel').html(res);
                    }
                });

            } else {
                $('#salary-creation-panel').addClass('d-none')
            }

        }
    </script>
@endsection
