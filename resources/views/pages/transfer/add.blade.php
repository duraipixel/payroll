<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #revision_table td {
            padding-left: 10px;
            padding-right: 3px;
        }
    </style>
    <div class="card">
        <form id="staff_transfer_form">
            @csrf

            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <div class="form-group">
                            <label for="" class="fs-6"> Select Institutions <span class="text-danger">*</span></label>
                            <div>
                                <select name="from_institution_id" id="from_institution_id"
                                    class="form-control form-control-sm">
                                    <option value="">--select-- </option>
                                    @if (isset($institutions) && !empty($institutions))
                                        @foreach ($institutions as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group mx-3">
                            <label for="" class="fs-6">Transfer Institutions <span class="text-danger">*</span></label>
                            <div>
                                <select name="to_institution_id" id="to_institution_id"
                                    class="form-control form-control-sm">
                                    <option value="">--select-- </option>
                                    @if (isset($institutions) && !empty($institutions))
                                        @foreach ($institutions as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group mx-3">
                            <label for="" class="fs-6"> Effective From <span class="text-danger">*</span></label>
                            <div>
                                <input type="date" name="effective_from" id="effective_from" class="form-control  form-control-sm" required>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="form-group mx-3">
                        <label for="" class="fs-6"> Remarks <span class="text-danger">*</span></label>
                        <div>
                            <textarea name="remarks" id="remarks" cols="30" rows="1" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="form-group mx-3 mt-11">
                        <div>
                            <button class="btn btn-primary btn-sm" id="submit_btn" type="button" onclick="transferStaff()"> Transfer </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body py-4">
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="table-responsive d-none" id="transfer_form">
                        <div class="w-100 d-flex justify-content-end">
                            <div>
                                <label for="" class="mt-3 text-muted mx-3"> Search : </label>
                            </div>
                            <div class="w-300px text-end">
                                <input type="text" name="search" id="search" class="form-control form-control-sm">
                            </div>
                        </div>
                        <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                            id="transfer_table">
                            <thead class="bg-primary">
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="px-3 text-white">
                                        <div>
                                            <input role="button" type="checkbox" name="select_all" id="select_all">
                                        </div>
                                    </th>
                                    <th class="px-3 text-white">
                                        Emp Name
                                    </th>
                                    <th class="px-3 text-white">
                                        Emp Code
                                    </th>
                                    <th class="px-3 text-white">
                                        Institution Code
                                    </th>
                                    <th class="px-3 text-white">
                                        Email
                                    </th>
                                    <th class="px-3 text-white">
                                        Mobile No
                                    </th>
                                    <th class="px-3 text-white">
                                        Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-bold">
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        $('#select_all').change(function() {
            if (this.checked) {
                $('.revision_check').prop('checked', true);
            } else {
                $('.revision_check').attr('checked', false);
            }
        })

        var dtTable = $('#transfer_table').DataTable({

            processing: true,
            serverSide: true,
            type: 'POST',
            ajax: {
                "url": "{{ route('get.institute.staff') }}",
                "data": function(d) {
                    d.from_institution_id = $('#from_institution_id').val();
                    d.search = $('#search').val();
                }
            },
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox'
                },

                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'society_emp_code',
                    name: 'society_emp_code'
                },
                {
                    data: 'institute_emp_code',
                    name: 'institute_emp_code'
                },
                {
                    data: 'email',
                    name: 'email'
                },

                {
                    data: 'phone_no',
                    name: 'phone_no'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←' 
                }
            },
            "aaSorting": [],
            "pageLength": 25,
            "order": [],
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],
        });

        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');

        $('#from_institution_id').change(function() {
            var from_institution_id = $(this).val();
            if (from_institution_id == '' || from_institution_id == undefined) {
                $('#transfer_form').addClass('d-none');
                return false;
            }
            $('#transfer_form').removeClass('d-none');
            dtTable.draw();
            // $("#to_institution_id option:contains('"+from_institution_id+"')").attr("disabled","disabled");
            $("#to_institution_id option[value='" + from_institution_id + "']").attr('disabled', true);
        })

        $('#search').on('keyup',function(){
            dtTable.draw();
        })

        function transferStaff() {

            var to_institution_id = $('#to_institution_id').val();
            var from_institution_id = $('#from_institution_id').val();
            var effective_from = $('#effective_from').val();
            var remarks = $('#remarks').val();

            if (from_institution_id == '' || from_institution_id == undefined) {
                toastr.error('Error', 'Select From Intitution')
                return false;
            }

            if (to_institution_id == '' || to_institution_id == undefined) {
                toastr.error('Error', 'Select Transfer Intitution')
                return false;
            }
            if (effective_from == '' || effective_from == undefined) {
                toastr.error('Error', 'Select Effective From')
                return false;
            }
            if (remarks == '' || remarks == undefined) {
                toastr.error('Error', 'remarks is required')
                return false;
            }

            let count = $(".transfer_check:checked").length;
            if (count == 0) {
                toastr.error('Error', 'Select atleast one checkbox to continue')
                return false;
            }

            var fromData = $('#staff_transfer_form').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('staff.transfer.do') }}",
                type: 'POST',
                data: fromData,
                beforeSend:function(){
                    $('#submit_btn').attr('disabled', true );
                },
                success: function(res) {
                    $('#submit_btn').attr('disabled', false );

                    if( res.error == 0 ) {
                        toastr.success('Success', res.message );
                        setTimeout(() => {
                            window.location.href = "{{ route('staff.transfer') }}";
                        }, 500);
                    }

                }
            })

        }
    </script>
@endsection
