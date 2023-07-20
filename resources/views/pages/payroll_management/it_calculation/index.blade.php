<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
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
            </div>
        </div>
    </div>
    <div class=" mt-3">
        <div class="py-4" id="staff_tax_pane">
            
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        function getStaffTaxCalculationPane(staff_id) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('it-calculation.calculation.form') }}",
                type: 'POST',
                data: {staff_id:staff_id},
                success: function(res) {
                    $('#staff_tax_pane').html(res);
                }
            })
        }
    </script>
@endsection
