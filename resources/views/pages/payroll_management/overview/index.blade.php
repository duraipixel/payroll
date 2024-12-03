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
                $months = $start_month = 4;
                $dates = date($from_year.'-03-01');
                $start_year = '';
            @endphp
            @for ($i = 0; $i < 12; $i++)
            @php
                $dates = date('Y-m-d', strtotime($dates."+1 months"));
                if( $i ==  0) {
                    $start_year = $dates;
                }
                $curremnt= \Carbon\Carbon::now()->month;
            @endphp
                <div id="payroll_month_{{ $months }}" role="button"
                    class="payroll_month @if(date('m') == date('m', strtotime($dates))) active @endif"
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
           {{-- @include('pages.payroll_management.overview._ajax_month_view') --}}
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        @if($start_month == 4 )
        getPayrollOverviewInfo('{{ $start_year }}',date('m'));
        @endif

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
                beforeSend: function(){
                    loading();
                },
                success: function(res) {
                    unloading();
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
