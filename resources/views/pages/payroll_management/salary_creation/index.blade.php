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
    </style>
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif
        <form id="salary-calculation" name="salary-calculation" method="post" action="{{ route('salary.creation_add') }}">
            @csrf
            <div class="card-header border-0 pt-6">

                <div class="card-title w-100">
                    <input type="hidden" name="from" value="@if( isset( $staff_id ) && !empty($staff_id) ) 'staff' @endif">
                    <div
                        class="d-flex w-100 custom_select align-items-center justify-content-center position-relative my-1 salary-selection">
                        <div class="pe-8">
                            <h4> Select Staff to create Salary Database </h4>
                        </div>
                        <select name="staff_id" id="staff_id" class="form-control w-450px"
                            onchange="getSalaryHeadFields(this.value)" required>
                            <option value="">--Select Employee--</option>
                            @isset($employees)
                                @foreach ($employees as $item)
                                    <option value="{{ $item->id }}" @if( isset( $staff_id ) && $staff_id == $item->id ) selected @endif >{{ $item->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                </div>
            </div>

            <div class="card-body py-4 @if( isset( $staff_id ) && !empty( $staff_id ) ) @else d-none @endif" id="salary-creation-panel">
                {{-- {{dd( $salary_heads[0]->fields )}} --}}
                @if( isset( $staff_id ) && !empty( $staff_id ) )
                @include('pages.payroll_management.salary_creation.fields')
                @endif
            </div>
        </form>
    </div>

    </div>
@endsection

@section('add_on_script')
    <script>
        function getNetSalary(amount) {
            var earnings = 0;
            var deductions = 0;
            var netSalary = 0;
            var add_input = document.querySelectorAll('.add_input');
            var minus_input = document.querySelectorAll('.minus_input');
            var automatic_calculation_input = document.querySelector('.automatic_calculation');
            console.log(automatic_calculation_input, 'automatic_calculation_input');
            add_input.forEach(element => {
                console.log('first, ', $(element).val());
                if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                    earnings += parseFloat($(element).val());
                }
            });

            minus_input.forEach(element => {
                console.log('first, ', $(element).val());
                if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                    deductions += parseFloat($(element).val());
                }
            });

            netSalary = earnings - deductions;
            $('#net_salary').val(netSalary);
            $('#net_salary_text').html(netSalary.toFixed(2));
        }

        $('#staff_id').select2({ theme: 'bootstrap-5'});

        function getInputValue(en) {

            let types = $(en).data('id');
            if (en.checked) {

                $('#' + types + '_input').attr('disabled', false);

            } else {

                $('#' + types + '_input').attr('disabled', true).prop('checked', false);

            }
        }

        function getSalaryHeadFields(staff_id) {

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
                    beforeSend: function(){
                        $('#salary-creation-panel').addClass('blur-loading');
                    },
                    success: function(res) {
                        $('#salary-creation-panel').removeClass('blur-loading');
                        $('#salary-creation-panel').html( res );
                    }
                });

            } else {
                $('#salary-creation-panel').addClass('d-none')
            }

        }
    </script>
@endsection
