<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #document_locker td {
            padding: 5px;
        }

        #document_locker th {
            padding: 5px;
        }
    </style>
    <div class="row container">
        <div class="col-md-4">
            <div class="alert alert-primary fade show" role="alert">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fa fa-users fs-2x" aria-hidden="true"></i>
                        <div class="my-3"> Total Staff </div>
                    </div>
                    <h3 class="display-6">{{ count($user) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-primary fade show" role="alert">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fa fa-file-text fs-2x" aria-hidden="true"></i>
                        <div class="my-3"> Total Documents </div>
                    </div>
                    <h3 class="display-6">{{ $total_documents }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-primary fade show" role="alert">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fa fa-clock fs-2x" aria-hidden="true"></i>
                        <div class="my-3"> Pending Documents </div>
                    </div>
                    <h3 class="display-6">{{ $review_pending_documents }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card border shadow-sm">
        <div class="card-header align-items-center justify-content-center bg-light">
            <div>
                <div class="input-group">
                    <select id="staff_id" name="staff_id" class="form-input">
                        <option value="">Select Staff</option>
                        @foreach ($user as $users)
                            <option value="{{ $users->id }}">{{ $users->name }} - {{ $users->society_emp_code }}
                            </option>
                        @endforeach
                    </select>
                    {{-- <select id="emp_nature_id" name="emp_nature_id" class="form-input">
                        <option value="">Nature Of Employment </option>
                        @foreach ($employee_nature as $employment_value)
                            <option value="{{ $employment_value->id }}">{{ $employment_value->name }}</option>
                        @endforeach
                    </select>
                    <select id="work_place_id" name="work_place_id" class="form-input">
                        <option value="">Place of Work</option>
                        @foreach ($place_of_work as $work_value)
                            <option value="{{ $work_value->id }}">{{ $work_value->name }}</option>
                        @endforeach
                    </select> --}}
                    <button type="button" class="btn btn-primary" id="search_doc_form">Search</button>
                </div>
            </div>
        </div>

        <div class="card-body p-10" id="defalut_div">
            <div class="col-12">
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table id="document_locker"
                        class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                        style="width:100%">
                        <thead class="bg-primary">
                            <tr class="text-start  text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class=" text-white" style="width:85px;">Staff ID</th>
                                <th class=" text-white">Staff Name</th>
                                <th class=" text-white">Department</th>
                                <th class=" text-white">Designation</th>
                                <th class=" text-white">Total Documents</th>
                                {{-- <th class="text-center text-white">Aprroved Documents</th> --}}
                                {{-- <th class="text-center text-white">Pending Documents</th> --}}
                                <th class="text-center text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="kt_dynamic_app"></div>
    </div>
    <!--end::Card-->
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@section('add_on_script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            var doc_table = $('#document_locker').DataTable({
                "serverSide": true,
                "processing": true,
                ajax: {
                    "url": "{{ route('user.document_locker') }}",
                    "dataType": "json",
                     "type": "GET",
                    "processing": true,
                    "data": function(d) {
                        d._token = "{{ csrf_token() }}",
                            d.staff_id = $('#staff_id').val()
                        // d.emp_nature_id = $('#emp_nature_id').val(),
                        // d.work_place_id = $('#work_place_id').val()
                    }
                },
                columns: [{
                        data: 'society_emp_code',
                        name: 'society_emp_code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'department_name',
                        data: 'department_name'
                    },
                    {
                        data: 'designation_name',
                        data: 'designation_name'
                    },
                    {
                        data: 'total_document',
                        data: 'total_document'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        sortable: false,
                        searchable: false,
                    },
                ],
        language: {
            paginate: {
                next: '<i class="fa fa-angle-right"></i>', // or '→'
                previous: '<i class="fa fa-angle-left"></i>' // or '←' 
            }
        },
        "pageLength": 25,
        "aLengthMenu": [
                [25, 50, 100, 200, 500, -1],
                [25, 50, 100, 200, 500, "All"]
            ]
        });
            document.getElementById('search_doc_form').addEventListener('click', function() {
                console.log('button clickced');
                doc_table.ajax.reload();
            })
        });

        $('#staff_id').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
        });
        $('#emp_nature_id').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
        });
        $('#work_place_id').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
        });

        //Option value based on Staff name  start
        function showOptions() {

            var staff_id = $("#staff_id").val();

            if (staff_id == '') {
                window.location.reload();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('user.show_options') }}",
                type: 'POST',
                data: {
                    staff_id: staff_id,

                },
                success: function(res) {
                    if (res.place_of_work != '' && res.emp_nature) {
                        $('#emp_nature_id').empty();
                        $("#emp_nature_id").append('<option>Nature Of Employment</option>');
                        var id = res.emp_nature['id'];
                        var name = res.emp_nature['name'];
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#emp_nature_id").append(option);

                        $('#work_place_id').empty();
                        $("#work_place_id").append('<option>Place of Work</option>');
                        var id = res.place_of_work['id'];
                        var name = res.place_of_work['name'];
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#work_place_id").append(option);
                    } else {
                        $('#emp_nature_id').empty();
                        $("#emp_nature_id").append('<option>Nature Of Employment</option>');

                        $('#work_place_id').empty();
                        $("#work_place_id").append('<option>Place of Work</option>');

                    }
                }
            })
        }

        //Option value based on Staff name  start

        // Search Staff details Start


        //Search Staff details End 
    </script>
@endsection
