@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #hold_table tbody td {
            padding-left: 10px;
        }
    </style>
    <div class="card">
        <div class="month_row d-flex">
            @php
                $months = 4;
                $dates = date('Y-03-01');
            @endphp
            @for ($i = 0; $i < 12; $i++)
                @php
                    $dates = date('Y-m-d', strtotime($dates . '+1 months'));
                @endphp
                <div id="payroll_month_{{ $months }}" role="button"
                    class="payroll_month @if (date('m') == $months) active @endif"
                    onclick="getEarningsView('{{ $dates }}', {{ $months }})">
                    {{-- <div class="month_name">{{ date('M', mktime(0, 0, 0, $months, 10)) }}</div> --}}
                    <div class="month_name">{{ date('M', strtotime($dates)) }}</div>
                    <div class="year">{{ date('Y', strtotime($dates)) }}</div>
                    <input type="radio" class="d-none payroll_hold_month" name="payroll_hold_month" id="payroll_hold_month"
                        @if (date('m') == $months) checked="checked" @endif value="{{ $dates }}">
                </div>
                @php
                    if ($months == 12) {
                        $months = 1;
                    } else {
                        $months++;
                    }
                @endphp
            @endfor
        </div>
    </div>

    <div class="card mt-3" >
        <div class="p-3 mx-7">
            <h3> {{ $title }} </h3>
        </div>
        <div id="earning_overview_container">
            @include('pages.payroll_management.earnings.'.$page_type.'_view_ajax')
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        function addHoldSalary(id = '') {
            var payroll_hold_month = $('input[name=payroll_hold_month].payroll_hold_month:checked').val();

            console.log(payroll_hold_month);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('holdsalary.add_edit') }}",
                type: 'POST',
                data: {
                    id: id,
                    payroll_hold_month: payroll_hold_month
                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })

        }

        function deleteHold(id) {
            Swal.fire({
                text: "Are you sure you would like to delete record?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('holdsalary.delete') }}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(res) {
                            dtTable.ajax.reload();
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

                        },
                        error: function(xhr, err) {
                            if (xhr.status == 403) {
                                toastr.error(xhr.statusText, 'UnAuthorized Access');
                            }
                        }
                    });
                }
            });
        }

        function getEarningsView(hdate, hmonth) {

            $('.payroll_month').removeClass('active');
            $('#payroll_month_' + hmonth).addClass('active');

            let payroll_hold_month = $('input[name=payroll_hold_month].payroll_hold_month:checked').val(hdate);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('earnings.table.view') }}",
                type: 'POST',
                data: {
                    month_no: hmonth,
                    dates: hdate,
                    from: 'date',
                    page_type: '{{ $page_type }}'
                },
                success: function(res) {
                    $('#earning_overview_container').html(res);
                },
                error: function(xhr, err) {
                    if (xhr.status == 403) {
                        toastr.error(xhr.statusText, 'UnAuthorized Access');
                    }
                }
            });

        }
    </script>
@endsection
