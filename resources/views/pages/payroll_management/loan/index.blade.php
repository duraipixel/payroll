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
            width: 400px !important;
            text-align: center;
        }
    </style>
    <div class="card">
        <div class="card-header border-0 pt-6">
            @if (auth()->user()->is_super_admin)
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1 salary-selection">
                    <h4> Select Staff to Add Bank Loan </h4>
                    &emsp;
                    <select name="staff_id" id="staff_id" class="form-control w-450px px-5"
                        onchange="getSalaryBankLoans(this.value)">
                        <option value="">--Select Employee--</option>
                        @isset($employees)
                            @foreach ($employees as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->society_emp_code }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
            @endif
            <div class="card-toolbar">
                {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
            @php
                $route_name = request()->route()->getName();               
            @endphp
            @if (access()->buttonAccess($route_name, 'export'))
                <a type="button" class="btn btn-light-primary me-3 btn-sm" href="{{ route('salary-head.export') }}">
                    {!! exportSvg() !!} Export
                </a>
            @endif
            @if (access()->buttonAccess($route_name, 'add_edit'))
                <button type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="getSalaryHeadModal()">
                    {!! plusSvg() !!} Add Salary Head
                </button>
            @endif

            </div> --}}

            </div>
        </div>

        <div class="card-body py-4" id="bank_loan_form">

        </div>
    </div>


@endsection

@section('add_on_script')
    <script>
        @if (!auth()->user()->is_super_admin)
        getSalaryBankLoans('{{ auth()->user()->id }}');
        @endif
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        function getSalaryBankLoans(staff_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formMethod = "addEdit";
            $.ajax({
                url: "{{ route('ajax-view.loan') }}",
                type: 'POST',
                data: {
                    id: staff_id,
                },
                success: function(res) {
                    $('#bank_loan_form').html(res);
                }
            })

        }
    </script>
@endsection
