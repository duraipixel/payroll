@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        
    </style>
    <div class="card">
        <div class="month_row d-flex">
            @php
                $months = 4;
                $dates = date($from_year.'-03-01');
            @endphp
            @for ($i = 0; $i < 12; $i++)
            @php
                $dates = date('Y-m-d', strtotime($dates."+1 months"));
            @endphp
                <div id="payroll_month_{{ $months }}" role="button"
                    class="payroll_month @if ($i == 0) active @endif"
                    onclick="getPayrollOverviewInfo('{{ $dates }}', {{ $months }})">
                    {{-- <div class="month_name">{{ date('M', mktime(0, 0, 0, $months, 10)) }}</div> --}}
                    <div class="month_name">{{ date('M', strtotime($dates)) }}</div>
                    <div class="year">{{ date('Y', strtotime($dates)) }}</div>
                </div>
                @php
                if( $months == 12 ){
                    $months = 1;
                } else {

                    $months++;
                }
                @endphp
            @endfor
        </div>
    </div>
    <div class="card mt-3">
        <div class="payroll_info" id="payroll_overview_container">
           @include('pages.payroll_management.overview._ajax_month_view')
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        function getPayrollOverviewInfo(dates, month_no) {
            $('.payroll_month').removeClass('active');
            $('#payroll_month_' + month_no).addClass('active');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('payroll.get.month.chart') }}",
                type: 'POST',
                data: {
                    month_no: month_no,
                    dates:dates
                },
                success: function(res) {
                    $('#payroll_overview_container').html( res );
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
