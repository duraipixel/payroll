<div class="card">
    <style>
        #revision_table td {
            padding-left: 10px;
            padding-right: 3px;
        }

        .sticky-col {
            position: -webkit-sticky;
            position: sticky;
            background-color: white !important;
        }

        .first-col {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
            left: 0px;
        }

        .second-col {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
            left: 150px;
        }

        .third-col {
            width: 200px;
            min-width: 200px;
            max-width: 200px;
            left: 300px;
        }
    </style>
    {{-- @if( !payrollCheck( $dates, 'payroll' )) --}}
    {{-- <div class="card-header border-0 pt-6">
        <div class="alert alert-danger">
            Payroll statement settings locked. Please unlock to view statements
        </div>
    </div>
    @else --}}
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <input type="hidden" name="payroll_id" id="payroll_id" value="{{ $payroll_id ?? '' }}">
                <div class="form-group mx-3 w-300px">
                    <label for="" class="fs-6"> Select Employee </label>
                    <select name="staff_id" id="staff_id" class="form-control form-control-sm"
                        onchange="getTableDataPayrollList()">
                        <option value=""> All </option>
                        @isset($employees)
                            @foreach ($employees as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                    {{ $item->name }} - {{ $item->institute_emp_code }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label for="" class="fs-6"> Employee Nature </label>
                    <div>
                        <select name="nature_id" id="nature_id" class="form-control form-control-sm">
                            <option value="">All</option>
                            @if (isset($employee_nature) && !empty($employee_nature))
                                @foreach ($employee_nature as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name ?? '' }} </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <button type="button" class="btn btn-light-success me-3 btn-sm" onclick="exportExcelPayroll()">
                    Export to Excel
                </button>
            </div>
        </div>
    </div>

    <div class="card-body py-4">
        <div class="dataTables_wrapper dt-bootstrap4 no-footer" id="dataTagForPayroll">
            {{-- @include('pages.payroll_management.overview.statement._list') --}}
        </div>
    </div>
    
    <script>
        var month_no = '{{ $month_no }}';
        var dates = '{{ $dates }}';
        getTableDataPayrollList();

        function getTableDataPayrollList() {

            var staff_id = $('#staff_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('payroll.ajax.list') }}",
                type: 'POST',
                data: {
                    month_no: month_no,
                    dates: dates,
                    staff_id:staff_id
                },
                success: function(res) {
                    $('#dataTagForPayroll').html(res);
                },
                error: function(xhr, err) {
                    if (xhr.status == 403) {
                        toastr.error(xhr.statusText, 'UnAuthorized Access');
                    }
                }
            });

        }

        function exportExcelPayroll() {

            var payroll_id = $('#payroll_id').val();
            var staff_id = $('#staff_id').val();

            if( payroll_id == '' || payroll_id == undefined || payroll_id == 'undefined' ) {
                toastr.error('Error', 'Payroll data not found');
            } else {

                var pay_url = "{{ url('payroll/statement/export') }}" + '/' + payroll_id + '/' + staff_id;
                window.open(pay_url, '_blank')
            }
       

        }
    </script>
{{-- @endif --}}