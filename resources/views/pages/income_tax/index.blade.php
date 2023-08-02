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
    </style>
    <div class="card">
        @if (auth()->user()->is_super_admin)
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <div class="form-group mx-3 w-300px">
                            <label for="" class="fs-6">Select Employee</label>
                            <select name="staff_id" id="staff_id" class="form-control form-control-sm"
                                onchange="return getStaffTaxPane(this.value)">
                                <option value="">-select-</option>
                                @isset($employees)
                                    @foreach ($employees as $item)
                                        <option value="{{ $item->id }}" @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                            {{ $item->name }}
                                            - {{ $item->society_emp_code }}
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
        @else
        {{-- <input type="hidden" class="d-none" name="staff_id" id="staff_id" value="{{ auth()->user()->id }}"> --}}
        @endif

        <div class="card-body py-4" id="staff_tax_pane">

        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        @if (!auth()->user()->is_super_admin)
        getStaffTaxPane('{{ auth()->user()->id }}');
        @endif

        $('#staff_id,#scheme_id, #section_id').select2({
            theme: 'bootstrap-5'
        });
        $('.table-select').select2({
            theme: 'bootstrap-5'
        })

        function getTaxTabInfo(tab) {

            $('.tax-link').removeClass('active');
            $('.tax-link.' + tab).addClass('active');

            var staff_id = $('#staff_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('it.tab') }}",
                type: 'POST',
                data: {
                    tab: tab,
                    staff_id: staff_id
                },
                beforeSend: function() {
                    loading()
                    $('#tab_load_content').addClass('blur_loading_3px');
                },
                success: function(res) {
                    unloading();
                    $('#tab_load_content').removeClass('blur_loading_3px');
                    $('#tab_load_content').html(res);
                }
            })
        }

        function getStaffTaxPane(staff_id) {
            if (staff_id == '') {
                $('#staff_tax_pane').addClass('d-none');
                return false;
            }
            var tab = 'income';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('it.tab') }}",
                type: 'POST',
                data: {
                    staff_id: staff_id,
                    from: 'staff'
                },
                beforeSend: function() {
                    $('#staff_tax_pane').addClass('d-none');
                },
                success: function(res) {
                    if (res) {
                        $('#staff_tax_pane').removeClass('d-none');
                        $('#staff_tax_pane').html(res);
                        getTaxTabInfo(tab);
                    }
                }
            })
        }
    </script>
@endsection
