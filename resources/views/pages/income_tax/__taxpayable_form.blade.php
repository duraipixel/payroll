<div class="row">
    <div class="col-sm-12">
        <div class="d-flex justify-content-between">
            <div class="from-group">
                <label> Tax Related Component </label>
            </div>
        </div>
    </div>
    @php
        // dd( $staff_details->staffSeperation  );
        $tax_payment = $statement_data->total_income_tax_payable;
        $round_off_taxable_gross_income = $statement_data->round_off_taxable_gross_income;
        $month_salary = $round_off_taxable_gross_income / 12;
        $allowed_max_tax = getPercentageAmount(40, $month_salary);
        
    @endphp
    <div class="col-sm-4 off-sm-4">
        <form id="tax_seperation_calc">
            @csrf
            <input type="hidden" name="income_tax_id" value="{{ $statement_data->id ?? '' }}">
            <table class="w-100 mt-5 border border-2" id="">
                <tr>
                    <th class="p-2"> Tax Payable </th>
                    <th class="p-2"> {{ $tax_payment }} </th>
                </tr>
                <tr>
                    <th class="p-2"> Apr </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->april ?? 0 }}" @if( isset($staff_details->staffSeperation->april) && !empty( $staff_details->staffSeperation->april ) ) readonly @endif name="apr_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> May </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->may ?? 0 }}" @if( isset($staff_details->staffSeperation->may) && !empty( $staff_details->staffSeperation->may ) ) readonly @endif name="may_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Jun </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->june ?? 0 }}" @if( isset($staff_details->staffSeperation->june) && !empty( $staff_details->staffSeperation->june ) ) readonly @endif name="jun_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Jul </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->july ?? 0 }}" @if( isset($staff_details->staffSeperation->july) && !empty( $staff_details->staffSeperation->july ) ) readonly @endif name="jul_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Aug </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->august ?? 0 }}" @if( isset($staff_details->staffSeperation->august) && !empty( $staff_details->staffSeperation->august ) ) readonly @endif name="aug_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Sep </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->september ?? 0 }}" @if( isset($staff_details->staffSeperation->september) && !empty( $staff_details->staffSeperation->september ) ) readonly @endif name="sep_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Oct </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->october ?? 0 }}" @if( isset($staff_details->staffSeperation->october) && !empty( $staff_details->staffSeperation->october ) ) readonly @endif name="oct_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Nov </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->november ?? 0 }}" @if( isset($staff_details->staffSeperation->november) && !empty( $staff_details->staffSeperation->november ) ) readonly @endif name="nov_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Dec </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->december ?? 0 }}" @if( isset($staff_details->staffSeperation->december) && !empty( $staff_details->staffSeperation->december ) ) readonly @endif name="dec_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Jan </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->january ?? 0 }}" @if( isset($staff_details->staffSeperation->january) && !empty( $staff_details->staffSeperation->january ) ) readonly @endif name="jan_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Feb </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->february ?? 0 }}" @if( isset($staff_details->staffSeperation->february) && !empty( $staff_details->staffSeperation->february ) ) readonly @endif name="feb_amount">
                    </td>
                </tr>
                <tr>
                    <th class="p-2"> Mar </th>
                    <td>
                        <input type="text" class="form-input text-end tax_month price"
                            onkeyup="return getTotalTaxPay(this)" value="{{ $staff_details->staffSeperation->march ?? 0 }}" @if( isset($staff_details->staffSeperation->march) && !empty( $staff_details->staffSeperation->march ) ) readonly @endif name="mar_amount">
                    </td>
                </tr>
                @if( isset($staff_details->staffSeperation->march) && !empty( $staff_details->staffSeperation->march ) )
                @else 
                <tr>
                    <th class="p-2"> Balance </th>
                    <td>
                        <input type="text" class="form-input text-end"  id="balance" readonly>
                    </td>
                </tr>
                @endif

            </table>
            <div class="col-sm-12 text-end mt-3">
                @if( isset($staff_details->staffSeperation->march) && !empty( $staff_details->staffSeperation->march ) )
                @else 
                <button type="button" id="tax_btn" class="btn btn-primary btn-sm d-none" onclick="submitTaxSeperationCalc()"> Save </button>
                @endif
            </div>
        </form>
    </div>
</div>


<script>
    var maximum_limit = '{{ $allowed_max_tax }}';
    var tax_payment = '{{ $tax_payment }}';

    function getTotalTaxPay(element) {

        maximum_limit = parseFloat(maximum_limit);
        amount = parseFloat(element.value);
        tax_payment = parseFloat(tax_payment);

        if (amount > maximum_limit) {
            toastr.error('Error', 'Maximum limit ' + maximum_limit + ' you can enter');
            element.value = '';
            return false;
        }

        var earnings = 0;
        console.log(maximum_limit, ' maximum_limit');
        var add_input = document.querySelectorAll('.tax_month');
        add_input.forEach(element => {
            if (!$(element).is(':disabled')) {
                if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                    earnings += parseFloat($(element).val());
                }
            }
        });
        let balance_amount = 0;
        balance_amount = tax_payment - earnings;
        if (balance_amount == 0) {
            $('#tax_btn').removeClass('d-none');
        } else {
            $('#tax_btn').addClass('d-none');
        }

        $('#balance').val(balance_amount);
    }

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    function submitTaxSeperationCalc() {

        Swal.fire({
            text: "Are you sure you would like to add tax separations?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            var formData = $('#tax_seperation_calc').serialize();
            $.ajax({
                url: "{{ route('it.tax.add') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#tax_btn').attr('disabled', true);
                },
                success: function(res) {
                    $('#tax_btn').attr('disabled', false);

                    if( res.error  == 0 ) {
                        Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });
                    } else {
                        Swal.fire({
                                title: "Error",
                                text: res.message,
                                icon: "danger",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                timer: 3000
                            });
                    }
                }
            })
        });

    }
</script>
