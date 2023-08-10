<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .swal2-icon.swal2-warning.swal2-icon-show {
            margin: 0 auto;
        }
        #deduction_table td {
            border-bottom: 1px solid #ddd;
        }

        .tax-calculation-table td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        .w-120px {
            width: 120px !important;
        }

        .border-bottom {
            border-bottom: 1px solid #ddd;
        }
        .deduct-div{
            padding: 3px;
        }
        .deduct-div:nth-of-type(odd) {
            background-color: #fbfdff;
        }

        .deduct-div:nth-of-type(even) {
            background-color: #f1f0f0;
        }
    </style>
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <div class="form-group mx-3 w-300px">
                        <label for="" class="fs-6">Select Employee</label>
                        <select name="staff_id" id="staff_id" class="form-control form-control-sm"
                            onchange="return getStaffTaxCalculationPane(this.value)">
                            <option value="">-select-</option>
                            @isset($employees)
                                @foreach ($employees as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                        {{ $item->name }} - {{ $item->society_emp_code }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    </div>
                </div>
            </div>
            <div class="card-toolbar">
                <div>

                    <div>
                        <label for=""> Generate Income Tax Calculation for all Employees</label>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-info" onclick="generateAllStaffCalculation()">Generate Calculation</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" mt-3">
        <div class="py-4" id="staff_tax_pane">
            @include('pages.payroll_management.it_calculation._list')
        </div>
    </div>
    <div class="h-400px d-flex justify-content-center align-items-center bg-white d-none" id="payroll-loading-all">
        <img src="{{ asset('assets/images/payroll-loading.gif') }}" class="" width="200" alt="">
        <div class="text-muted">
            Please wait while generating income tax calculation for all employees, It will tak more than one minute
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        function listTaxCalculation(lock_calculation = '') {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('it-calculation.list') }}",
                type: 'POST',
                data: {lock_calculation:lock_calculation},
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    unloading();
                    $('#staff_tax_pane').html(res);
                }
            })
        }


        function getStaffTaxCalculationPane(staff_id) {
            
            $('#staff_id').val(staff_id).select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('it-calculation.calculation.form') }}",
                type: 'POST',
                data: {staff_id:staff_id},
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    unloading();
                    $('#staff_tax_pane').html(res);
                }
            })
        }

        function generateAllStaffCalculation() {
            var generate_message = `<h3>Are you sure you would like to Generate Income Tax Calculation for all employees</h3>
                                        <div class="text-start small text-muted">1. This won't change or update the calculations that the employees have already generated.</div>
                                        <div class="text-start small text-muted mt-1">2. This will only be generated for those who failed to calculate their income taxes for the year.</div>
                                        <div class="text-start small text-muted mt-1">3. This will automatically lock the calculation of income taxes for those who owe nothing.
                                        <div class="text-start small text-muted mt-1">4. This won't lock income tax calculations for taxpayers who owe more than zero. You must manually lock their computation..
                                        `;
            Swal.fire({
                        text: "Are you sure you would like to Generate Income Tax Calculation for all employees",
                        html: generate_message,
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, Generate it!",
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
                                url: "{{ route('it-calculation.generate.all') }}",
                                type: 'POST',
                                beforeSend: function() {
                                    $('#payroll-loading-all').removeClass('d-none');
                                },
                                success: function(res) {
                                    if( res.message ) {
                                        $('#payroll-loading-all').addClass('d-none');

                                        Swal.fire({
                                            title: "Generated!",
                                            text: res.message,
                                            icon: "success",
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-success"
                                            },
                                            timer: 1000
                                        });

                                        listTaxCalculation();
                                    }
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
    </script>
@endsection
