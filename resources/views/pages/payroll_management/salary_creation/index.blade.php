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
            width: 300px !important;
            text-align: center;
        }

        .netsalary {
            padding: 10px 20px;
            background: #b1e1fc;
        }
    </style>
    <div class="card">

        <form>
        <div class="card-header border-0 pt-6">

            <div class="card-title w-100">

                <div class="d-flex w-100 align-items-center justify-content-center position-relative my-1 salary-selection">
                    <div class="pe-8">
                        <h4> Select Staff to create Salary Database </h4>
                    </div>
                    <select name="staff_id" id="staff_id" class="form-control w-450px"
                        onchange="getSalaryHeadFields(this.value)">
                        <option value="">--Select Employee--</option>
                        @isset($employees)
                            @foreach ($employees as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

            </div>
        </div>

        <div class="card-body py-4" id="salary-creation-panel">
            {{-- {{dd( $salary_heads[0]->fields )}} --}}
            <hr>
            <div class="row mt-3">
                <div class="col-sm-8 m-auto">

                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        @isset($salary_heads)
                            @foreach ($salary_heads as $item)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            {{ $item->name }}
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <div class="list-group">
                                                @if (isset($item->fields) && !empty($item->fields))
                                                    @foreach ($item->fields as $item_fields)
                                                        <label class="list-group-item p-3">
                                                            <input class="form-check-input me-1" type="checkbox"
                                                                data-id="{{ str_replace(' ', '_', $item_fields->short_name) }}"
                                                                onchange="getInputValue(this)" value="">
                                                            <span class="px-3"> {{ $item_fields->name }}
                                                                ({{ $item_fields->short_name }})
                                                            </span>
                                                            <input type="text" name="amount" onkeyup="getNetSalary(this.value)"
                                                                id="{{ str_replace(' ', '_', $item_fields->short_name) }}_input"
                                                                class="border border-2 float-end text-end price @if($item->id == '1') add_input @else minus_input @endif" disabled>
                                                        </label>
                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <h2 class="accordion-header netsalary" id="panelsStayOpen-headingOne">
                                Net Salary
                                <span class="float-end" >₹ <span id="net_salary_text">0.00</span></span>
                            </h2>
                        @endisset


                    </div>
                    <div class="form-group mt-5 text-end">
                        <button class="btn btn-primary btn-sm" type="submit"> Submit & Lock </button>
                        <a class="btn btn-dark btn-sm" href="{{route('salary.creation')}}" > Cancel </a>
                    </div>

                </div>
            </div>
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
    
            add_input.forEach(element => {
                console.log('first, ', $(element).val() );
                if( $(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null ){
                    earnings += parseFloat($(element).val());
                }
            });

            minus_input.forEach(element => {
                console.log('first, ', $(element).val() );
                if( $(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null ){
                    deductions += parseFloat($(element).val());
                }
            });

            netSalary = earnings - deductions;
            $('#net_salary_text').html( netSalary.toFixed(2) );
        }

        $('#staff_id').select2();

        function getInputValue(en) {

            let types = $(en).data('id');
            if (en.checked) {

                $('#' + types + '_input').attr('disabled', false);

            } else {

                $('#' + types + '_input').attr('disabled', true).prop('checked', false);

            }
        }

        function getSalaryHeadFields(staff_id) {
            console.log(staff_id)
        }
    </script>
@endsection
