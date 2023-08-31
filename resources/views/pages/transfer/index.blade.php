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
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <div class="form-group">
                        <label for="" class="fs-6"> Transfer Status </label>
                        <div>

                            <select name="transfer_status" id="transfer_status" class="form-control form-control-sm">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mx-3 w-300px">
                        <label for="" class="fs-6">Select Employee</label>
                        <select name="staff_id" id="staff_id" class="form-control form-control-sm">
                            <option value="">All</option>
                            @isset($users)
                                @foreach ($users as $item)
                                    <option value="{{ $item->staff->id }}" @if (isset($staff_id) && $staff_id == $item->staff->id) selected @endif>
                                        {{ $item->staff->name }} - {{ $item->staff->institute_emp_code }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    </div>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                    <button type="button" class="btn btn-light-success me-3 btn-sm"
                        onclick="changeTransferStatus('approved')">
                        Approve
                    </button>
                    <button type="button" class="btn btn-light-danger btn-sm" id="add_modal"
                        onclick="changeTransferStatus('rejected')">
                        Reject
                    </button>

                    <a href="{{ route('staff.transfer.add') }}" class="btn btn-primary btn-sm ms-3" >
                        Add New transfer
                    </a>

                </div>


            </div>
        </div>

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <form id="revision_form">
                        @csrf
                        <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                            id="revision_table">
                            <thead class="bg-primary">
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="px-3 text-white">
                                        <div>
                                            <input role="button" type="checkbox" name="select_all" id="select_all">
                                        </div>
                                    </th>
                                    <th class="px-3 text-white">
                                        Effective From Date
                                    </th>
                                    <th class="px-3 text-white">
                                        Emp Name
                                    </th>
                                    <th class="px-3 text-white">
                                        From Institution 
                                    </th>
                                    <th class="px-3 text-white">
                                        To Institution 
                                    </th>
                                    <th class="px-3 text-white">
                                        From Institution Code
                                    </th>
                                    <th class="px-3 text-white">
                                        To Institution Code
                                    </th>
                                    <th class="px-3 text-white">
                                        Transfer Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-bold">
                            </tbody>
                        </table>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#staff_id,#transfer_status').select2({
            theme: 'bootstrap-5'
        });

        $('#select_all').change(function() {
            if (this.checked) {
                $('.transfer_check').prop('checked', true);
            } else {
                $('.transfer_check').attr('checked', false);
            }
        })

        var dtTable = $('#revision_table').DataTable({

            processing: true,
            serverSide: true,
            type: 'POST',
            ajax: {
                "url": "{{ route('staff.transfer') }}",
                "data": function(d) {
                    d.staff_id = $('#staff_id').val();
                    d.transfer_status = $('#transfer_status').val();
                }
            },
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox'
                },

                {
                    data: 'effective_from',
                    name: 'effective_from'
                },
                {
                    data: 'staff.name',
                    name: 'name'
                },
                {
                    data: 'from.name',
                    name: 'from_institute_name'
                },
                {
                    data: 'to.name',
                    name: 'to_institute_name'
                },
                {
                    data: 'old_institution_code',
                    name: 'old_institution_code'
                },
                {
                    data: 'new_institution_code',
                    name: 'new_institution_code'
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
            "aLengthMenu": [
                    [25, 50, 100, 200, 500, -1],
                    [25, 50, 100, 200, 500, "All"]
                ]
        });

        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');

        $('#staff_id, #transfer_status').change(function() {
            dtTable.draw();
        })

        function changeTransferStatus(stat) {

            let count = $(".transfer_check:checked").length;
            var transfer_status = $('#transfer_status').val();
            if (count == 0) {
                toastr.error('Error', 'Select atleast one checkbox to continue')
                return false;
            }

            var fromData = $('#revision_form').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('staff.transfer.modal') }}",
                type: 'POST',
                data: fromData + '&status=' + stat + '&transfer_status=' + transfer_status,
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })

        }
    </script>
@endsection
