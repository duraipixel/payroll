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
    </style>
    <div class="card">
        @if( auth()->user()->is_super_admin )
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1 salary-selection">
                    <h4> Select Staff to Add Insurance </h4>
                    &emsp;
                    <select name="staff_id" id="staff_id" class="form-control w-450px px-5"
                        onchange="getSalaryInsurance(this.value)">
                        <option value="">--Select Employee--</option>
                        @isset($employees)
                            @foreach ($employees as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->society_emp_code }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        @endif

        <div class="card-body py-4" id="lic_form_details">
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        @if(!auth()->user()->is_super_admin)
        getSalaryInsurance('{{ auth()->user()->id }}');
        @endif
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        function getSalaryInsurance(staff_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formMethod = "addEdit";
            $.ajax({
                url: "{{ route('ajax-view.lic') }}",
                type: 'POST',
                data: {
                    id: staff_id,
                },
                success: function(res) {
                    $('#lic_form_details').html(res);
                }
            })

        }
    </script>
@endsection
