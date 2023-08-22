@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card mt-3">
        <div class="p-6">
            <h3> {{ $title }} </h3>
        </div>
        <form id="earnings_form" class="w-100 p-6">
            @csrf
            <input type="hidden" name="page_type" value="{{$page_type}}">
            <div class="row">
                {{-- <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">
                            Nature of Employement
                        </label>
                        <div>
                            <select name="nature_of_employement_id" id="nature_of_employement_id"
                                class="form-control form-control-sm" onchange="getEmployees()">
                                <option value="">All</option>
                                @if (isset($nature_of_employees) && !empty($nature_of_employees))
                                    @foreach ($nature_of_employees as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div> --}}
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="">
                            Employees
                        </label>
                        <div>
                            <select name="employee_id" id="employee_id" class="form-control form-control-sm" multiple>
                                <option value="all">All</option>
                                @if (isset($employees) && !empty($employees))
                                    @foreach ($employees as $items)
                                        <option value="{{ $items->id }}">{{ $items->name }} -
                                            {{ $items->institute_emp_code }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" id="earning_ajax_emp_table">
                    @include('pages.payroll_management.earnings._form_table')
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @include('pages.payroll_management.earnings._form_footer')
                </div>
            </div>
        </form>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#employee_id').select2({
            theme: 'bootstrap-5'
        });
        $('#select_all').change(function() {
            if (this.checked) {
                $('.bonus_check').prop('checked', true);
            } else {
                $('.bonus_check').attr('checked', false);
            }
        })

        function getEmployees() {

            var employee_id = $('#employee_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('earnings.get.table.view') }}",
                type: 'POST',
                data: {
                    employee_id: employee_id
                },
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    unloading();
                    $('#earning_ajax_emp_table').html(res);
                }
            })

        }

        $('#employee_id').on('select2:select', function(e) {

            var selectedValue = e.params.data.id;

            if (selectedValue === 'all') {
                $('#employee_id').val('all').trigger('change');
            } else if ($('#employee_id').val().includes('all')) {
                $('#employee_id').val(selectedValue).trigger('change');
            }

            getEmployees();

        });

        $('#employee_id').on('select2:unselect', function(e) {
            getEmployees();
        });

        function submitEarningsStaff() {

            let count = $(".bonus_check:checked").length;
            
            if (count == 0) {
                toastr.error('Error', 'Select atleast one Staff to continue')
                return false;
            }

            var formData = $('#earnings_form').serialize();
            $.ajax({
                url: "{{ route('earnings.save') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    loading();
                    $('#earning_btn').attr('disabled',  true );
                },
                success: function(res) {

                    unloading();
                    $('#earning_btn').attr('disabled',  false );
                    if( res.error == 1 ) {
                        toastr.error('Error', res.message );
                    } else {
                        toastr.success('Success', res.message );
                        setTimeout(() => {
                            window.location.href = res.return_url;
                        }, 500);

                    }

                }
            })
        }
    </script>
@endsection
