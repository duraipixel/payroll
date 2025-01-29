@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .staff_err{
            display:none;
        }
        .select2-container--focus{
            border: 1px solid black !important;
        }
    </style>
    <div class="card">
        <div class="month_row d-flex">
            @php
                $months = 1;
                $dates = date($from_year.'-01-01');
            @endphp
            @for ($i = 0; $i < 12; $i++)
            @php
                $date_per = date('Y-m-d', strtotime($dates."+".$i." months"));
            @endphp
                <div id="payroll_month_{{ $months }}" role="button"
                    class="payroll_month @if ($i == 0) active @endif"
                    onclick="getMonthAttendanceInfo('{{ $date_per }}', {{ $months }})">
                    {{-- <div class="month_name">{{ date('M', mktime(0, 0, 0, $months, 10)) }}</div> --}}
                    <div class="month_name">{{ date('M', strtotime($date_per)) }}</div>
                    <div class="year">{{ date('Y', strtotime($date_per)) }}</div>
                </div>
                @php
                if( $months == 12 ){
                    $months = 1;
                } else {

                    $months++;
                }

                @endphp
            @endfor
            <select id="year-picker" onchange="updateUrlWithYear()">
        @php
            // Set the range of years (e.g., 10 years before and 10 years after the current year)
            $currentYear = request()->get('year') ?? date('Y');
            $startYear = date('Y') - 40;  // 10 years ago
            $endYear = date('Y') + 1;    // 10 years in the future
        @endphp

        @for ($year = $startYear; $year <= $endYear; $year++)
            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
        @endfor
    </select>
        </div>
        
    </div>
    <div class="card mt-3">
        <div class="payroll_info" id="attendance_overview_container">
            
           {{-- @include('pages.attendance_management.attendance_manual_entry._ajax_month_data') --}}
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        getMonthAttendanceInfo('{{ $dates }}', )
        function getMonthAttendanceInfo(dates, month_no = '1') {
            $('.payroll_month').removeClass('active');
            $('#payroll_month_' + month_no).addClass('active');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('attendance.ajax.view') }}",
                type: 'POST',
                data: {
                    month_no: month_no,
                    dates:dates
                },
                success: function(res) {
                    $('#attendance_overview_container').html( res );
                },
                error: function(xhr, err) {
                    if (xhr.status == 403) {
                        toastr.error(xhr.statusText, 'UnAuthorized Access');
                    }
                }
            });

        }

        
    </script>
    <script>
        function updateUrlWithYear() {
            var selectedYear = document.getElementById("year-picker").value;
            var currentUrl = window.location.href;

            if (currentUrl.includes('?')) {
                window.location.href = currentUrl.replace(/(.*\?year=)(\d+)/, `$1${selectedYear}`);
            } else {
                window.location.href = currentUrl + '?year=' + selectedYear;
            }
        }
    </script>
@endsection
